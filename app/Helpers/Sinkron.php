<?php

use App\Models\Santri;
use Revolution\Google\Sheets\Facades\Sheets;

class Sinkron
{
    public static function alumni()
    {
        $condition = Ping::to();
        if ($condition == true) {
            $sheet_id = env('SPREDSHEET_ID');
            $alumni = Sheets::spreadsheet($sheet_id)->sheet('Santri Alumni')->get()->toArray();
            if (count($alumni) > 0) {
                if (count($alumni) == 1) {
                    $santri_alumni = Santri::select('no_induk', 'name', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'bulan_lahir', 'tahun_lahir', 'nik', 'kk', 'tahun_masuk', 'tahun_masuk_hijriyah', 'tanggal_boyong', 'tanggal_boyong_hijriyah')
                        ->join('users', 'santris.user_id', '=', 'users.id')
                        ->where('status', 'Santri Alumni')
                        ->get()->toArray();

                    $santri_alumni_valid = [];
                    foreach ($santri_alumni as $val) {
                        $santri_alumni_valid[] = array_values($val);
                    }

                    Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Alumni')->append($santri_alumni_valid);
                } else {
                    // validating data from database local with data from google sheets
                    $santri_alumni = Santri::select('no_induk', 'name', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'bulan_lahir', 'tahun_lahir', 'nik', 'kk', 'tahun_masuk', 'tahun_masuk_hijriyah', 'tanggal_boyong', 'tanggal_boyong_hijriyah')
                        ->join('users', 'santris.user_id', '=', 'users.id')
                        ->where('status', 'Santri Alumni')
                        ->get()->toArray();

                    $santri_alumni_sheet = Sheets::spreadsheet($sheet_id)->sheet('Santri Alumni')->get()->toArray();

                    $santri_alumni_valid = [];
                    foreach ($santri_alumni as $val) {
                        $santri_alumni_valid[] = array_values($val);
                    }

                    // Mengonversi variable kedua menjadi daftar ID yang akan dihapus
                    $idsToDelete = array_map(function ($row) {
                        return $row[0];
                    }, array_slice($santri_alumni_sheet, 1));

                    // Menghapus baris dari variable pertama yang ada di variable kedua
                    foreach ($santri_alumni_valid as $key => $row) {
                        if (in_array($row[0], $idsToDelete)) {
                            unset($santri_alumni_valid[$key]);
                        }
                    }

                    // Reset kembali indeks array
                    $santri_alumni = array_values($santri_alumni_valid);

                    Sheets::spreadsheet($sheet_id)->sheet('Santri Alumni')->append($santri_alumni);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada koneksi internet'], 200);
        }
    }

    public static function santri()
    {
        $condition = Ping::to();
        if ($condition == true) {
            $sheet_id = env('SPREDSHEET_ID');
            if ($sheet_id) {
                $aktif = Sheets::spreadsheet($sheet_id)->sheet('Santri Aktif')->get()->toArray();
                if (count($aktif) > 0) {
                    // $header = ['No Induk', 'Nama Lengkap', 'Provinsi', 'Kabupaten', 'Kecamatan', 'Desa / Kelurahan', 'Dusun', 'Jenis Kelamin', 'Tempat', 'Tanggal', 'Bulan', 'Tahun Lahir', 'NIK', 'KK', 'Kamar', 'Blok', 'Tingkat', 'Kelas', 'Tahun Masuk', 'Tahun Masuk Hijriyah'];
                    // Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Aktif')->append([$header]);

                    if (count($aktif) == 1) {
                        $santri_aktif = Santri::select('no_induk', 'name', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'bulan_lahir', 'tahun_lahir', 'nik', 'kk', 'kamars.nama', 'kamars.blok', 'kelas.tingkatan', 'kelas.kelas', 'tahun_masuk', 'tahun_masuk_hijriyah')
                            ->join('users', 'santris.user_id', '=', 'users.id')
                            ->join('kelas', 'santris.kelas_id', '=', 'kelas.id')
                            ->join('kamars', 'santris.kamar_id', '=', 'kamars.id')
                            ->where('status', 'Santri Aktif')
                            ->get()->toArray();

                        $santri_aktif_valid = [];
                        foreach ($santri_aktif as $val) {
                            $santri_aktif_valid[] = array_values($val);
                        }

                        Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Aktif')->append($santri_aktif_valid);
                    } else {
                        $santri_aktif = Santri::select('no_induk', 'name', 'provinsi', 'kabupaten', 'kecamatan', 'desa', 'dusun', 'jenis_kelamin', 'tempat_lahir', 'tanggal_lahir', 'bulan_lahir', 'tahun_lahir', 'nik', 'kk', 'kamars.nama', 'kamars.blok', 'kelas.tingkatan', 'kelas.kelas', 'tahun_masuk', 'tahun_masuk_hijriyah')
                            ->join('users', 'santris.user_id', '=', 'users.id')
                            ->join('kelas', 'santris.kelas_id', '=', 'kelas.id')
                            ->join('kamars', 'santris.kamar_id', '=', 'kamars.id')
                            ->where('status', 'Santri Aktif')
                            ->get()->toArray();

                        $santri_aktif_sheet = Sheets::spreadsheet($sheet_id)->sheet('Santri Aktif')->get()->toArray();
                        $santri_aktif_valid = [];
                        foreach ($santri_aktif as $val) {
                            $santri_aktif_valid[] = array_values($val);
                        }

                        // Mengonversi variable kedua menjadi daftar ID yang akan dihapus
                        $idsToDelete = array_map(function ($row) {
                            return $row[0];
                        }, array_slice($santri_aktif_sheet, 1));

                        // Menghapus baris dari variable pertama yang ada di variable kedua
                        foreach ($santri_aktif_valid as $key => $row) {
                            if (in_array($row[0], $idsToDelete)) {
                                unset($santri_aktif_valid[$key]);
                            }
                        }

                        // Reset kembali indeks array
                        $santri_aktif = array_values($santri_aktif_valid);

                        Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Aktif')->append($santri_aktif);
                    }
                }

                return response()->json(['success' => true], 200);
            } else {
                return response()->json(['success' => false, 'message' => 'Silahkan isi ID Spreadsheet terlebih dahulu'], 200);
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Tidak ada koneksi internet'], 200);
        }
    }
}
