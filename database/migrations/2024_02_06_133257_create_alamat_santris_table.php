<?php

use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\Provinsi;
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
        Schema::create('alamat_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Santri::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Provinsi::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Kabupaten::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Kecamatan::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Kelurahan::class)->constrained()->cascadeOnDelete();
            $table->string('dusun');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alamat_santris');
    }
};
