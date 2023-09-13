<?php

namespace App\Http\Controllers\Rapor;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\RaporSantri;
use App\Models\Santri;

class RaportSantriController extends Controller
{
    public function index()
    {
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
        $rapor = RaporSantri::join('mata_pelajarans', 'rapor_santris.mata_pelajaran_id', '=', 'mata_pelajarans.id')
            ->where('santri_id', $santri->id)
            ->get();

        $mapel = MataPelajaran::all();

        $kelas = Kelas::where('id', $santri->kelas_id)->first();

        return view('pages.rapor.nilai', [
            'rapor' => $rapor->isEmpty() ? $mapel : $rapor,
            'santri' => $santri,
            'kelas' => $kelas,
        ]);
    }
}
