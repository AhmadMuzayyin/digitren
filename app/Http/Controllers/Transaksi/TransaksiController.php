<?php

namespace App\Http\Controllers\Transaksi;

use App\Http\Controllers\Controller;
use App\Models\Santri;
use App\Models\Tabungan;
use App\Models\TransaksiTabungan;
use Illuminate\Http\Request;
use Toastr;

class TransaksiController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $noinduk = request()->get('no_induk');
            $santri = Tabungan::with('santri', 'santri.user')->whereHas('santri', function ($query) use ($noinduk) {
                $query->where('no_induk', $noinduk);
            })->first();
            if ($santri) {
                $data = [
                    'santri_id' => $santri->santri->id,
                    'no_induk' => $santri->santri->no_induk,
                    'name' => $santri->santri->user->name,
                    'saldo' => number_format($santri->sum('saldo')),
                    'foto' => $santri->santri->foto,
                ];

                return response()->json(['data' => $data], 200);
            }

            return response()->json(['message' => 'Tidak ada data santri dengan nomor induk <strong>'.$noinduk.'</strong>'], 200);
        }

        return view('pages.transaksi.index');
    }

    public function store(Request $request)
    {
        $validate = $request->validate([
            'santri_noinduk' => 'required|numeric|digits:8|exists:santris,no_induk',
            'debit' => 'required|numeric',
            'jenis_transaksi' => 'required',
        ]);
        try {
            if ($validate['debit'] < 50000) {
                Toastr::info('Minimal setoran Rp. 50.000');
            } else {
                $santri = Santri::firstWhere('no_induk', $validate['santri_noinduk']);
                $transaksi = TransaksiTabungan::create([
                    'santri_id' => $santri->id,
                    'tanggal_transaksi' => date('Y-m-d'),
                    'jenis_transaksi' => $validate['jenis_transaksi'],
                    'jumlah_transaksi' => $validate['debit'],
                ]);

                $tabungan = Tabungan::firstWhere('santri_id', $santri->id);
                $tabungan->update([
                    'saldo' => $tabungan->saldo + $transaksi->jumlah_transaksi,
                    'tanggal_setor' => date('Y-m-d'),
                ]);
                Toastr::success('Berhasil menyimpan data');
            }

            return redirect()->back();
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');

            return redirect()->back()->withInput();
        }
    }

    public function update(Request $request)
    {
        $validate = $request->validate([
            'santri_noinduk' => 'required|numeric|digits:8|exists:santris,no_induk',
            'debit' => 'required|numeric',
            'jenis_transaksi' => 'required',
        ]);
        try {
            if ($validate['debit'] < 10000) {
                Toastr::info('Minimal penarikan 10.000 atau diatasnya');
            } else {
                $santri = Santri::firstWhere('no_induk', $validate['santri_noinduk']);
                $tabungan = Tabungan::firstWhere('santri_id', $santri->id);
                if ($tabungan->saldo == 0) {
                    Toastr::info('Saldo tidak cukup saldo saat ini '.$tabungan->saldo);
                } else {
                    $transaksi = TransaksiTabungan::create([
                        'santri_id' => $santri->id,
                        'tanggal_transaksi' => date('Y-m-d'),
                        'jenis_transaksi' => $validate['jenis_transaksi'],
                        'jumlah_transaksi' => $validate['debit'],
                    ]);

                    $tabungan->update([
                        'saldo' => $tabungan->saldo - $transaksi->jumlah_transaksi,
                        'tanggal_setor' => date('Y-m-d'),
                    ]);
                    Toastr::success('Berhasil menyimpan data');
                }
            }

            return redirect()->back()->withQuery(['jenis_transaksi' => 'Penarikan']);
        } catch (\Throwable $th) {
            Toastr::error('Gagal menyimpan data');

            return redirect()->back()->withInput();
        }
    }
}
