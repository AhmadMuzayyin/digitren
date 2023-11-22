<?php

namespace App\Http\Controllers\Santri;

use App\Exports\SantriExport;
use App\Http\Controllers\Controller;
use App\Imports\SantriImport;
use App\Models\Alumni;
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
use Maatwebsite\Excel\Facades\Excel;
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

    public function download()
    {
        $mime = Storage::mimeType('Format import data santri.xlsx');

        return response()->download(public_path('files/') . 'Format import data santri.xlsx', 'Format import data santri.xlsx', ['Content-Type' => $mime]);

        return redirect()->back();
    }

    public function import(Request $request)
    {
        try {
            $request->validate([
                'file' => 'required',
            ]);
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                Excel::import(new SantriImport, $file);
            }

            Toastr::success('Berhasil import data santri');

            return redirect()->back();
        } catch (\Throwable $th) {
            // dd($th->getMessage());
            Toastr::error('Gagal import data santri');

            return redirect()->back();
        }
    }

    public function export()
    {
        return Excel::download(new SantriExport, 'Export-data-santri.xlsx');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'kelas' => 'required|exists:kelas,id',
            'kamar' => 'required|exists:kamars,id',
            'nama_lengkap' => 'required|string|min:3|max:225',
            'provinsi' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'dusun' => 'required',
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
            $validate['provinsi'] = Helper::prov($request->provinsi);
            $validate['kabupaten'] = Helper::kab($request->provinsi, $request->kabupaten);
            $validate['kecamatan'] = Helper::kec($request->kabupaten, $request->kecamatan);
            $validate['desa'] = Helper::kel($request->kecamatan, $request->desa);
            $validate['kamar_id'] = $validate['kamar'];
            $validate['kelas_id'] = $validate['kelas'];
            $validate['tahun_masuk_hijriyah'] = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $validate['status'] = isset($request->tanggal_boyong) == true ? 'Santri Alumni' : 'Santri Aktif';
            $validate['whatsapp'] = '62' . $request->whatsapp;
            $tgl = Carbon::parse($request->tanggal_boyong);
            $validate['tanggal_boyong_hijriyah'] = isset($request->tanggal_boyong) ? str_replace('/', '-', $tgl->toHijri()->isoFormat('LL')) : '';

            $foto = $request->file('foto');
            if (isset($foto) == false) {
                $user = User::create([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                    'password' => bcrypt('password'),
                    'role_id' => 4,
                ]);
                // insert wali santri
                $wali = WaliSantri::create([
                    'nama_ayah' => $validate['nama_ayah'],
                    'nama_ibu' => $validate['nama_ibu'],
                ]);
                $user->assignRole('Santri');
                $validate['user_id'] = $user->id;
                $validate['wali_santri_id'] = $wali->id;
                $santri = Santri::create($validate);
                if (!$santri) {
                    $user->delete();
                    $wali->delete();
                } else {
                    User::find($validate['user_id'])->assignRole('Santri');
                }
            } else {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($foto->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);

                // insert user login santri
                $user = User::create([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                    'password' => bcrypt('password'),
                ]);
                // insert wali santri
                $wali = WaliSantri::create([
                    'nama_ayah' => $validate['nama_ayah'],
                    'nama_ibu' => $validate['nama_ibu'],
                ]);

                // insert santri
                $validate['user_id'] = $user->id;
                $validate['foto'] = $filename;
                $validate['wali_santri_id'] = $wali->id;
                $santri = Santri::create($validate);
                if (!$santri) {
                    $user->delete();
                    $wali->delete();
                } else {
                    User::find($validate['user_id'])->assignRole('Santri');
                }
            }

            // update kamar
            if (!$request->tanggal_boyong){
                $kamar = Kamar::where('id', $validate['kamar_id'])->first();
                $kamar->update([
                    'jumlah_santri' => $kamar->jumlah_santri + 1,
                ]);
            }

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
            'provinsi' => 'required',
            'desa' => 'required',
            'kecamatan' => 'required',
            'kabupaten' => 'required',
            'dusun' => 'required',
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
            if ($request->edit_alamat == true) {
                $validate['provinsi'] = Helper::prov($request->provinsi);
                $validate['kabupaten'] = Helper::kab($request->provinsi, $request->kabupaten);
                $validate['kecamatan'] = Helper::kec($request->kabupaten, $request->kecamatan);
                $validate['desa'] = Helper::kel($request->kecamatan, $request->desa);
            } else {
                $validate['provinsi'] = $request->provinsi;
                $validate['kabupaten'] = $request->kabupaten;
                $validate['kecamatan'] =  $request->kecamatan;
                $validate['desa'] = $request->desa;
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
                    'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                    'password' => bcrypt('password'),
                ]);
                $santri->update($validate);
                if (!$santri) {
                    $user->delete();
                }
                // update wali santri
                if ($santri) {
                    $wali = WaliSantri::where('id', $santri->wali_santri_id)->get();
                    if ($wali) {
                        WaliSantri::create([
                            'nama_ayah' => $validate['nama_ayah'],
                            'nama_ibu' => $validate['nama_ibu'],
                        ]);
                    }
                }
            } else {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($foto->getRealPath())->resize(400, 400, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);

                // update user login santri
                $user = User::where('id', $santri->user_id)->update([
                    'name' => $request->nama_lengkap,
                    'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                    'password' => bcrypt('password'),
                ]);

                // update santri
                $validate['foto'] = $filename;
                $santri->update($validate);

                // update wali santri
                WaliSantri::where('id', $santri->wali_santri_id)->update([
                    'nama_ayah' => $validate['nama_ayah'],
                    'nama_ibu' => $validate['nama_ibu'],
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
            $kamar = Kamar::where('id', $santri->kamar_id)->first();
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
