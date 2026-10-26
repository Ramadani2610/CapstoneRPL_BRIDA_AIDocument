<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Machine output (rules / LLM). A suggestion only, never the final score.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ai_assessments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('indicator_id')->constrained('indicators');
            $table->string('mesin');
            $table->string('model')->nullable();
            $table->string('versi_prompt')->nullable();
            $table->unsignedTinyInteger('usulan_bintang')->nullable();
            $table->decimal('keyakinan', 4, 3)->nullable();
            $table->text('ringkasan')->nullable();
            $table->json('keluaran_mentah')->nullable();
            $table->timestamp('dibuat_pada')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ai_assessments');
    }
};
