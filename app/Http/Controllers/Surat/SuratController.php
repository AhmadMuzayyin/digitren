<?php

namespace App\Http\Controllers\Surat;

use App\Http\Controllers\Controller;
use App\Models\IzinSantri;

class SuratController extends Controller
{
    public function index()
    {
        $izinsantri = IzinSantri::all();

        return view('pages.surat.index', compact('izinsantri'));
    }
}
