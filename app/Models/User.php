<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Role;
use App\Traits\LogActivity;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, LogActivity, Notifiable;
    protected $guarded = ['id'];

    protected $hidden = [
        'password',
    ];
    protected $casts = [
        'password' => 'hashed',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
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
}
