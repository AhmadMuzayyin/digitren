<?php

namespace App\Http\Controllers;

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class AlamatController extends Controller
{
    public function kabupaten(Request $request)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $request->provinsi_id)->get();
        return response()->json($kabupaten);
    }
    public function kecamatan(Request $request)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $request->kabupaten_id)->get();
        return response()->json($kecamatan);
    }
    public function kelurahan(Request $request)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $request->kecamatan_id)->get();
        return response()->json($kelurahan);
    }
}
