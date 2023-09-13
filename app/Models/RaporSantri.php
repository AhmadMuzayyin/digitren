<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RaporSantri extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function mata_pelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
