<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory, LogActivity;
    protected $guarded = ['id'];
    public static function boot()
    {
        parent::boot();
        self::creating(function ($setting) {
            $activity = class_basename($setting);
            $setting->CreateLog('Creatting ' . $activity);
        });

        self::updating(function ($setting) {
            $activity = class_basename($setting);
            $setting->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($setting) {
            $activity = class_basename($setting);
            $setting->CreateLog('Deleting ' . $activity);
        });
    }
}
