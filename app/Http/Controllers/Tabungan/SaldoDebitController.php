<?php

namespace App\Http\Controllers\Tabungan;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Toastr;

class SaldoDebitController extends Controller
{
    public function index()
    {
        $tabungan = Tabungan::with('santri')->get();
        $santri = Santri::all();
        return view('pages.saldo_debit.index', compact('tabungan', 'santri'));
    }
    public function store(Request $request)
    {
        $validate = $request->validate([
            'santri_id' => 'required|exists:santris,id',
            'saldo' => 'required|numeric',
            'keterangan' => 'nullable'
        ]);
        try {
            $validate['tanggal_setor'] = date('Y-m-d');
            if (Tabungan::firstWhere('santri_id', $validate['santri_id'])) {
                Toastr::info('Santri sudah memiliki tabungan');
            } else {
                if (Santri::firstWhere('id', $validate['santri_id'])->status == 'Santri Alumni') {
                    Toastr::info('Santri sudah menjadi alumni');
                } else {
                    Tabungan::create($validate);
                    Toastr::success('Berhasil menyimpan data');
                }
            }
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');
            return redirect()->back();
        }
    }
    public function destroy(Tabungan $tabungan)
    {
        try {
            $tabungan->delete();
            TransaksiTabungan::where('santri_id', $tabungan->santri_id)->delete();
            Toastr::success('Berhasil menghapus data');
            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menghapus data');
            return redirect()->back();
        }
    }
}
