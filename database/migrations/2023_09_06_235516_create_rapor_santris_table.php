<?php

use App\Models\Santri;
use App\Models\TahunAkademik;
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
            $table->foreignIdFor(TahunAkademik::class)->constrained()->cascadeOnDelete();
            $table->float('jml_nilai_semester')->nullable();
            $table->float('nilai_rata_rata_semester')->nullable();
            $table->float('etika')->nullable();
            $table->float('kerajinan')->nullable();
            $table->float('kerapian')->nullable();
            $table->float('sakit')->nullable();
            $table->float('izin')->nullable();
            $table->float('alpha')->nullable();
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
