<?php

namespace App\Http\Controllers\Sinkronisasi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SinkronisasiController extends Controller
{
    public function index()
    {
        $data = [
            'kamar', 'kelas', 'santri', 'tabungan', 'transaksi'
        ];
        return view('pages.sinkronisasi.index', compact('data'));
    }
}
