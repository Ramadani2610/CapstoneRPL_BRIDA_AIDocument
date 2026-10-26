<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Per-indicator, per-year achievement thresholds ("parameter" in the UI).
 * Split by year because thresholds change between years.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicator_tiers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('indicator_id')->constrained('indicators')->cascadeOnDelete();
            $table->unsignedSmallInteger('tahun');
            $table->unsignedTinyInteger('bintang');
            $table->string('label');
            $table->text('deskripsi_bukti')->nullable();
            $table->json('konfigurasi')->nullable();
            $table->timestamps();

            $table->unique(['indicator_id', 'tahun', 'bintang']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicator_tiers');
    }
};
