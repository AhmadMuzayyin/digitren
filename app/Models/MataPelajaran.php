<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataPelajaran extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($mata_pelajaran) {
            $activity = class_basename($mata_pelajaran).' '.$mata_pelajaran->nama;
            $mata_pelajaran->CreateLog('Creating '.$activity);
        });

        self::updating(function ($mata_pelajaran) {
            $activity = class_basename($mata_pelajaran).' '.$mata_pelajaran->nama;
            $mata_pelajaran->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($mata_pelajaran) {
            $activity = class_basename($mata_pelajaran).' '.$mata_pelajaran->nama;
            $mata_pelajaran->CreateLog('Deleting '.$activity);
        });
    }
}
