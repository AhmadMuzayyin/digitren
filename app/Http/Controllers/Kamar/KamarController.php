<?php

namespace App\Http\Controllers\Kamar;

use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Toastr;

class KamarController extends Controller
{
    public function index()
    {
        $kamar = Kamar::all();

        return view('pages.kamar.index', compact('kamar'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'nama' => 'required|min:3|unique:kamars,nama',
            'blok' => 'required|min:1',
            'jumlah_santri' => 'required|numeric|min:0',
            'maksimal_santri' => 'required|numeric|min:0',
        ]);

        try {
            Kamar::create($validate);
            Toastr::success('Berhasil menambah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menambah data');

            return redirect()->back();
        }
    }

    public function update(Request $request, Kamar $kamar)
    {
        $validate = $request->validate([
            'nama' => "required|min:3|unique:kamars,nama,$kamar->id",
            'blok' => 'required|min:1',
            'jumlah_santri' => 'required|numeric|min:0',
            'maksimal_santri' => 'required|numeric|min:0',
        ]);
        try {
            $kamar->update($validate);
            Toastr::success('Berhasil merubah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal merubah data');

            return redirect()->back()->withInput();
        }
    }

    public function destroy(Kamar $kamar)
    {
        try {
            if ($kamar->jumlah_santri == 0) {
                $kamar->delete();
                Toastr::success('Berhasil menghapus data');
            } else {
                Toastr::info('Kamar telah diisi, tidak dapat dihapus');
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
