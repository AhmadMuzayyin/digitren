<?php

namespace App\Http\Controllers\Riwayat;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Yajra\DataTables\Facades\DataTables;

class RiwayatController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            $riwayat = ActivityLog::with('user')->orderBy('id', 'desc')->get();
            return DataTables::of($riwayat)
                ->addIndexColumn()
                ->addColumn('user', function ($row) {
                    return $row->user->name;
                })
                ->toJson();
        }
        return view('pages.riwayat.index');
    }
}
