<?php

namespace App\Models;

use App\Models\Santri;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tabungan extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
}
