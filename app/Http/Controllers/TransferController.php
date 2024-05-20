<?php

namespace App\Http\Controllers;

use App\Models\Santri;
use Illuminate\Http\Request;

class TransferController extends Controller
{
    public function transfer(Request $request)
    {
        $pengirim = Santri::findOrFail($request->input('pengirim_id'));
        $penerima = Santri::findOrFail($request->input('penerima_id'));
        $jumlah = $request->input('jumlah');
        $keterangan = $request->input('keterangan');

        try {
            $pengirim->transfer($penerima, $jumlah, $keterangan);
            return response()->json(['message' => 'Transfer berhasil.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Transfer gagal: ' . $e->getMessage()], 400);
        }
    }
}
