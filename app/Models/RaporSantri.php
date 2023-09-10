<?php

namespace App\Models;

use App\Models\MataPelajaran;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RaporSantri extends Model
{
    use HasFactory;
    protected $guarded = ['id'];

    public function mata_pelajaran()
    {
        return $this->belongsTo(MataPelajaran::class);
    }
}
