<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\TahunAkademik;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

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
            'kode' => 'KGJWF31042',
            'tingkatan' => 'ALFIYAH',
            'kelas' => 'ALFIYAH SATU',
            'keterangan' => 'Asuhan K. Zain Fairuz',
        ]);
        \App\Models\Kamar::create([
            'kode' => 'OKRGX22240',
            'nama' => 'As Syafii',
            'blok' => 'A',
        ]);
        $kamar = \App\Models\Kamar::create([
            'kode' => 'OLKJS33440',
            'nama' => 'Anwarul Qulubi',
            'blok' => 'A',
        ]);
        TahunAkademik::create([
            'tahun_akademik' => date('y'),
            'semester' => 'Genap',
        ]);
        TahunAkademik::create([
            'tahun_akademik' => date('y'),
            'semester' => 'Ganjil',
        ]);

        // sample data
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

        //        $jsonFile = File::get(public_path('wilayah/provinsi.json'));
        //        $data = json_decode($jsonFile);

        // Iterasi data JSON dan simpan ke database
        //        foreach ($data as $item) {
        //            $jsonFile = File::get(public_path("wilayah/kabupaten/$item->id.json"));
        //            $kabupaten = json_decode($jsonFile);
        //
        //            $pr = Provinsi::create([
        //                'name' => ucwords(strtolower($item->nama)),
        //            ]);
        //            foreach ($kabupaten as $kb) {
        //                $jsonFile = File::get(public_path("wilayah/kecamatan/$kb->id.json"));
        //                $kecamatan = json_decode($jsonFile);
        //
        //                $kbptn = Kabupaten::create([
        //                    'provinsi_id' => $pr->id,
        //                    'name' => ucwords(strtolower($kb->nama)),
        //                ]);
        //
        //                foreach ($kecamatan as $kc) {
        //                    $jsonFile = File::get(public_path("wilayah/kelurahan/$kc->id.json"));
        //                    $kelurahan = json_decode($jsonFile);
        //
        //                    $kcm = Kecamatan::create([
        //                        'kabupaten_id' => $kbptn->id,
        //                        'name' => ucwords(strtolower($kc->nama)),
        //                    ]);
        //
        //                    foreach ($kelurahan as $kl) {
        //                        Kelurahan::create([
        //                            'kecamatan_id' => $kcm->id,
        //                            'name' => ucwords(strtolower($kl->nama)),
        //                        ]);
        //                    }
        //                }
        //
        //            }
        //
        //        }
    }
}
