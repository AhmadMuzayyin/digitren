<?php

namespace App\Imports;

use App\Models\Santri;
use App\Models\User;
use App\Models\WaliSantri;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SantriImport implements ToModel, WithHeadingRow
{
    public function model(array $row): void
    {
        // TODO: Implement model() method.
        $user = User::create([
            'name' => $row['nama'],
            'email' => Str::slug($row['nama']).'@digitren.com',
            'password' => bcrypt('password'),
        ]);
        $santri = Santri::create([
            'user_id' => $user->id,
            'kelas_id' => $row['kelas_id'],
            'kamar_id' => $row['kamar_id'],
            'no_induk' => $row['no_induk'],
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
            'tahun_masuk_hijriyah' => $row['tahun_masuk_hijriyah'],
            'tanggal_boyong' => $row['tanggal_boyong'],
            'tanggal_boyong_hijriyah' => $row['tanggal_boyong_hijriyah'],
            'status' => $row['status'],
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
    }
}
