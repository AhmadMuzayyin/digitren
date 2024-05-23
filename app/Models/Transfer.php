<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory, LogActivity;
    protected $guarded = ['id'];
    public function pengirim()
    {
        return $this->belongsTo(Santri::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(Santri::class, 'penerima_id');
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $transfer = class_basename($user) . " $user->name";
            $user->CreateLog('Creatting ' . $transfer);
        });

        self::updating(function ($user) {
            $transfer = class_basename($user) . " $user->name";
            $user->CreateLog('Updating ' . $transfer);
        });
        self::deleting(function ($user) {
            $transfer = class_basename($user) . " $user->name";
            $user->CreateLog('Deleting ' . $transfer);
        });
    }
}
