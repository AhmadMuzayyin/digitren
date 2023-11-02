<?php

namespace App\Exports;

use App\Models\TransaksiTabungan;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class TabunganExport implements FromView
{
    private $id;

    public function __construct($id)
    {
        $this->id = $id;
    }

    public function view(): View
    {
        // TODO: Implement view() method.
        $tabungan = TransaksiTabungan::with('santri')->where('santri_id', $this->id)->get();

        return view('pages.saldo_debit.export', compact('tabungan'));
    }
}
