<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Playstation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Membuat Akun Admin Utama
        User::create([
            'name' => 'Akun Admin',
            'email' => 'admin@rental.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // 2. Membuat Akun Contoh (Budi)
        User::create([
            'name' => 'Budi Penyewa',
            'email' => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role' => 'penyewa',
        ]);

        // 3. AKUN BARU: Membuat Akun Kelvin Raditya Resmi di Database
        User::create([
            'name' => 'Kelvin Raditya',
            'email' => 'kelvinraditya80@gmail.com',
            'password' => Hash::make('password123'), // Password untuk login kamu
            'role' => 'penyewa',
        ]);

        // 4. Membuat 5 Unit PlayStation Berjejer
        Playstation::create(['nama_unit' => 'PS5 VIP Room 1', 'jenis' => 'PS5', 'harga_per_jam' => 15000, 'status' => 'tersedia']);
        Playstation::create(['nama_unit' => 'PS4 Standar Desk 3', 'jenis' => 'PS4', 'harga_per_jam' => 8000, 'status' => 'tersedia']);
        Playstation::create(['nama_unit' => 'ps 4 vip 2', 'jenis' => 'PS5', 'harga_per_jam' => 20000, 'status' => 'tersedia']);
        Playstation::create(['nama_unit' => 'PlayStation 4 Reguler', 'jenis' => 'PS4', 'harga_per_jam' => 7000, 'status' => 'tersedia']);
        Playstation::create(['nama_unit' => 'PlayStation 5 Deluxe', 'jenis' => 'PS5', 'harga_per_jam' => 18000, 'status' => 'tersedia']);
    }
}