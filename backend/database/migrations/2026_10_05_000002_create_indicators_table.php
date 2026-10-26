<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->id();
            $table->unsignedTinyInteger('kode')->unique();
            $table->string('nama');
            $table->text('deskripsi')->nullable();
            $table->unsignedTinyInteger('bobot');
            $table->boolean('wajib')->default(false);
            $table->string('tipe_bukti');
            $table->string('rentang_tahun')->default('t0');
            $table->boolean('dalam_scope')->default(true);
            $table->unsignedSmallInteger('urutan')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('indicators');
    }
};
