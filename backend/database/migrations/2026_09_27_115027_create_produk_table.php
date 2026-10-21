<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->onDelete('cascade');
            $table->string('nama_produk', 200);
            $table->string('slug', 200)->unique();
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 10, 0);
            $table->enum('tipe', ['fisik', 'digital']);
            $table->integer('stok')->default(0);
            $table->string('status_kondisi', 50)->default('Baik');
            $table->string('gambar')->nullable();
            $table->string('file_pdf')->nullable();
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};
