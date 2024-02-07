<?php

namespace App\Imports;

use App\Models\Kamar;
use App\Models\Kelas;
use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Toastr;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): void
    {
        // TODO: Implement model() method.
        try {
            DB::beginTransaction();
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

            // save user santri
            $user = User::create([
                'name' => $row['nama'],
                'email' => Str::slug($row['nama']).config('app.domain'),
                'password' => bcrypt('password'),
            ]);
            if (isset($row['tanggal_boyong'])) {
                $user->assignRole('Alumni');
            } else {
                $user->assignRole('Santri');
            }

            // save wali santri
            $wali = WaliSantri::create([
                'nama_ayah' => $row['nama_ayah'],
                'nama_ibu' => $row['nama_ibu'],
            ]);

            $kamar_id = null;
            $kelas_id = null;
            if (isset($row['kode_kamar']) == true && isset($row['kode_kelas']) == true) {
                $kamar = Kamar::where('kode', $row['kode_kamar'])->first();
                $kelas = Kelas::where('kode', $row['kode_kelas'])->first();
                $kamar_id = $kamar->id;
                $kelas_id = $kelas->id;

                $kamar->update([
                    'jumlah_santri' => $kamar->jumlah_santri + 1,
                ]);
            }
            $santri = Santri::create([
                'user_id' => $user->id,
                'kelas_id' => $kelas_id,
                'kamar_id' => $kamar_id,
                'wali_santri_id' => $wali->id,
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
            ]);
            if (! $santri) {
                $user->delete();
                $wali->delete();
            }
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            Toastr::error('Gagal import data santri');
        }
    }
}
