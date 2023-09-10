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
        self::creating(function ($transaksi) {
            $transaksi->CreateLog('Creatting '.class_basename($transaksi));
        });

        self::updating(function ($transaksi) {
            $transaksi->CreateLog('Updating '.class_basename($transaksi));
        });
        self::deleting(function ($transaksi) {
            $transaksi->CreateLog('Deleting '.class_basename($transaksi));
        });
    }

    public function satri()
    {
        return $this->belongsTo(Santri::class);
    }
}
