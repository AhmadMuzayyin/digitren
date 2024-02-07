<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class SantriExport implements FromCollection, ShouldAutoSize, WithHeadings, WithMapping, WithStyles
{
    protected $santri;

    public function __construct($santri)
    {
        $this->santri = $santri;
    }

    public function collection()
    {
        return $this->santri;
    }

    public function headings(): array
    {
        return [
            'Nomor Induk',
            'Nama Lengkap',
            'Tingkat - Kelas',
            'Kamar',
            'Dusun',
            'Desa',
            'Kecamatan',
            'Kabupaten',
            'Provinsi',
            'Jenis Kelamin',
            'Data Kependudukan',
            'No Whatsapp',
            'Tempat Tanggal Lahir',
            'Tahun Masuk M/H',
            'Tanggal Boyong M/H',
            'Status',
            'Ayah',
            'Ibu',
        ];
    }

    public function map($row): array
    {
        return [
            $row->no_induk,
            $row->user->name,
            $row->kelas !== null ? $row->kelas->tingkatan.' - '.$row->kelas->kelas : '',
            $row->kamar !== null ? $row->kamar->nama.' - '.$row->kamar->blok : '',
            $row->dusun,
            $row->desa,
            $row->kecamatan,
            $row->kabupaten,
            $row->provinsi,
            $row->jenis_kelamin,
            "NIK: ($row->nik) - KK: ($row->kk)",
            'https://wa.me/'.$row->whatsapp,
            $row->tempat_lahir.', '.$row->tanggal_lahir.' '.$row->bulan_lahir.' '.$row->tahun_lahir,
            $row->tahun_masuk.' .M / '.$row->tahun_masuk_hijriyah.' .H',
            $row->tanggal_boyong.' .M / '.$row->tanggal_boyong_hijriyah.' .H',
            $row->status,
            $row->wali_santri->nama_ayah,
            $row->wali_santri->nama_ibu,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1 => ['font' => ['bold' => true]],

            // Styling a specific cell by coordinate.
            // 'B2' => ['font' => ['italic' => true]],

            // Styling an entire column.
            // 'C'  => ['font' => ['size' => 16]],
        ];
    }
}
