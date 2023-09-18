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
            $activity = class_basename($tabungan).' '.$tabungan->santri->user->name;
            $tabungan->CreateLog('Creating '.$activity);
        });

        self::updating(function ($tabungan) {
            $activity = class_basename($tabungan).' '.$tabungan->santri->user->name;
            $tabungan->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($tabungan) {
            $activity = class_basename($tabungan).' '.$tabungan->santri->user->name;
            $tabungan->CreateLog('Deleting '.$activity);
        });
    }

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
