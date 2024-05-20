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
        Schema::create('transaksi_tabungans', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Santri::class)->constrained()->cascadeOnDelete();
            $table->date('tanggal_transaksi')->default(date('Y-m-d'));
            $table->enum('jenis_transaksi', ['Setoran', 'Penarikan']);
            $table->string('tujuan')->nullable();
            $table->bigInteger('jumlah_transaksi')->default(0);
            $table->bigInteger('saldo_saatini')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_tabungans');
    }
};
