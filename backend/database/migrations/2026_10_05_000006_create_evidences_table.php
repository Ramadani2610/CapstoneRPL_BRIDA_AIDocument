<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evidences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('submission_id')->constrained('submissions')->cascadeOnDelete();
            $table->foreignId('indicator_id')->constrained('indicators');
            $table->foreignId('submission_parameter_id')->nullable()->constrained('submission_parameters');
            $table->string('nama_asli');
            $table->string('path');
            $table->string('tipe_file');
            $table->string('mime')->nullable();
            $table->unsignedBigInteger('ukuran');
            $table->unsignedSmallInteger('tahun_dokumen')->nullable();
            $table->longText('teks_ocr')->nullable();
            $table->string('status_ocr')->default('belum');
            $table->text('catatan')->nullable();
            $table->timestamp('uploaded_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evidences');
    }
};
