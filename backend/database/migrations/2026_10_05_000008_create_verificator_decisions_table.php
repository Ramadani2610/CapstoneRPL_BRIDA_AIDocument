<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Human verdict — the single source of truth for scores.
 * `bobot_saat_itu` is copied rather than referenced so past scores stay
 * stable when weights change in later years.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('verificator_decisions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('indicator_id')->constrained('indicators');
            $table->foreignId('ai_assessment_id')->nullable()->constrained('ai_assessments');
            $table->unsignedTinyInteger('bobot_saat_itu');
            $table->unsignedTinyInteger('bintang_final');
            $table->decimal('skor', 6, 2);
            $table->boolean('sesuai_rekomendasi_ai')->nullable();
            $table->text('catatan')->nullable();
            $table->foreignId('diputuskan_oleh')->constrained('users');
            $table->timestamp('diputuskan_pada')->nullable();
            $table->timestamps();

            $table->unique(['submission_id', 'indicator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('verificator_decisions');
    }
};
