<?php

use App\Models\Kamar;
use App\Models\Kelas;
use App\Models\User;
use App\Models\WaliSantri;
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
        Schema::create('santris', function (Blueprint $table) {
            $table->id();
            $table->string('no_induk', 8)->unique();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->string('nik')->default('0000000000000000');
            $table->string('kk')->default('0000000000000000');
            $table->bigInteger('whatsapp');
            $table->date('tanggal_lahir');
            $table->string('tempat_lahir');
            $table->date('tahun_masuk')->nullable();
            $table->string('tahun_masuk_hijriyah')->nullable();
            $table->date('tanggal_boyong')->nullable();
            $table->string('tanggal_boyong_hijriyah')->nullable();
            $table->enum('status', ['Santri Aktif', 'Santri Alumni'])->default('Santri Aktif');
            $table->integer('maksimal_perizinan')->default(10);
            $table->string('foto')->default('santri.png');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('santris');
    }
};
