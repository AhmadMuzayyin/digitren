<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class KamarExport implements FromCollection, WithHeadings
{
    protected $kamar;

    public function __construct($kamar)
    {
        $this->kamar = $kamar;
    }

    public function collection()
    {
        return $this->kamar;
    }

    public function headings(): array
    {
        return [
            'Kode',
            'Nama Kamar',
            'Blok',
            'Jumlah Santri',
            'Maksimal Santri',
        ];
    }

    public function map($row): array
    {
        return [
            $row->kode,
            $row->nama,
            $row->blok,
            $row->jumlah_santri,
            $row->maksimal_santri,
        ];
    }
}
