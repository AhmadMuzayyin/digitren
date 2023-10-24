<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static where(string $string, mixed $kode_kamar)
 * @method static findOrFail($kamar_id)
 */
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
