<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        $riwayat = ActivityLog::with('user')->get();
        return view('pages.riwayat.index', compact('riwayat'));
    }
}
