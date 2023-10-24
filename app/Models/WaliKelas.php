<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($wali_kelas) {
            $activity = class_basename($wali_kelas)." $wali_kelas->santri->user->name";
            $wali_kelas->CreateLog('Creatting '.$activity);
        });

        self::updating(function ($wali_kelas) {
            $activity = class_basename($wali_kelas)." $wali_kelas->santri->user->name";
            $wali_kelas->CreateLog('Updating '.$activity);
        });
        self::deleting(function ($wali_kelas) {
            $activity = class_basename($wali_kelas)." $wali_kelas->santri->user->name";
            $wali_kelas->CreateLog('Deleting '.$activity);
        });
    }
}
