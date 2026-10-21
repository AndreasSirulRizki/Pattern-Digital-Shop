<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK check sementara agar truncate bisa jalan
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Kategori::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $kategoris = [
            'Kemeja Pria',
            'Kemeja Wanita',
            'Gaun & Dress',
            'Celana & Rok',
            'Aksesoris',
        ];

        foreach ($kategoris as $nama) {
            Kategori::create([
                'nama_kategori' => $nama,
                'slug'          => Str::slug($nama),
            ]);
        }
    }
}
