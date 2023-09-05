<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiTabungan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function satri()
    {
        return $this->belongsTo(Santri::class);
    }
}
