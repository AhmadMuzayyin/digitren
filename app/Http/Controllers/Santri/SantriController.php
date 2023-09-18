<?php

namespace App\Http\Controllers\Santri;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use Toastr;

class SantriController extends Controller
{
    public function index()
    {
        $santri = Santri::with('user', 'wali_santri', 'kamar', 'kelas')->get();

        return view('pages.santri.index', compact('santri'));
    }

    public function print_kts(Santri $santri)
    {
        return view('pages.santri.print', compact('santri'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'kelas' => 'required|exists:kelas,id',
            'kamar' => 'required|exists:kamars,id',
            'nama_lengkap' => 'required|string|min:3|max:225',
            'dusun' => 'required|min:3',
            'desa' => 'required|min:3',
            'kecamatan' => 'required|min:3',
            'kabupaten' => 'required|min:3',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|digits:16',
            'kk' => 'required|digits:16',
            'whatsapp' => 'required|numeric|digits:11',
            'tanggal_lahir' => 'required|numeric|min:1|max:31',
            'bulan_lahir' => 'required|numeric|min:1|max:12',
            'tahun_lahir' => 'required',
            'tempat_lahir' => 'required|string',
            'tahun_masuk' => 'required',
            'tanggal_boyong' => 'nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);

        try {
            // get tahun hijriyah
            $date = Carbon::parse($request->tahun_masuk);
            $replace_delimiter = str_replace('/', '-', $date->toHijri()->isoFormat('L'));

            // explode ambil tahun untuk no induk
            $get_thn = explode('-', $replace_delimiter);
            $tahun_masuk = end($get_thn);

            // make no by tahun
            $params = [
                'tahun_masuk_hijriyah' => $tahun_masuk,
                'tahun_masuk' => $request->tahun_masuk,
                'gender' => $request->jenis_kelamin,
            ];
            $validate['no_induk'] = Helper::make_noinduk($params);

            // validate replace with column name
            $validate['kamar_id'] = $validate['kamar'];
            $validate['kelas_id'] = $validate['kelas'];
            $validate['tahun_masuk_hijriyah'] = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $validate['status'] = isset($request->tanggal_boyong) == true ? 'Santri Alumni' : 'Santri Aktif';
            $validate['whatsapp'] = '62'.$request->whatsapp;
            $tgl = Carbon::parse($request->tanggal_boyong);
            $validate['tanggal_boyong_hijriyah'] = isset($request->tanggal_boyong) ? str_replace('/', '-', $tgl->toHijri()->isoFormat('LL')) : '';

            $foto = $request->file('foto');
            if (isset($foto) == false) {
                $user = User::create([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_'.Str::slug($request->nama_lengkap).'@digitren.com',
                    'password' => bcrypt('password'),
                    'role_id' => 4,
                ]);
                $user->assignRole('Santri');
                $validate['user_id'] = $user->id;
                $santri = Santri::create($validate);
                if (! $santri) {
                    $user->delete();
                }
                // insert wali santri
                if ($santri) {
                    WaliSantri::create([
                        'santri_id' => $santri->id,
                        'nama' => $validate['nama_ayah'],
                        'wali' => true,
                    ]);
                    WaliSantri::create([
                        'santri_id' => $santri->id,
                        'nama' => $validate['nama_ibu'],
                        'wali' => false,
                    ]);
                }
            } else {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($foto->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path.$filename);

                // insert user login santri
                $user = User::create([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_'.Str::slug($request->nama_lengkap).'@digitren.net',
                    'password' => bcrypt('password'),
                ]);

                // insert santri
                $validate['user_id'] = $user->id;
                $validate['foto'] = $filename;
                $santri = Santri::create($validate);

                // insert wali santri
                WaliSantri::create([
                    'santri_id' => $santri->id,
                    'nama' => $validate['nama_ayah'],
                    'wali' => true,
                ]);
                WaliSantri::create([
                    'santri_id' => $santri->id,
                    'nama' => $validate['nama_ibu'],
                    'wali' => false,
                ]);
            }

            // update kamar
            $kamar = Kamar::where('id', $validate['kamar_id'])->first();
            $kamar->update([
                'jumlah_santri' => $kamar->jumlah_santri + 1,
            ]);

            Toastr::success('Berhasil menambah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menambah data');

            return redirect()->back();
        }
    }

    public function update(Request $request, Santri $santri)
    {
        $validate = $request->validate([
            'kelas' => 'required|exists:kelas,id',
            'kamar' => 'required|exists:kamars,id',
            'nama_lengkap' => 'required|string|min:3|max:225',
            'dusun' => 'required|min:3',
            'desa' => 'required|min:3',
            'kecamatan' => 'required|min:3',
            'kabupaten' => 'required|min:3',
            'jenis_kelamin' => 'required|in:Laki-Laki,Perempuan',
            'nik' => 'required|digits:16',
            'kk' => 'required|digits:16',
            'whatsapp' => 'required|numeric|digits:13',
            'tanggal_lahir' => 'required|numeric|min:1|max:31',
            'bulan_lahir' => 'required|numeric|min:1|max:12',
            'tahun_lahir' => 'required',
            'tempat_lahir' => 'required|string',
            'tahun_masuk' => 'required',
            'tanggal_boyong' => 'nullable',
            'nama_ayah' => 'required',
            'nama_ibu' => 'required',
        ]);
        try {
            // get tahun hijriyah
            $date = Carbon::parse($request->tahun_masuk);
            $replace_delimiter = str_replace('/', '-', $date->toHijri()->isoFormat('L'));

            // explode ambil tahun untuk no induk
            $get_thn = explode('-', $replace_delimiter);
            $tahun_masuk = end($get_thn);

            // make no by tahun
            $params = [
                'tahun_masuk_hijriyah' => $tahun_masuk,
                'tahun_masuk' => $request->tahun_masuk,
                'gender' => $request->jenis_kelamin,
            ];
            if ($validate['jenis_kelamin'] !== $santri->jenis_kelamin) {
                $validate['no_induk'] = Helper::make_noinduk($params);
            }

            // validate replace with column name
            $validate['kamar_id'] = $validate['kamar'];
            $validate['kelas_id'] = $validate['kelas'];
            $validate['tahun_masuk_hijriyah'] = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $validate['status'] = isset($request->tanggal_boyong) == true ? 'Santri Alumni' : 'Santri Aktif';
            $tgl = Carbon::parse($request->tanggal_boyong);
            $validate['tanggal_boyong_hijriyah'] = isset($request->tanggal_boyong) ? str_replace('/', '-', $tgl->toHijri()->isoFormat('LL')) : '';

            $foto = $request->file('foto');
            if (isset($foto) == false) {
                $user = User::where('id', $santri->user_id)->update([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_'.Str::slug($request->nama_lengkap).'@digitren.net',
                    'password' => bcrypt('password'),
                ]);
                $santri->update($validate);
                if (! $santri) {
                    $user->delete();
                }
                // update wali santri
                if ($santri) {
                    $wali = WaliSantri::where('santri_id', $santri->id);
                    if ($wali->get()) {
                        WaliSantri::create([
                            'santri_id' => $santri->id,
                            'nama' => $validate['nama_ayah'],
                            'wali' => true,
                        ]);
                        WaliSantri::create([
                            'santri_id' => $santri->id,
                            'nama' => $validate['nama_ibu'],
                            'wali' => false,
                        ]);
                    } else {
                        $wali->where('wali', true)->update([
                            'santri_id' => $santri->id,
                            'nama' => $validate['nama_ayah'],
                            'wali' => true,
                        ]);
                        $wali->where('wali', false)->update([
                            'santri_id' => $santri->id,
                            'nama' => $validate['nama_ibu'],
                            'wali' => false,
                        ]);
                    }
                }
            } else {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();

                if (! file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($foto->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path.$filename);

                // update user login santri
                $user = User::where('id', $santri->user_id)->update([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_'.Str::slug($request->nama_lengkap).'@digitren.net',
                    'password' => bcrypt('password'),
                ]);

                // update santri
                $validate['foto'] = $filename;
                $santri->update($validate);

                // update wali santri
                WaliSantri::where('santri_id', $santri->id)->where('wali', true)->update([
                    'santri_id' => $santri->id,
                    'nama' => $validate['nama_ayah'],
                    'wali' => true,
                ]);
                WaliSantri::where('santri_id', $santri->id)->where('wali', false)->update([
                    'santri_id' => $santri->id,
                    'nama' => $validate['nama_ibu'],
                    'wali' => false,
                ]);
            }

            Toastr::success('Berhasil merubah data');

            return redirect()->back();
        } catch (\Illuminate\Database\QueryException $th) {
            dd($th->getMessage());
            Toastr::error('Gagal merubah data');

            return redirect()->back()->withInput();
        }
    }

    public function destroy(Santri $santri)
    {
        try {
            $kamar = Kamar::where('id', $santri->kelas_id)->first();
            $kamar->update([
                'jumlah_santri' => $kamar->jumlah_santri - 1,
            ]);
            if ($santri->foto != 'santri.png') {
                $filePath = "public/uploads/santri/$santri->foto";
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            $santri->tabungan()->delete();
            $santri->transaksi_tabungan()->delete();
            $santri->user()->delete();
            Toastr::success('Berhasil menghapus data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
