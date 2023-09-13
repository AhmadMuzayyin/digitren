<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kamar extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($kamar) {
            $activity = class_basename($kamar).' '.$kamar->nama;
            $kamar->CreateLog('Creating '.$activity);
        });

        self::updating(function ($kamar) {
            $activity = class_basename($kamar).' '.$kamar->nama;
            $kamar->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($kamar) {
            $activity = class_basename($kamar).' '.$kamar->nama;
            $kamar->CreateLog('Deleting '.$activity);
        });
    }
}
