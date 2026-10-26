<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('judul');
            $table->text('deskripsi')->nullable();
            $table->string('opd');
            $table->string('kategori')->nullable();
            $table->unsignedSmallInteger('tahun');
            $table->string('status')->default('draft');
            $table->foreignId('verifikator_id')->nullable()->constrained('users');
            $table->timestamp('submitted_at')->nullable();
            $table->timestamp('decided_at')->nullable();
            $table->decimal('total_skor', 6, 2)->nullable();
            $table->string('predikat')->nullable();
            $table->text('catatan_revisi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
