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
            $kelas->CreateLog('Creatting '.class_basename($kelas));
        });

        self::updating(function ($kelas) {
            $kelas->CreateLog('Updating '.class_basename($kelas));
        });
        self::deleting(function ($kelas) {
            $kelas->CreateLog('Deleting '.class_basename($kelas));
        });
    }
}
