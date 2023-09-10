<?php

namespace App\Http\Controllers\Sinkronisasi;

use App\Http\Controllers\Controller;

class SinkronisasiController extends Controller
{
    public function index()
    {
        $data = [
            'kamar', 'kelas', 'santri', 'tabungan', 'transaksi',
        ];

        return view('pages.sinkronisasi.index', compact('data'));
    }
}
