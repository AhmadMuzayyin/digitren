<?php

namespace App\Imports;

use App\Models\Kamar;
use App\Models\Kelas;
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
        $kamar = Kamar::where('kode', $row['kode_kamar'])->first();
        $kelas = Kelas::where('kode', $row['kode_kelas'])->first();
        $user = User::create([
            'name' => $row['nama'],
            'email' => Str::slug($row['nama']).'@digitren.com',
            'password' => bcrypt('password'),
        ]);
        $santri = Santri::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'kamar_id' => $kamar->id,
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
        $kamar = Kamar::findOrFail($santri->kamar_id);
        if ($kamar){
            $kamar->jumlah_santri = $kamar->jumlah_santri + 1;
            $kamar->save();
        }
    }
}
