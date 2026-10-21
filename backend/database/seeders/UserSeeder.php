<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK check sementara agar truncate bisa jalan
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        User::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        User::create([
            'name'     => 'Admin Pattern',
            'email'    => 'admin@patternshop.com',
            'password' => Hash::make('password123'),
            'role'     => 'admin',
            'no_hp'    => '081234567890',
            'alamat'   => 'Jl. Merdeka No. 10, Bandung',
        ]);

        User::create([
            'name'     => 'Budi Customer',
            'email'    => 'budi@gmail.com',
            'password' => Hash::make('password123'),
            'role'     => 'customer',
            'no_hp'    => '082345678901',
            'alamat'   => 'Jl. Sudirman No. 5, Jakarta',
        ]);
    }
}
