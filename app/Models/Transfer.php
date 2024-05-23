<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function pengirim()
    {
        return $this->belongsTo(Santri::class, 'pengirim_id');
    }

    public function penerima()
    {
        return $this->belongsTo(Santri::class, 'penerima_id');
    }
}
