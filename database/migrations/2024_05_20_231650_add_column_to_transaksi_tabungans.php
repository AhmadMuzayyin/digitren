<?php

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
        Schema::table('transaksi_tabungans', function (Blueprint $table) {
            $table->bigInteger('saldo_sebelumnya')->after('jumlah_transaksi')->nullable();
            $table->bigInteger('keterangan')->after('saldo_saatini')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transaksi_tabungans', function (Blueprint $table) {
            $table->dropColumn('saldo_sebelumnya');
            $table->dropColumn('keterangan');
        });
    }
};
