<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Toastr;

class JenisSuratController extends Controller
{
    public function index()
    {

        $jenis = JenisSurat::all();

        return view('pages.surat.jenis', ['jenis_surat' => $jenis]);
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        try {
            $validate['slug'] = Str::slug($request->name);
            JenisSurat::create($validate);
            Toastr::success('Berhasil menyimpan data');

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Gagal menyimpan data');

            return redirect()->back();
        }
    }

    public function update(Request $request, JenisSurat $jenis_surat)
    {
        $validate = $request->validate([
            'name' => 'required',
        ]);
        try {
            $validate['slug'] = Str::slug($request->name);
            $jenis_surat->update($validate);
            Toastr::success('Berhasil merubah data');

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Gagal merubah data');

            return redirect()->back();
        }
    }

    public function destroy(JenisSurat $jenis_surat)
    {
        try {
            $jenis_surat->delete();
            Toastr::success('Berhasil menghapus data');

            return redirect()->back();
        } catch (\Throwable $th) {
            //throw $th;
            Toastr::error('Gagal menghapus data');

            return redirect()->back();
        }
    }
}
