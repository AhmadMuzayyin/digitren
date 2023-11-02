<?php

namespace App\Http\Controllers\Tabungan;

use App\Exports\TabunganExport;
use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
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
            'keterangan' => 'nullable',
        ]);
        try {
            if (Tabungan::firstWhere('santri_id', $validate['santri_id'])) {
                Toastr::info('Santri sudah memiliki tabungan');
            } else {
                if (Santri::firstWhere('id', $validate['santri_id'])->status == 'Santri Alumni') {
                    Toastr::info('Santri sudah menjadi alumni');
                } else {
                    $tabungan = Tabungan::create($validate);
                    if ($tabungan->saldo > 0) {
                        TransaksiTabungan::create([
                            'santri_id' => $tabungan->santri_id,
                            'tanggal_transaksi' => date('Y-m-d'),
                            'jenis_transaksi' => 'Setoran',
                            'jumlah_transaksi' => $tabungan->saldo,
                            'saldo_saatini' => $tabungan->saldo,
                        ]);
                    }
                    Toastr::success('Berhasil menyimpan data');
                }
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            //dd($th->getMessage());
            Toastr::error('Gagal menyimpan data');

            return redirect()->back();
        }
    }

    public function export($id)
    {
        $santri = Santri::with('user')->where('id', $id)->first();
        $filname = $santri->user->name.' - '.$santri->desa;

        return Excel::download(new TabunganExport($id), $filname.'_Tabungan.xlsx');

        return redirect()->back();
    }

    public function show($id)
    {
        $data = TransaksiTabungan::where('santri_id', $id)->get();

        return view('pages.saldo_debit.history', compact('data'));
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
