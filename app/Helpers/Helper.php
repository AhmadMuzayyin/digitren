<?php

use App\Models\Santri;

class Helper
{
    public static function make_noinduk($params)
    {
        $get_santri_latest = Santri::where('jenis_kelamin', $params['gender'])->whereYear('tahun_masuk', $params['tahun_masuk'])->latest()->first();
        if ($get_santri_latest) {
            $start_noinduk = substr($get_santri_latest->no_induk, 4);
            $next = str_pad((int) $start_noinduk + 1, strlen($start_noinduk), '0', STR_PAD_LEFT);
            $noinduk = $params['tahun_masuk_hijriyah'] . $next;

            return $noinduk;
        }
        if ($params['gender'] == 'Laki-Laki') {
            $start_noinduk = '0001';
            $noinduk = $params['tahun_masuk_hijriyah'] . $start_noinduk;

            return $noinduk;
        } else {
            $start_noinduk = '1001';
            $noinduk = $params['tahun_masuk_hijriyah'] . $start_noinduk;

            return $noinduk;
        }
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
}
