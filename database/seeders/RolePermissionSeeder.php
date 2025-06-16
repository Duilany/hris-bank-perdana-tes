<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Hapus semua user jika perlu (opsional saat pengembangan)
        // User::truncate();

        // Buat Superadmin HC
        User::create([
            'name' => 'Superadmin HC',
            'email' => 'hc@bankperdana.com',
            'password' => Hash::make('password'),
            'role' => 'hc',
        ]);

        // Tambahan: Buat beberapa user lain (opsional)
        User::create([
            'name' => 'Direksi 1',
            'email' => 'direksi@bankperdana.com',
            'password' => Hash::make('password'),
            'role' => 'direksi',
        ]);

        User::create([
            'name' => 'Manajer 1',
            'email' => 'manajer@bankperdana.com',
            'password' => Hash::make('password'),
            'role' => 'manajer',
        ]);

        User::create([
            'name' => 'Staf Support',
            'email' => 'support@bankperdana.com',
            'password' => Hash::make('password'),
            'role' => 'staf_support',
        ]);

        User::create([
            'name' => 'Staf Bisnis',
            'email' => 'bisnis@bankperdana.com',
            'password' => Hash::make('password'),
            'role' => 'staf_bisnis',
        ]);
    }
}
