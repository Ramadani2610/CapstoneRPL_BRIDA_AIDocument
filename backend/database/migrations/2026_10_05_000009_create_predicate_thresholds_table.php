<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('predicate_thresholds', function (Blueprint $table) {
            $table->id();
            $table->unsignedSmallInteger('tahun');
            $table->string('nama_predikat');
            $table->decimal('skor_min', 6, 2);
            $table->decimal('skor_max', 6, 2);
            $table->timestamps();

            $table->unique(['tahun', 'nama_predikat']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('predicate_thresholds');
    }
};
