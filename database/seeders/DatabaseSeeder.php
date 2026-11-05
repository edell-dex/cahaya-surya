<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Akun default Super Admin & Admin (Idempotent: aman dijalankan berulang)
        DB::table('users')->updateOrInsert(
            ['email' => 'superadmin@cahayasurya.com'],
            [
                'name'       => 'Super Administrator',
                'password'   => Hash::make('super@dmincahaya_'),
                'role'       => 'superadmin',
                'no_hp'      => '08111111111',
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        DB::table('users')->updateOrInsert(
            ['email' => 'admin@cahayasurya.com'],
            [
                'name'       => 'Staff Pendaftaran',
                'password'   => Hash::make('@dmincahaya_'),
                'role'       => 'admin',
                'no_hp'      => '08222222222',
                'status'     => 'aktif',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }
}
