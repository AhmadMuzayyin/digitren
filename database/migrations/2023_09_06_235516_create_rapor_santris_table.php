<?php

use App\Models\MataPelajaran;
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
        Schema::create('rapor_santris', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Santri::class)->constrained()->cascadeOnDelete();
            $table->enum('semester', ['Satu', 'Dua']);
            $table->integer('nilai_semester');
            $table->integer('nilai_rata_rata');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rapor_santris');
    }
};
