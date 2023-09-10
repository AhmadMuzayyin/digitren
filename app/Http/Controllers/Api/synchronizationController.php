<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Carbon\Carbon;
use Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class synchronizationController extends Controller
{
    // function for sync kelas
    public function get_kelas()
    {
        $kelas = Kelas::all();

        return response()->json([
            'status' => true,
            'message' => 'get all data kelas',
            'data' => $kelas,
        ], 200);
    }

    public function store_kelas(Request $request)
    {
        $validate = $request->validate([
            'tingkatan' => 'required|min:3',
            'kelas' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);
        try {
            $kelas = Kelas::create($validate);

            return response()->json([
                'status' => true,
                'message' => 'successfully created data',
                'data' => $kelas,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'error created data',
            ], 401);
        }
    }

    // function for sync kelas
    public function get_santri()
    {
        $kelas = Kelas::all();

        return response()->json([
            'status' => true,
            'message' => 'get all data kelas',
            'data' => $kelas,
        ], 200);
    }

    public function store_santri(Request $request)
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
                    'email' => 'santri_'.Str::slug($request->nama_lengkap).'@digitren.net',
                    'password' => bcrypt('password'),
                ]);
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

            return response()->json([
                'status' => true,
                'message' => 'successfully created data',
                'data' => $santri,
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => 'error created data',
            ], 401);
        }
    }
}
