<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, HasRoles, LogActivity, Notifiable;

    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($user) {
            $activity = class_basename($user) . " $user->name";
            $user->CreateLog('Creatting ' . $activity);
        });

        self::updating(function ($user) {
            $activity = class_basename($user) . " $user->name";
            $user->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($user) {
            $activity = class_basename($user) . " $user->name";
            $user->CreateLog('Deleting ' . $activity);
        });
    }
    public function santri()
    {
        return $this->hasOne(Santri::class);
    }
}
