<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $santri = new Santri();
        $putri = $santri->where('jenis_kelamin', 'Perempuan')->where('status', 'Santri Aktif')->count();
        $putra = $santri->where('jenis_kelamin', 'Laki-Laki')->where('status', 'Santri Aktif')->count();
        $santri_aktif = $santri->where('status', 'Santri Aktif')->count();
        $santri_alumni = $santri->where('status', 'Santri Alumni')->count();
        $pengurus = User::role('Pengurus')->count();
        $total_santri = Santri::count();

        return view('pages.dashboard', compact('putri', 'putra', 'santri_aktif', 'santri_alumni', 'pengurus', 'total_santri'));
    }
}
