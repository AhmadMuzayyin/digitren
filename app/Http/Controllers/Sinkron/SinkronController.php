<?php

namespace App\Http\Controllers\Sinkron;

use App\Http\Controllers\Controller;
use Revolution\Google\Sheets\Facades\Sheets;

class SinkronController extends Controller
{
    public function index()
    {
        $data = config('app.modules');
        return view('pages.sinkronisasi.index', compact('data'));
    }
    public function sync()
    {
        $sheet_name = env('SHEET_NAME');
        $sheet_id = env('SPREDSHEET_ID');
        $values = Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Aktif')->get();
        // $row = [7, 'ahmad7@gmail.com', 'ahmad7'];
        // Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Santri Aktif')->append([$row]);
        // $values = Sheets::all();
        dd($values);
    }
}
