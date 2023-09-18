<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Nilai;
use App\Models\RaporSantri;
use App\Models\Santri;
use Illuminate\Http\Request;
use Toastr;

class RaportSantriController extends Controller
{
    public function index()
    {
        // dd(auth()->user()->hasPermissionTo('rapor index'));
        $kelas = Kelas::get();

        return view('pages.rapor.index', compact('kelas'));
    }

    public function santri(Kelas $kelas)
    {
        $santri = Santri::where('kelas_id', $kelas->id)->get();

        return view('pages.rapor.santri', compact('santri', 'kelas'));
    }

    public function nilai(Santri $santri)
    {
        $rapor = Santri::with('rapor_santri', 'nilai')
            ->where('santris.id', $santri->id)
            ->whereHas('rapor_santri', function ($query) use ($santri) {
                $query->where('tahun_akademik_id', 1)->orWhere('santri_id', $santri->id);
            })
            ->whereHas('nilai', function ($query) use ($santri) {
                $query->where('tahun_akademik_id', 1)->orWhere('santri_id', $santri->id);
            })
            ->first();

        $mapel = MataPelajaran::all();

        $kelas = Kelas::where('id', $santri->kelas_id)->first();

        return view('pages.rapor.nilai', [
            'rapor' => $rapor,
            'mapel' => $mapel,
            'santri' => $santri,
            'kelas' => $kelas,
        ]);
    }

    public function store(Request $request)
    {
        try {
            $mapel_model = new MataPelajaran();
            $mapel_count = $mapel_model->count();
            // simpan data nilai setiap mapel
            for ($i = 0; $i < $mapel_count; $i++) {
                $mapel_id = $mapel_model->find($request->mata_pelajaran_id[$i]);
                Nilai::create([
                    'santri_id' => $request->santri_id,
                    'mata_pelajaran_id' => $mapel_id->id,
                    'tahun_akademik_id' => 1,
                    'nilai' => $request->nilai[$i],
                    'keterangan' => $request->keterangan[$i]
                ]);
            }
            // simpan data rapor semester saat ini
            RaporSantri::create([
                'santri_id' => $request->santri_id,
                'tahun_akademik_id' => 1,
                'jml_nilai_semester' => $request->jml_nilai_semester,
                'nilai_rata_rata_semester' => $request->nilai_rata_rata_semester,
                'etika' => $request->etika,
                'kerajinan' => $request->kerajinan,
                'kerapian' => $request->kerapian,
                'sakit' => $request->sakit,
                'izin' => $request->izin,
                'alpha' => $request->alpha,
            ]);

            Toastr::success('Berhasil menyimpan data');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Gagal menyimpan data');
            return redirect()->back();
        }
    }
    public function update(Request $request)
    {
        try {
            $mapel_model = new MataPelajaran();
            $mapel_count = $mapel_model->count();
            // simpan data nilai setiap mapel
            for ($i = 0; $i < $mapel_count; $i++) {
                $mapel_id = $mapel_model->find($request->mata_pelajaran_id[$i]);
                Nilai::where('id', $request->nilai_id[$i])->update([
                    'santri_id' => $request->santri_id,
                    'mata_pelajaran_id' => $mapel_id->id,
                    'tahun_akademik_id' => 1,
                    'nilai' => $request->nilai[$i],
                    'keterangan' => $request->keterangan[$i]
                ]);
            }
            // simpan data rapor semester saat ini
            RaporSantri::where('id', $request->rapor_id)->update([
                'santri_id' => $request->santri_id,
                'tahun_akademik_id' => 1,
                'jml_nilai_semester' => $request->jml_nilai_semester,
                'nilai_rata_rata_semester' => $request->nilai_rata_rata_semester,
                'etika' => $request->etika,
                'kerajinan' => $request->kerajinan,
                'kerapian' => $request->kerapian,
                'sakit' => $request->sakit,
                'izin' => $request->izin,
                'alpha' => $request->alpha,
            ]);

            Toastr::success('Berhasil memperbarui data');
            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Gagal memperbarui data');
            return redirect()->back();
        }
    }
}
