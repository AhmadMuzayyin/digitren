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
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('favicon')->nullable();
            $table->string('logo')->nullable();
            $table->boolean('whatsapp_feature')->default(false)->nullable();
            $table->string('kts_master')->nullable();
            $table->bigInteger('sender')->nullable();
            $table->string('whatsapp_api_key')->nullable();
            $table->boolean('log_activity')->default(false)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
