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
            'name' => 'Administrator',
            'email' => 'admin@digitren.com',
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::create([
            'name' => 'Operator Tabungan',
            'email' => 'keuangan@digitren.com',
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::create([
            'name' => 'Pengurus Pondok',
            'email' => 'pengurus@digitren.com',
            'password' => bcrypt('password'),
        ]);

        $kelas = \App\Models\Kelas::create([
            'tingkatan' => 'ALFIYAH',
            'kelas' => 'ALFIYAH SATU',
            'keterangan' => 'Asuhan K. Zain Fairuz',
        ]);
        \App\Models\Kamar::create([
            'nama' => 'As Syafii',
            'blok' => 'A',
        ]);
        $kamar = \App\Models\Kamar::create([
            'nama' => 'Anwarul Qulubi',
            'blok' => 'A',
        ]);
        // $user = \App\Models\User::create([
        //     'name' => 'Ahmad Muzayyin',
        //     'email' => 'ahmad-muzayyin@digitren.com',
        //     'password' => bcrypt('password'),
        // ]);
        // \App\Models\Santri::create([
        //     'user_id' => $user->id,
        //     'kelas_id' => $kelas->id,
        //     'kamar_id' => $kamar->id,
        //     'no_induk' => '14450001',
        //     'dusun' => 'Mandala Barat',
        //     'desa' => 'Gadu Barat',
        //     'kecamatan' => 'Ganding',
        //     'kabupaten' => 'Sumenep',
        //     'jenis_kelamin' => 'Laki-Laki',
        //     'nik' => '3576014403910003',
        //     'kk' => '3576014403910003',
        //     'whatsapp' => '6285155353793',
        //     'tanggal_lahir' => '15',
        //     'bulan_lahir' => '5',
        //     'tahun_lahir' => '1999',
        //     'tempat_lahir' => 'Sumenep',
        //     'tahun_masuk' => date('Y-m-d'),
        //     'tahun_masuk_hijriyah' => '1445',
        //     'status' => 'Santri Aktif',
        // ]);

        $this->call(RoleSeeder::class);
        \App\Models\TahunAkademik::create([
            'tahun_akademik' => date('y'),
            'semester' => 'Genap'
        ]);
        \App\Models\TahunAkademik::create([
            'tahun_akademik' => date('y'),
            'semester' => 'Ganjil'
        ]);
    }
}
