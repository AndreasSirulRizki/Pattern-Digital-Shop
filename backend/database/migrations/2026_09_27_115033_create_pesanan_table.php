<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('no_order', 50)->unique();
            $table->timestamp('tgl_order');
            $table->decimal('total', 12, 0);
            $table->enum('status', ['pending', 'diproses', 'dikirim', 'selesai', 'dibatalkan'])->default('pending');
            $table->enum('tipe_pesanan', ['fisik', 'digital']);
            $table->text('alamat')->nullable();
            $table->string('kurir', 50)->nullable();
            $table->decimal('ongkir', 10, 0)->default(0);
            $table->string('no_resi', 50)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan');
    }
};
