<?php

namespace App\Http\Controllers\Kamar;

use App\Exports\KamarExport;
use App\Http\Controllers\Controller;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Toastr;
use Yajra\DataTables\Facades\DataTables;

class KamarController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $kamar = Kamar::get();
            return DataTables::of($kamar)
                ->addIndexColumn()
                ->addColumn('action', 'pages.kamar.include.action')
                ->toJson();
        }
        return view('pages.kamar.index');
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
            $validate['kode'] = fake()->regexify('[A-Z]{5}[0-4]{5}');
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
    public function download()
    {
        $kamar = Kamar::get(['kode', 'nama', 'blok', 'jumlah_santri', 'maksimal_santri']);
        return Excel::download(new KamarExport($kamar), 'kamar.xlsx');
    }
}
