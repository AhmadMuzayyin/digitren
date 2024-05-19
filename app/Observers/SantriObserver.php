<?php

namespace App\Observers;

use App\Models\Kamar;
use App\Models\Santri;

class SantriObserver
{
    public function created(Santri $santri)
    {
        $this->updateJumlahSantri($santri->kamar_id);
    }

    public function updated(Santri $santri)
    {
        if ($santri->isDirty('kamar_id')) {
            // Jika kamar_id berubah, update jumlah_santri pada kamar lama dan baru
            $this->updateJumlahSantri($santri->getOriginal('kamar_id'));
            $this->updateJumlahSantri($santri->kamar_id);
        }
    }

    public function deleted(Santri $santri)
    {
        $this->updateJumlahSantri($santri->kamar_id);
    }

    protected function updateJumlahSantri($kamarId)
    {
        if ($kamarId) {
            $jumlahSantri = Santri::where('kamar_id', $kamarId)->count();
            Kamar::where('id', $kamarId)->update(['jumlah_santri' => $jumlahSantri]);
        }
    }
}
