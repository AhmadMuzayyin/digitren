<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Syncronize extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($syncronize) {
            $syncronize->CreateLog('Creatting '.class_basename($syncronize));
        });

        self::updating(function ($syncronize) {
            $syncronize->CreateLog('Updating '.class_basename($syncronize));
        });
    }
}
