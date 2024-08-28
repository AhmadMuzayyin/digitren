<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
use App\Models\Setting;
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
            'email' => 'admin' . config('app.domain'),
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::create([
            'name' => 'Operator Tabungan',
            'email' => 'keuangan' . config('app.domain'),
            'password' => bcrypt('password'),
        ]);
        \App\Models\User::create([
            'name' => 'Pengurus Pondok',
            'email' => 'pengurus' . config('app.domain'),
            'password' => bcrypt('password'),
        ]);
        $kelas = \App\Models\Kelas::create([
            'kode' => 'KGJWF31042',
            'tingkatan' => 'ALFIYAH',
            'kelas' => 'Kelas Umum',
        ]);
        \App\Models\Kamar::create([
            'kode' => 'OKRGX22240',
            'nama' => 'Kamar Umum',
            'blok' => 'A',
        ]);
        $this->call(RoleSeeder::class);
        Setting::create([
            'whatsapp_feature' => false,
            'log_activity' => false,
        ]);
        $jsonFile = File::get(public_path('wilayah/provinsi.json'));
        $data = json_decode($jsonFile);
        // foreach ($data as $item) {
        //     $jsonFile = File::get(public_path("wilayah/kabupaten/$item->id.json"));
        //     $kabupaten = json_decode($jsonFile);
        //     $pr = Provinsi::create([
        //         'name' => ucwords(strtolower($item->nama)),
        //     ]);
        //     foreach ($kabupaten as $kb) {
        //         $jsonFile = File::get(public_path("wilayah/kecamatan/$kb->id.json"));
        //         $kecamatan = json_decode($jsonFile);
        //         $kbptn = Kabupaten::create([
        //             'provinsi_id' => $pr->id,
        //             'name' => ucwords(strtolower($kb->nama)),
        //         ]);
        //         foreach ($kecamatan as $kc) {
        //             $jsonFile = File::get(public_path("wilayah/kelurahan/$kc->id.json"));
        //             $kelurahan = json_decode($jsonFile);
        //             $kcm = Kecamatan::create([
        //                 'kabupaten_id' => $kbptn->id,
        //                 'name' => ucwords(strtolower($kc->nama)),
        //             ]);
        //             foreach ($kelurahan as $kl) {
        //                 Kelurahan::create([
        //                     'kecamatan_id' => $kcm->id,
        //                     'name' => ucwords(strtolower($kl->nama)),
        //                 ]);
        //             }
        //         }
        //     }
        // }
    }
}
