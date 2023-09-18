<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiTabungan extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($transaksi_tabungan) {
            $activity = class_basename($transaksi_tabungan).' '.$transaksi_tabungan->santri->user->name.' '.$transaksi_tabungan->jenis_transaksi.' '.$transaksi_tabungan->jumlah_transaksi;
            $transaksi_tabungan->CreateLog('Creating '.$activity);
        });

        self::updating(function ($transaksi_tabungan) {
            $activity = class_basename($transaksi_tabungan).' '.$transaksi_tabungan->santri->user->name.' '.$transaksi_tabungan->jenis_transaksi.' '.$transaksi_tabungan->jumlah_transaksi;
            $transaksi_tabungan->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($transaksi_tabungan) {
            $activity = class_basename($transaksi_tabungan).' '.$transaksi_tabungan->santri->user->name.' '.$transaksi_tabungan->jenis_transaksi.' '.$transaksi_tabungan->jumlah_transaksi;
            $transaksi_tabungan->CreateLog('Deleting '.$activity);
        });
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
