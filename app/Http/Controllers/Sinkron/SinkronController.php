<?php

namespace App\Http\Controllers\Sinkron;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Revolution\Google\Sheets\Facades\Sheets;

class SinkronController extends Controller
{
    public function show()
    {
        $sheet_name = env('SHEET_NAME');
        $sheet_id = env('SPREDSHEET_ID');
//        $values = Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Test')->get();
        $row = [7, 'ahmad7@gmail.com', 'ahmad7'];
        Sheets::spreadsheet('1noIIdm9r6B6fDPY2zXE23yNq19qf2E0jY3cEQb1M0aQ')->sheet('Test')->append([$row]);
        $values = Sheets::all();
        dd($values);
    }
}
