<?php

namespace App\Http\Controllers\Sinkron;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use Illuminate\Http\Request;
use Ping;
// use Illuminate\Support\Facades\Config;
use Revolution\Google\Sheets\Facades\Sheets;

class SinkronController extends Controller
{
    public function index()
    {
        $data = config('modules.modules');

        return view('pages.sinkronisasi.index', compact('data'));
    }

    public function sync()
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
        }

        return response()->json(['success' => false, 'message' => 'Tidak ada koneksi internet'], 200);
    }

    public function update(Request $request)
    {
        try {
            \Config::write('modules.modules.santri', $request->data);

            return response()->json(['success' => true, 'message' => 'Berhasil mengubah data']);
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
