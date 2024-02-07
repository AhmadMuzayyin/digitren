<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlamatSantri extends Model
{
    use HasFactory;
    protected $guarded = ['id'];
    public function santri()
    {
        return $this->belongsTo(Santri::class);
    }
    public function provinsi()
    {
        return $this->belongsTo(Provinsi::class);
    }
    public function kabupaten()
    {
        return $this->belongsTo(Kabupaten::class);
    }
    public function kecamatan()
    {
        return $this->belongsTo(Kecamatan::class);
    }
    public function kelurahan()
    {
        return $this->belongsTo(Kelurahan::class);
    }
}
