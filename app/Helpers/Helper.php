<?php

use App\Models\Santri;

class Helper
{
    public static function make_noinduk($params)
    {
        $last_tahun_masuk = substr($params['tahun_masuk'], 0, 4);
        $jenis_kelamin = $params['gender'];
        $tahun_masuk_hijriyah = $params['tahun_masuk_hijriyah'];

        // Ambil no_induk terakhir langsung dengan mengambil satu data
        $get_santri_latest = Santri::where('jenis_kelamin', $jenis_kelamin)
            ->whereYear('tahun_masuk', $last_tahun_masuk)
            ->orderBy('no_induk', 'desc')
            ->first(['no_induk']);

        if ($get_santri_latest) {
            // Ambil nomor induk terakhir dan tambahkan 1
            $start_noinduk = substr($get_santri_latest->no_induk, 4);
            $next = (int)$start_noinduk + 1;
        } else {
            // Tentukan nomor awal berdasarkan jenis kelamin
            $next = ($jenis_kelamin == 'Laki-Laki') ? 1 : 1001;
        }

        // Format nomor induk berikutnya dengan padding zero
        $next_noinduk = str_pad($next, 4, '0', STR_PAD_LEFT);
        $noinduk = $tahun_masuk_hijriyah . $next_noinduk;

        return $noinduk;
    }

    public static function isChecked($item, $array)
    {
        $checked = false;
        foreach ($item->permissions->toArray() as $key => $value) {
            $checked = in_array($array, $value);
        }

        return $checked;
    }

    public static function prov($params)
    {
        $prov = public_path('wilayah/provinsi.json');
        $jsonString = file_get_contents($prov);
        $dataArray = json_decode($jsonString, true);
        $dataProv = '';
        foreach ($dataArray as $key => $provData) {
            if ($params == $provData['id']) {
                $dataProv = $provData['nama'];
            }
        }

        return $dataProv;
    }

    public static function kab($params, $id)
    {
        $kab = public_path('wilayah/kabupaten' . '/' . $params . '.json');
        $jsonString = file_get_contents($kab);
        $dataArray = json_decode($jsonString, true);
        $dataKab = '';
        foreach ($dataArray as $key => $kabData) {
            if ($id == $kabData['id']) {
                $dataKab = $kabData['nama'];
            }
        }

        return $dataKab;
    }

    public static function kec($params, $id)
    {
        $kec = public_path('wilayah/kecamatan' . '/' . $params . '.json');
        $jsonString = file_get_contents($kec);
        $dataArray = json_decode($jsonString, true);
        $dataKec = '';
        foreach ($dataArray as $key => $kecData) {
            if ($id == $kecData['id']) {
                $dataKec = $kecData['nama'];
            }
        }

        return $dataKec;
    }

    public static function kel($params, $id)
    {
        $kel = public_path('wilayah/kelurahan' . '/' . $params . '.json');
        $jsonString = file_get_contents($kel);
        $dataArray = json_decode($jsonString, true);
        $dataKel = '';
        foreach ($dataArray as $key => $kelData) {
            if ($id == $kelData['id']) {
                $dataKel = $kelData['nama'];
            }
        }

        return $dataKel;
    }

    public static function bulan_id($params): string
    {
        $bulanIndonesia = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember',
        ];

        return $bulanIndonesia[$params];
    }
}
