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
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Kelas::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Kamar::class)->nullable()->constrained()->cascadeOnDelete();
            $table->foreignIdFor(WaliSantri::class)->constrained()->cascadeOnDelete();
            $table->string('no_induk', 8)->unique();
            $table->string('dusun');
            $table->string('desa');
            $table->string('kecamatan');
            $table->string('kabupaten');
            $table->string('provinsi');
            $table->enum('jenis_kelamin', ['Laki-Laki', 'Perempuan']);
            $table->bigInteger('nik');
            $table->bigInteger('kk');
            $table->bigInteger('whatsapp');
            $table->integer('tanggal_lahir');
            $table->integer('bulan_lahir');
            $table->integer('tahun_lahir');
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
