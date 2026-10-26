<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('inovator')->after('password');
            $table->string('instansi')->nullable()->after('role');
            $table->boolean('aktif')->default(true)->after('instansi');
            $table->timestamp('login_terakhir')->nullable()->after('aktif');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'instansi', 'aktif', 'login_terakhir']);
        });
    }
};
