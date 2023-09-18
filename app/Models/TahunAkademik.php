<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAkademik extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($tahun_akademik) {
            $activity = class_basename($tahun_akademik) . " $tahun_akademik->tahun_akademik";
            $tahun_akademik->CreateLog('Creatting ' . $activity);
        });

        self::updating(function ($tahun_akademik) {
            $activity = class_basename($tahun_akademik) . " $tahun_akademik->tahun_akademik";
            $tahun_akademik->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($tahun_akademik) {
            $activity = class_basename($tahun_akademik) . " $tahun_akademik->tahun_akademik";
            $tahun_akademik->CreateLog('Deleting ' . $activity);
        });
    }
}
