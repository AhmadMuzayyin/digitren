<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliSantri extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($wali) {
            $wali->CreateLog('Creatting ' . class_basename($wali));
        });

        self::updating(function ($wali) {
            $wali->CreateLog('Updating ' . class_basename($wali));
        });
        self::deleting(function ($wali) {
            $wali->CreateLog('Deleting ' . class_basename($wali));
        });
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
