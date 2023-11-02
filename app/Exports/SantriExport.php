<?php

namespace App\Exports;

use App\Models\Santri;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SantriExport implements FromView
{
    public function view(): View
    {
        // TODO: Implement view() method.
        $data = Santri::with('kamar', 'kelas', 'wali_santri', 'user')->get();

        //        dd($data);
        return view('pages.santri.export', ['santri' => $data]);
    }
}
