<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * One row per indicator per submission: the tier the innovator claims.
 * Files follow in `evidences`.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submission_parameters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('indicator_id')->constrained('indicators');
            $table->foreignId('tier_id')->nullable()->constrained('indicator_tiers');
            $table->unsignedTinyInteger('bintang_diklaim')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['submission_id', 'indicator_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submission_parameters');
    }
};
