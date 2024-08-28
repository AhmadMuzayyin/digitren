<?php

namespace App\Http\Controllers\Santri;

use App\Exports\SantriExport;
use App\Helpers\Whatsapp;
use App\Http\Controllers\Controller;
use App\Http\Requests\SantriRequest;
use App\Imports\SantriImport;
use App\Models\AlamatSantri;
use App\Models\Kamar;
use App\Models\KamarSantri;
use App\Models\KelasSantri;
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
use Yajra\DataTables\Facades\DataTables;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $santri = Santri::with([
            'user:id,name,email',
            'wali_santri',
        ])->select('id', 'no_induk', 'jenis_kelamin', 'tanggal_lahir', 'user_id', 'foto', 'status', 'tahun_masuk')
            ->orderBy('id', 'desc');
        // dd($santri->paginate(1));
        if (request()->ajax()) {
            return DataTables::of($santri)
                ->addIndexColumn()
                ->addColumn('wali_santri', function ($santri) {
                    return $santri->wali_santri;
                })
                ->addColumn('action', 'pages.santri.include.action')
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && $request->search['value'] != '') {
                        $search = $request->search['value'];
                        $query->where(function ($q) use ($search) {
                            $q->where('no_induk', 'like', "%{$search}%")
                                ->orWhere('jenis_kelamin', 'like', "%{$search}%")
                                ->orWhere('status', 'like', "%{$search}%")
                                ->orWhereHas('user', function ($q) use ($search) {
                                    $q->where('name', 'like', "%{$search}%")
                                        ->orWhere('email', 'like', "%{$search}%");
                                });
                        });
                    }
                })
                ->toJson();
        }
        return view('pages.santri.index');
    }
    public function show(Santri $santri)
    {
        $santri->load('user', 'wali_santri', 'kamar_santri',  'kelas_santri', 'alamat_santri', 'alamat_santri.provinsi', 'alamat_santri.kabupaten', 'alamat_santri.kecamatan', 'alamat_santri.kelurahan');
        return view('pages.santri.detail', [
            'item' => $santri,
        ]);
    }
    public function store(SantriRequest $request)
    {
        $validate = $request->validated();
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
            $kamar_santri['kamar_id'] = $validate['kamar'];
            $kelas_santri['kelas_id'] = $validate['kelas'];
            $validate['tahun_masuk_hijriyah'] = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $validate['status'] = isset($request->tanggal_boyong) == true ? 'Santri Alumni' : 'Santri Aktif';
            $validate['whatsapp'] = $request->whatsapp;
            $tgl = Carbon::parse($request->tanggal_boyong);
            $validate['tanggal_boyong_hijriyah'] = isset($request->tanggal_boyong) ? str_replace('/', '-', $tgl->toHijri()->isoFormat('LL')) : '';
            $validate['whatsapp'] = Whatsapp::make($validate['whatsapp']);
            $foto = $request->file('foto');
            if (isset($foto) == true) {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();

                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }

                Image::make($foto->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validate['foto'] = $filename;
            } else {
                $validate['foto'] = 'santri.png';
            }
            $user = User::create([
                'name' => $request->nama_lengkap,
                'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                'password' => bcrypt('password'),
                'role_id' => 4,
            ]);
            $user->assignRole('Santri');
            $validate['user_id'] = $user->id;
            $validate['nik'] = request()->input('nik');
            $validate['kk'] = request()->input('kk');
            $santri = Santri::create($validate);
            KamarSantri::create([
                'santri_id' => $santri->id,
                'kamar_id' => $kamar_santri['kamar_id']
            ]);
            KelasSantri::create([
                'santri_id' => $santri->id,
                'kelas_id' => $kelas_santri['kelas_id']
            ]);
            $alamat = AlamatSantri::create([
                'santri_id' => $santri->id,
                'provinsi_id' => $validate['provinsi_id'],
                'kabupaten_id' => $validate['kabupaten_id'],
                'kecamatan_id' => $validate['kecamatan_id'],
                'kelurahan_id' => $validate['kelurahan_id'],
                'dusun' => $validate['dusun'],
            ]);
            // insert wali santri
            $wali = WaliSantri::create([
                'santri_id' => $santri->id,
                'nama_ayah' => $validate['nama_ayah'],
                'nama_ibu' => $validate['nama_ibu'],
            ]);
            if (!$santri) {
                $user->delete();
                $wali->delete();
                $alamat->delete();
            } else {
                User::find($validate['user_id'])->assignRole('Santri');
            }
            Toastr::success('Berhasil menambah data');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menambah data');

            return redirect()->back();
        }
    }
    public function edit(Santri $santri)
    {
        return view('pages.santri.edit', [
            'item' => $santri->load('user', 'wali_santri', 'kamar_santri', 'kelas_santri', 'alamat_santri'),
        ]);
    }
    public function update(SantriRequest $request, Santri $santri)
    {
        $validate = $request->validated();
        try {
            $date = Carbon::parse($request->tahun_masuk);
            $replace_delimiter = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $get_thn = explode('-', $replace_delimiter);
            $tahun_masuk = end($get_thn);
            $params = [
                'tahun_masuk_hijriyah' => $tahun_masuk,
                'tahun_masuk' => $request->tahun_masuk,
                'gender' => $request->jenis_kelamin,
            ];
            if ($validate['jenis_kelamin'] !== $santri->jenis_kelamin) {
                $validate['no_induk'] = Helper::make_noinduk($params);
            }
            $kamar_santri['kamar_id'] = $validate['kamar'];
            $kelas_santri['kelas_id'] = $validate['kelas'];
            $validate['tahun_masuk_hijriyah'] = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            $validate['status'] = isset($request->tanggal_boyong) == true ? 'Santri Alumni' : 'Santri Aktif';
            $tgl = Carbon::parse($request->tanggal_boyong);
            $validate['tanggal_boyong_hijriyah'] = isset($request->tanggal_boyong) ? str_replace('/', '-', $tgl->toHijri()->isoFormat('LL')) : '';
            $validate['tanggal_boyong'] = $request->tanggal_boyong;
            $validate['whatsapp'] = Whatsapp::make($validate['whatsapp']);

            $foto = $request->file('foto');
            if (isset($foto) == true) {
                $path = storage_path('app/public/uploads/santri/');
                $filename = $foto->hashName();
                if (!file_exists($path)) {
                    mkdir($path, 0777, true);
                }
                Image::make($foto->getRealPath())->resize(240, 295, function ($constraint) {
                    $constraint->upsize();
                    $constraint->aspectRatio();
                })->save($path . $filename);
                $validate['foto'] = $filename;
            } else {
                $validate['foto'] = $santri->foto;
            }
            User::where('id', $santri->user_id)->update([
                'name' => $request->nama_lengkap,
                'email' => 'santri_' . Str::slug($request->nama_lengkap) . config('app.domain'),
                'password' => bcrypt('password'),
            ]);
            if ($santri->alamat_santri) {
                AlamatSantri::where('santri_id', $santri->id)->update([
                    'provinsi_id' => $validate['provinsi_id'],
                    'kabupaten_id' => $validate['kabupaten_id'],
                    'kecamatan_id' => $validate['kecamatan_id'],
                    'kelurahan_id' => $validate['kelurahan_id'],
                    'dusun' => $validate['dusun'],
                ]);
            } else {
                AlamatSantri::create([
                    'santri_id' => $santri->id,
                    'provinsi_id' => $validate['provinsi_id'],
                    'kabupaten_id' => $validate['kabupaten_id'],
                    'kecamatan_id' => $validate['kecamatan_id'],
                    'kelurahan_id' => $validate['kelurahan_id'],
                    'dusun' => $validate['dusun'],
                ]);
            }
            $kamar = KamarSantri::where('santri_id', $santri->id)->first();
            $kelas = KelasSantri::where('santri_id', $santri->id)->first();
            if ($kamar) {
                $kamar->update([
                    'kamar_id' => $kamar_santri['kamar_id']
                ]);
            } else {
                KamarSantri::create([
                    'santri_id' => $santri->id,
                    'kamar_id' => $kamar_santri['kamar_id']
                ]);
            }
            if ($kelas) {
                $kelas->update([
                    'kelas_id' => $kelas_santri['kelas_id']
                ]);
            } else {
                KelasSantri::create([
                    'santri_id' => $santri->id,
                    'kelas_id' => $kelas_santri['kelas_id']
                ]);
            }
            $wali = WaliSantri::where('santri_id', $santri->id)->first();
            if ($wali) {
                $wali->update([
                    'nama_ayah' => $validate['nama_ayah'],
                    'nama_ibu' => $validate['nama_ibu'],
                ]);
            } else {
                WaliSantri::create([
                    'santri_id' => $santri->id,
                    'nama_ayah' => $validate['nama_ayah'],
                    'nama_ibu' => $validate['nama_ibu'],
                ]);
            }
            $validate['nik'] = request()->input('nik');
            $validate['kk'] = request()->input('kk');
            $santri->update($validate);
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
            if ($santri->foto != 'santri.png') {
                $filePath = "public/uploads/santri/$santri->foto";
                if (Storage::exists($filePath)) {
                    Storage::delete($filePath);
                }
            }
            $santri->tabungan()->delete();
            $santri->transaksi_tabungan()->delete();
            $santri->user()->delete();
            $santri->wali_santri()->delete();
            $santri->kamar_santri()->delete();
            $santri->kelas_santri()->delete();
            Toastr::success('Berhasil menghapus data');
            return to_route('santri.index');
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');
            return redirect()->back();
        }
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
    public function export(Request $request)
    {
        $santri = [];
        if ($request->status[0] == 'Semua Santri') {
            $santri = Santri::with('user', 'wali_santri', 'kamar', 'kelas')->get()->pluck('status');
        } else {
            $santri = Santri::with('user', 'wali_santri', 'kamar', 'kelas')->where('status', $request->status)->get()->pluck('status');
        }
        dd($request->status[0], $santri);

        return Excel::download(new SantriExport($santri), 'Export-data-santri.xlsx');
    }
}
