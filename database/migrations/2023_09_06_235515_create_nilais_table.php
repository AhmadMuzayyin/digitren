<?php

use App\Models\MataPelajaran;
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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Santri::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(MataPelajaran::class)->constrained();
            $table->foreignIdFor(TahunAkademik::class)->constrained()->cascadeOnDelete();
            $table->integer('nilai')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
