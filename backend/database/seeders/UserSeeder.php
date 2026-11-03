<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

/**
 * Accounts for local development and Postman testing.
 *
 * Passwords come from SEED_PASSWORD in .env so nothing sensitive is committed.
 * Never run this against a shared database: it creates accounts with a
 * predictable password.
 */
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make((string) env('SEED_PASSWORD', 'password'));

        $akun = [
            [
                'name' => 'Administrator',
                'email' => 'admin@brida.test',
                'role' => User::ROLE_ADMIN,
                'instansi' => 'BRIDA Kota Makassar',
            ],
            [
                'name' => 'Verifikator Satu',
                'email' => 'verifikator@brida.test',
                'role' => User::ROLE_VERIFIKATOR,
                'instansi' => 'BRIDA Kota Makassar',
            ],
            [
                'name' => 'Inovator Satu',
                'email' => 'inovator@brida.test',
                'role' => User::ROLE_INOVATOR,
                'instansi' => 'Dinas Kominfo',
            ],
        ];

        foreach ($akun as $data) {
            User::updateOrCreate(
                ['email' => $data['email']],
                [...$data, 'password' => $password, 'aktif' => true],
            );
        }
    }
}
