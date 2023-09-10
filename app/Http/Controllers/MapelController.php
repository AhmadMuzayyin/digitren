<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran;
use Illuminate\Http\Request;
use Toastr;

class MapelController extends Controller
{
    public function index()
    {
        $mapel = MataPelajaran::all();
        return view('pages.mapel.index', compact('mapel'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'kategori' => 'required|in:Fan Pokok, Non Pokok, Tes Kelas Tertentu, Absensi, Kondisi Siswa',
            'nama' => 'required|string|min:5'
        ]);
        try {
            MataPelajaran::create($validate);
            Toastr::success('Berhasil menyimpan data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');
            return redirect()->back();
        }
    }
}
