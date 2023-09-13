<?php

namespace App\Models;

use App\Traits\LogActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Santri extends Model
{
    use HasFactory, LogActivity;

    protected $guarded = ['id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function wali_santri()
    {
        return $this->hasMany(WaliSantri::class);
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function kamar()
    {
        return $this->belongsTo(Kamar::class);
    }

    public function tabungan()
    {
        return $this->hasMany(Tabungan::class);
    }

    public function transaksi_tabungan()
    {
        return $this->hasMany(TransaksiTabungan::class);
    }

    public function rapor_santri()
    {
        return $this->hasMany(RaporSantri::class);
    }

    public static function boot()
    {
        parent::boot();
        self::creating(function ($santri) {
            // buat log
            $activity = class_basename($santri).' '.$santri->user->name;
            $santri->CreateLog("Creating $activity");
            // Saat pembuatan santri baru, tambahkan jumlah_santri
            if ($santri->kamar_id) {
                $oldKamar = Kamar::find($santri->kamar_id);
                if ($oldKamar) {
                    $oldKamar->jumlah_santri + 1;
                }
            }
        });

        self::updating(function ($santri) {
            // buat log
            $activity = class_basename($santri).' '.$santri->user->name;
            $santri->CreateLog("Updating $activity");
            // Saat pembaruan kamar_id, kurangkan dari kamar lama dan tambahkan ke kamar baru
            if ($santri->isDirty('kamar_id')) {
                // Kurangkan dari kamar lama
                $oldKamar = Kamar::find($santri->getOriginal('kamar_id'));
                if ($oldKamar) {
                    $oldKamar->decrement('jumlah_santri');
                }

                // Tambahkan ke kamar baru
                $newKamar = Kamar::find($santri->kamar_id);
                if ($newKamar) {
                    $newKamar->increment('jumlah_santri');
                }
            }
        });

        self::deleting(function ($santri) {
            // buat log
            $activity = class_basename($santri).' '.$santri->user->name;
            $santri->CreateLog("Deleting $activity");
            // Saat santri dihapus, kurangkan jumlah_santri di kamar terkait
            $kamar = Kamar::find($santri->kamar_id);
            if ($kamar) {
                $kamar->decrement('jumlah_santri');
            }
        });
    }
}
