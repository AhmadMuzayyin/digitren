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
            'kategori' => 'required|in:Fan Pokok,Non Pokok,Tes Kelas Tertentu',
            'nama' => 'required|string|min:5',
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

    public function destroy(MataPelajaran $mapel)
    {
        try {
            $mapel->delete();
            Toastr::success('Berhasil menghapus data');

            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th->getMessage());
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
