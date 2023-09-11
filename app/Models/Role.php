<?php

namespace App\Models;

use App\Models\User;
use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role extends Model
{
    use HasFactory, LogActivity;
    protected $guarded = ['id'];

    public function user()
    {
        return $this->hasMany(User::class);
    }
    public static function boot()
    {
        parent::boot();
        self::creating(function ($role) {
            $activity = class_basename($role) . " $role->name";
            $role->CreateLog('Creatting ' . $activity);
        });

        self::updating(function ($role) {
            $activity = class_basename($role) . " $role->name";
            $role->CreateLog('Updating ' . $activity);
        });
        self::deleting(function ($role) {
            $activity = class_basename($role) . " $role->name";
            $role->CreateLog('Deleting ' . $activity);
        });
    }
}
