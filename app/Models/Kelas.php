<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($kelas) {
            $activity = class_basename($kelas) . ' ' . $kelas->tingkatan . ' ' . $kelas->kelas;
            $kelas->CreateLog('Creating ' . $activity);
        });

        self::updating(function ($kelas) {
            $activity = class_basename($kelas) . ' ' . $kelas->tingkatan . ' ' . $kelas->kelas;
            $kelas->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($kelas) {
            $activity = class_basename($kelas) . ' ' . $kelas->tingkatan . ' ' . $kelas->kelas;
            $kelas->CreateLog('Deleting ' . $activity);
        });
    }
}
