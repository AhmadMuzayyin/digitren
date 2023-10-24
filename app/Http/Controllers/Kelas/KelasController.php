<?php

namespace App\Http\Controllers\Kelas;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Toastr;

class KelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        return view('pages.kelas.index', compact('kelas'));
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'tingkatan' => 'required|min:3',
            'kelas' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);

        try {
            $validate['kode'] = fake()->regexify('[A-Z]{5}[0-4]{5}');
            Kelas::create($validate);
            Toastr::success('Berhasil menambah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menambah data');

            return redirect()->back();
        }
    }

    public function update(Request $request, Kelas $kelas)
    {
        $validate = $request->validate([
            'tingkatan' => 'required|min:3',
            'kelas' => 'required|min:3',
            'keterangan' => 'nullable',
        ]);
        try {
            $validate['kode'] = fake()->regexify('[A-Z]{5}[0-4]{5}');
            $kelas->update($validate);
            Toastr::success('Berhasil merubah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal merubah data');

            return redirect()->back()->withInput();
        }
    }

    public function destroy(Kelas $kelas)
    {
        try {
            $kelas->delete();
            Toastr::success('Berhasil menghapus data');

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
