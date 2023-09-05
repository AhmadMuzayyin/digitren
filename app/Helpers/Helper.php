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
            $noinduk = $params['tahun_masuk_hijriyah'].$next;

            return $noinduk;
        }
        if ($params['gender'] == 'Laki-Laki') {
            $start_noinduk = '0001';
            $noinduk = $params['tahun_masuk_hijriyah'].$start_noinduk;

            return $noinduk;
        } else {
            $start_noinduk = '1001';
            $noinduk = $params['tahun_masuk_hijriyah'].$start_noinduk;

            return $noinduk;
        }
    }
}
