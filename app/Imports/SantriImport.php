<?php

namespace App\Imports;

use Toastr;
use App\Models\User;
use App\Models\Kamar;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\WaliSantri;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): void
    {
        // TODO: Implement model() method.
        try {
            DB::beginTransaction();
            $kamar = Kamar::where('kode', $row['kode_kamar'])->first();
            $kelas = Kelas::where('kode', $row['kode_kelas'])->first();
            $status = isset($row['tanggal_boyong']) ? 'Santri Alumni' : 'Santri Aktif';
            $no_induk = null;
            $tahun_masuk_hijriyah = null;
            if (isset($row['tahun_masuk'])) {
                // get tahun hijriyah
                $date = Carbon::parse($row['tahun_masuk']);
                $replace_delimiter = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
                // explode ambil tahun untuk no induk
                $get_thn = explode('-', $replace_delimiter);
                $tahun_masuk = end($get_thn);
                $params = [
                    'tahun_masuk_hijriyah' => $tahun_masuk,
                    'tahun_masuk' => $row['tahun_masuk'],
                    'gender' => $row['jenis_kelamin'],
                ];
                $no_induk = \Helper::make_noinduk($params);
                $tahun_masuk_hijriyah = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            }

            // get tahun hijriyah
            $tanggal_boyong_hijriyah = null;
            if (isset($row['tanggal_boyong'])) {
                $date = Carbon::parse($row['tanggal_boyong']);
                $tanggal_boyong_hijriyah = str_replace('/', '-', $date->toHijri()->isoFormat('L'));
            }
            // dd($tanggal_boyong_hijriyah, isset($row['tanggal_boyong']));

            // save user santri
            $user = User::create([
                'name' => $row['nama'],
                'email' => Str::slug($row['nama']).'@digitren.com',
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Santri');
            // dd($user);
            $santri = Santri::create([
                'user_id' => $user->id,
                'kelas_id' => $kelas->id,
                'kamar_id' => $kamar->id,
                'no_induk' => $no_induk,
                'dusun' => $row['dusun'],
                'desa' => $row['desa'],
                'kecamatan' => $row['kecamatan'],
                'kabupaten' => $row['kabupaten'],
                'provinsi' => $row['provinsi'],
                'jenis_kelamin' => $row['jenis_kelamin'],
                'nik' => $row['nik'],
                'kk' => $row['kk'],
                'whatsapp' => $row['whatsapp'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'bulan_lahir' => $row['bulan_lahir'],
                'tahun_lahir' => $row['tahun_lahir'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tahun_masuk' => $row['tahun_masuk'],
                'tahun_masuk_hijriyah' => $tahun_masuk_hijriyah,
                'tanggal_boyong' => $row['tanggal_boyong'],
                'tanggal_boyong_hijriyah' => $tanggal_boyong_hijriyah,
                'status' => $status,
            ]);
            WaliSantri::create([
                'santri_id' => $santri->id,
                'nama' => $row['nama_ayah'],
                'wali' => true,
            ]);
            WaliSantri::create([
                'santri_id' => $santri->id,
                'nama' => $row['nama_ibu'],
                'wali' => false,
            ]);
            $kamar = Kamar::findOrFail($santri->kamar_id);
            if ($kamar) {
                $kamar->jumlah_santri = $kamar->jumlah_santri + 1;
                $kamar->save();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            Toastr::error('Gagal import data santri');
        }
    }
}
