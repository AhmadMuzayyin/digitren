<?php

namespace App\Http\Controllers;

use App\Http\Requests\TransferRequest;
use App\Models\Santri;
use App\Models\TransaksiTabungan;
use App\Models\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Toastr;

class TransferController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $data = Transfer::with('pengirim', 'pengirim.user', 'penerima', 'penerima.user')->get();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', 'pages.transfer.include.action')
                ->toJson();
        }
        return view('pages.transfer.index');
    }
    public function store(TransferRequest $request)
    {
        $validated = $request->validated();
        try {
            $pengirim = Santri::findOrFail($validated['pengirim_id']);
            $penerima = Santri::findOrFail($validated['penerima_id']);
            $jumlah = $validated['nominal'];
            $keterangan = $validated['keterangan'];
            if ($pengirim->id == $penerima->id) {
                Toastr::error('Santri pengirim dan penerima tidak boleh sama.');
                return redirect()->back();
            }
            if ($pengirim->load('tabungan')->tabungan[0]->saldo < $jumlah) {
                Toastr::error('Saldo tidak mencukupi.');
                return redirect()->back();
            }
            $this->transfer($penerima->load('tabungan'), $pengirim->load('tabungan'), $jumlah, $keterangan);
            Toastr::success('Transfer berhasil.');
            return redirect()->back();
        } catch (\Exception $e) {
            dd($e->getMessage());
            Toastr::error('Transfer gagal.');
            return redirect()->back();
        }
    }

    public function transfer(Santri $penerima, Santri $pengirim, $jumlah, $keterangan = null)
    {
        try {
            DB::transaction(function () use ($penerima, $pengirim, $jumlah, $keterangan) {
                // Pengirim
                $pengirimTabungan = $pengirim->tabungan[0];
                $pengirimSaldoSebelumnya = $pengirimTabungan->saldo;
                $pengirimTabungan->saldo = $pengirimTabungan->saldo - $jumlah;
                $pengirimTabungan->save();
                TransaksiTabungan::create([
                    'santri_id' => $pengirim->id,
                    'tanggal_transaksi' => now(),
                    'jenis_transaksi' => 'Penarikan',
                    'tujuan' => 'Transfer ke ' . $penerima->user->name,
                    'jumlah_transaksi' => $jumlah,
                    'saldo_sebelumnya' => $pengirimSaldoSebelumnya,
                    'saldo_saatini' => $pengirimTabungan->saldo,
                    'keterangan' => $keterangan,
                ]);
                // Penerima
                $penerimaTabungan = $penerima->tabungan[0];
                $penerimaSaldoSebelumnya = $penerimaTabungan->saldo;
                $penerimaTabungan->saldo = $penerimaTabungan->saldo + $jumlah;
                $penerimaTabungan->save();
                TransaksiTabungan::create([
                    'santri_id' => $penerima->id,
                    'tanggal_transaksi' => now(),
                    'jenis_transaksi' => 'Setoran',
                    'jumlah_transaksi' => $jumlah,
                    'saldo_sebelumnya' => $penerimaSaldoSebelumnya,
                    'saldo_saatini' => $penerimaTabungan->saldo,
                    'tujuan' => 'Transfer dari ' . $pengirim->user->name,
                    'keterangan' => $keterangan,
                ]);
                // Catat Transfer
                Transfer::create([
                    'pengirim_id' => $pengirim->id,
                    'penerima_id' => $penerima->id,
                    'jumlah_transfer' => $jumlah,
                    'keterangan' => $keterangan
                ]);
            });
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
        }
    }
}
