<?php

namespace Database\Seeders;

use App\Models\Produk;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProdukSeeder extends Seeder
{
    public function run(): void
    {
        // Disable FK check sementara agar truncate bisa jalan
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Produk::truncate();
        \Illuminate\Support\Facades\DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $produks = [
            // ── 5 Produk FISIK ──────────────────────────────────────────────
            [
                'kategori_id'    => 1, // Kemeja Pria
                'nama_produk'    => 'Pola Kemeja Pria Slim Fit',
                'deskripsi'      => 'Pola kemeja pria potongan slim fit cocok untuk berbagai ukuran. Dilengkapi petunjuk jahit lengkap dan detail ukuran yang akurat. Cocok untuk pemula maupun penjahit berpengalaman.',
                'harga'          => 75000,
                'tipe'           => 'fisik',
                'stok'           => 20,
                'gambar'         => 'produk/kemeja-pria-slim-fit.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 2, // Kemeja Wanita
                'nama_produk'    => 'Pola Kemeja Wanita Formal',
                'deskripsi'      => 'Pola kemeja wanita bergaya formal dengan detail kerah yang elegan. Tersedia dalam berbagai ukuran S hingga XXL. Bahan kertas berkualitas tebal agar mudah digunting.',
                'harga'          => 80000,
                'tipe'           => 'fisik',
                'stok'           => 15,
                'gambar'         => 'produk/kemeja-wanita-formal.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 3, // Gaun & Dress
                'nama_produk'    => 'Pola Gaun Pesta Malam',
                'deskripsi'      => 'Pola gaun pesta malam dengan siluet mermaid yang memukau. Dilengkapi panduan pemilihan kain dan teknik jahit khusus gaun malam. Ideal untuk acara formal dan semi-formal.',
                'harga'          => 150000,
                'tipe'           => 'fisik',
                'stok'           => 10,
                'gambar'         => 'produk/gaun-pesta-malam.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 4, // Celana & Rok
                'nama_produk'    => 'Pola Celana Chino Pria',
                'deskripsi'      => 'Pola celana chino pria model slim tapered yang trendi dan nyaman. Ukuran 28 hingga 38 sudah termasuk dalam satu set pola. Cocok untuk kain katun drill maupun kanvas.',
                'harga'          => 90000,
                'tipe'           => 'fisik',
                'stok'           => 25,
                'gambar'         => 'produk/celana-chino-pria.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 4, // Celana & Rok
                'nama_produk'    => 'Pola Rok Span Wanita',
                'deskripsi'      => 'Pola rok span wanita potongan pencil yang feminin dan profesional. Tersedia ukuran XS hingga XL dengan detail jahitan resleting belakang. Cocok untuk kain crepe atau scuba.',
                'harga'          => 65000,
                'tipe'           => 'fisik',
                'stok'           => 30,
                'gambar'         => 'produk/rok-span-wanita.jpg',
                'file_pdf'       => null,
            ],

            // ── 5 Produk DIGITAL ────────────────────────────────────────────
            [
                'kategori_id'    => 1, // Kemeja Pria
                'nama_produk'    => 'Pola Kemeja Pria Basic (PDF)',
                'deskripsi'      => 'File PDF pola kemeja pria basic yang siap cetak dengan ukuran A4. Download langsung setelah pembayaran selesai. Tersedia ukuran S, M, L, XL dalam satu file.',
                'harga'          => 35000,
                'tipe'           => 'digital',
                'stok'           => 0,
                'gambar'         => 'produk/kemeja-pria-basic-pdf.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 2, // Kemeja Wanita
                'nama_produk'    => 'Pola Kemeja Wanita Modern (PDF)',
                'deskripsi'      => 'File PDF pola kemeja wanita model modern dengan detail crop dan puff sleeve. Instruksi jahit dalam format PDF lengkap dengan ilustrasi. Dapat langsung dicetak di rumah.',
                'harga'          => 40000,
                'tipe'           => 'digital',
                'stok'           => 0,
                'gambar'         => 'produk/kemeja-wanita-modern-pdf.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 3, // Gaun & Dress
                'nama_produk'    => 'Pola Gaun Casual (PDF)',
                'deskripsi'      => 'File PDF pola gaun casual bergaya Bohemian yang ringan dan nyaman. Cocok untuk kain rayon, sifon, atau linen tipis. Download langsung tersedia setelah transaksi berhasil.',
                'harga'          => 55000,
                'tipe'           => 'digital',
                'stok'           => 0,
                'gambar'         => 'produk/gaun-casual-pdf.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 4, // Celana & Rok
                'nama_produk'    => 'Pola Celana Pendek (PDF)',
                'deskripsi'      => 'File PDF pola celana pendek unisex model cargo dengan banyak kantong. Ukuran S hingga XL dalam satu file PDF siap cetak. Panduan jahit disertakan dengan gambar langkah demi langkah.',
                'harga'          => 30000,
                'tipe'           => 'digital',
                'stok'           => 0,
                'gambar'         => 'produk/celana-pendek-pdf.jpg',
                'file_pdf'       => null,
            ],
            [
                'kategori_id'    => 4, // Celana & Rok
                'nama_produk'    => 'Pola Rok A-Line (PDF)',
                'deskripsi'      => 'File PDF pola rok A-line klasik yang timeless dan mudah dijahit. Sangat cocok untuk pemula karena instruksinya sangat detail dan ilustratif. Tersedia ukuran XS hingga XL.',
                'harga'          => 45000,
                'tipe'           => 'digital',
                'stok'           => 0,
                'gambar'         => 'produk/rok-a-line-pdf.jpg',
                'file_pdf'       => null,
            ],
        ];

        foreach ($produks as $data) {
            Produk::create(array_merge($data, [
                'slug'           => Str::slug($data['nama_produk']),
                'status_kondisi' => 'Baik',
                'status'         => 'aktif',
            ]));
        }
    }
}
