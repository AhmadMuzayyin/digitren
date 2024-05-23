<?php

namespace App\Observers;

use App\Models\Setting;
use App\Models\TransaksiTabungan;
use App\Models\WhatsappMessage;
use Illuminate\Support\Facades\Http;

class TransaksiTabunganObserver
{
    protected $uri = 'https://connect.labelin.co/send-message';
    public function created(TransaksiTabungan $transaksiTabungan)
    {
        $setting = Setting::first();
        if (isset($setting) && $setting->whatsapp_feature == true) {
            if ($transaksiTabungan->jenis_transaksi == 'Setoran') {
                $params = [
                    'nama' => $transaksiTabungan->santri->user->name,
                    'nominal' => "Rp. " . number_format($transaksiTabungan->jumlah_transaksi),
                    'tanggal' => $transaksiTabungan->tanggal_transaksi,
                    'number' => $transaksiTabungan->santri->whatsapp
                ];
                $param = $this->msg_setor_tunai($params);
                Http::get($this->uri, $param);
            } else {
                $params = [
                    'nama' => $transaksiTabungan->santri->user->name,
                    'nominal' => "Rp. " . number_format($transaksiTabungan->jumlah_transaksi),
                    'tanggal' => $transaksiTabungan->tanggal_transaksi,
                    'number' => $transaksiTabungan->santri->whatsapp,
                    'tujuan' => $transaksiTabungan->tujuan
                ];
                $param = $this->msg_tarik_tunai($params);
                Http::get($this->uri, $param);
            }
        }
    }

    public function updated(TransaksiTabungan $transaksiTabungan)
    {
        //
    }
    public function msg_setor_tunai($params)
    {
        $setting = Setting::first();
        $apiKey = $setting->whatsapp_api_key;
        $message = WhatsappMessage::first();
        $messageText = $message->pesan_setor_tunai;
        $tarik_tunai = [
            'nama' => $params['nama'],
            'nominal' => $params['nominal'],
            'tanggal' => $params['tanggal'],
            'waktu' => $this->waktu()
        ];
        foreach ($tarik_tunai as $key => $value) {
            $messageText = str_replace("{{$key}}", $value, $messageText);
        }
        $params = [
            'api_key' => $apiKey,
            'sender' => $setting->sender,
            'number' => $params['number'],
            'message' => $messageText,
        ];

        return $params;
    }
    public function msg_tarik_tunai($params)
    {
        $setting = Setting::first();
        $apiKey = $setting->whatsapp_api_key;
        $message = WhatsappMessage::first();
        $messageText = $message->pesan_tarik_tunai;
        $tarik_tunai = [
            'nama' => $params['nama'],
            'nominal' => $params['nominal'],
            'tujuan' => $params['tujuan'],
            'tanggal' => $params['tanggal'],
            'waktu' => $this->waktu()
        ];
        foreach ($tarik_tunai as $key => $value) {
            $messageText = str_replace("{{$key}}", $value, $messageText);
        }
        $params = [
            'api_key' => $apiKey,
            'sender' => $setting->sender,
            'number' => $params['number'],
            'message' => $messageText,
        ];

        return $params;
    }
    public function waktu()
    {
        $waktu = '';
        if (date('H') >= 16) {
            $waktu = 'Malam';
        }
        if (date('H') >= 06 && date('H') < 10) {
            $waktu = 'Pagi';
        }
        if (date('H') >= 10 && date('H') < 16) {
            $waktu = 'Siang';
        }
        return $waktu;
    }
}
