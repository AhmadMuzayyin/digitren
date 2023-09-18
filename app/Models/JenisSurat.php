<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisSurat extends Model
{
    use HasFactory, LogActivity;
    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($jenis_surat) {
            $activity = class_basename($jenis_surat) . " $jenis_surat->name";
            $jenis_surat->CreateLog('Creatting ' . $activity);
        });

        self::updating(function ($jenis_surat) {
            $activity = class_basename($jenis_surat) . " $jenis_surat->name";
            $jenis_surat->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($jenis_surat) {
            $activity = class_basename($jenis_surat) . " $jenis_surat->name";
            $jenis_surat->CreateLog('Deleting ' . $activity);
        });
    }
}
