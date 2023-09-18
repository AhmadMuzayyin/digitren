<?php

use App\Models\JenisSurat;
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
        Schema::create('izin_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(JenisSurat::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Santri::class)->constrained()->cascadeOnDelete();
            $table->string('tujuan');
            $table->date('tanggal_keluar');
            $table->date('tanggal_kembali');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('izin_santris');
    }
};
