<?php

use App\Models\Santri;
use App\Models\MataPelajaran;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->enum('semester', ['Satu', 'Dua']);
            $table->integer('nilai');
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
