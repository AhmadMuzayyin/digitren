<?php

namespace App\Imports;

use App\Models\AlamatSantri;
use App\Models\Kabupaten;
use App\Models\Kamar;
use App\Models\Kecamatan;
use App\Models\Kelas;
use App\Models\Kelurahan;
use App\Models\Provinsi;
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
                'email' => Str::slug($row['nama']) . config('app.domain'),
                'password' => bcrypt('password'),
            ]);
            $user->assignRole('Santri');
            $santri = Santri::create([
                'user_id' => $user->id,
                'no_induk' => $no_induk,
                'jenis_kelamin' => $row['jenis_kelamin'],
                'whatsapp' => $row['whatsapp'],
                'tanggal_lahir' => $row['tanggal_lahir'],
                'tempat_lahir' => $row['tempat_lahir'],
                'tahun_masuk' => $row['tahun_masuk'],
                'tahun_masuk_hijriyah' => $tahun_masuk_hijriyah,
            ]);
            if (!$santri) {
                $user->delete();
            }
            DB::commit();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            DB::rollBack();
            Toastr::error('Gagal import data santri');
        }
    }
}
