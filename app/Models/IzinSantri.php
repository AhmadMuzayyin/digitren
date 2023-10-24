<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IzinSantri extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($izinsantri) {
            $activity = class_basename($izinsantri)." $izinsantri->santri->user->name . $izinsantri->jenis_surat->name . $izinsantri->tujuan";
            $izinsantri->CreateLog('Creatting '.$activity);
        });

        self::updating(function ($izinsantri) {
            $activity = class_basename($izinsantri)." $izinsantri->santri->user->name . $izinsantri->jenis_surat->name . $izinsantri->tujuan";
            $izinsantri->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($izinsantri) {
            $activity = class_basename($izinsantri)." $izinsantri->santri->user->name . $izinsantri->jenis_surat->name . $izinsantri->tujuan";
            $izinsantri->CreateLog('Deleting '.$activity);
        });
    }
}
