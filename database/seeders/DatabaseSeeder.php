<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(50)->create();
        \App\Models\User::create([
            'name' => 'Ahmad Muzayyin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ]);
        $kelas = \App\Models\Kelas::create([
            'tingkatan' => 'ALFIYAH',
            'kelas' => 'ALFIYAH SATU',
        ]);
        \App\Models\Kamar::create([
            'nama' => 'As Syafii',
            'blok' => 'A',
        ]);
        $kamar = \App\Models\Kamar::create([
            'nama' => 'Anwarul Qulubi',
            'blok' => 'A',
            'jumlah_santri' => 1
        ]);
        $user = \App\Models\User::create([
            'name' => 'Ahmad Muzayyin',
            'email' => 'ahmad-muzayyin@digitren.net',
            'password' => bcrypt('password'),
        ]);
        \App\Models\Santri::create([
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'kamar_id' => $kamar->id,
            'no_induk' => '14450001',
            'dusun' => 'Mandala Barat',
            'desa' => 'Gadu Barat',
            'kecamatan' => 'Ganding',
            'kabupaten' => 'Sumenep',
            'jenis_kelamin' => 'Laki-Laki',
            'nik' => '3576014403910003',
            'kk' => '3576014403910003',
            'whatsapp' => '6285155353793',
            'tanggal_lahir' => '15',
            'bulan_lahir' => '5',
            'tahun_lahir' => '1999',
            'tempat_lahir' => 'Sumenep',
            'tahun_masuk' => date('Y-m-d'),
            'tahun_masuk_hijriyah' => '1445',
            'status' => 'Santri Aktif',
        ]);
    }
}
