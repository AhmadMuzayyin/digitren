<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class TabunganExport implements FromCollection, ShouldAutoSize, WithColumnFormatting, WithHeadings, WithMapping
{
    protected $tabungan;

    public function __construct($tabungan)
    {
        $this->tabungan = $tabungan;
    }

    public function collection()
    {
        return $this->tabungan;
    }

    public function headings(): array
    {
        return [
            'Debit',
            'Kredit',
            'Saldo',
            'Tanggal Transaksi',
        ];
    }

    public function map($row): array
    {
        return [
            $row->jenis_transaksi === 'Setoran' ? $row->jumlah_transaksi : '',
            $row->jenis_transaksi === 'Penarikan' ? $row->jumlah_transaksi : '',
            $row->saldo_saatini,
            date('d F Y', strtotime($row->tanggal_transaksi)),
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'B' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
            'C' => NumberFormat::FORMAT_CURRENCY_USD_INTEGER,
        ];
    }
}
