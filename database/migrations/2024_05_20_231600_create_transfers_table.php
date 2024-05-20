<?php

use App\Models\Santri;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Santri::class, 'pengirim_id')->constrained('santris')->cascadeOnDelete();
            $table->foreignIdFor(Santri::class, 'penerima_id')->constrained('santris')->cascadeOnDelete();
            $table->bigInteger('jumlah_transfer');
            $table->string('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfers');
    }
};
