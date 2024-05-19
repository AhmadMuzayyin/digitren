<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KamarSantri extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }
}
