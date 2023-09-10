<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tabungan extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($tabungan) {
            $tabungan->CreateLog('Creatting '.class_basename($tabungan));
        });

        self::updating(function ($tabungan) {
            $tabungan->CreateLog('Updating '.class_basename($tabungan));
        });
        self::deleting(function ($tabungan) {
            $tabungan->CreateLog('Deleting '.class_basename($tabungan));
        });
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
