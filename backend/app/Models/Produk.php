<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Produk extends Model
{
    protected $table = 'produk';

    protected $fillable = [
        'kategori_id',
        'nama_produk',
        'slug',
        'deskripsi',
        'harga',
        'tipe',
        'stok',
        'status_kondisi',
        'gambar',
        'file_pdf',
        'status',
    ];

    protected $casts = [
        'harga' => 'decimal:0',
        'stok'  => 'integer',
    ];

    /**
     * Produk dimiliki oleh satu kategori.
     */
    public function kategori(): BelongsTo
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * Produk memiliki banyak detail pesanan.
     */
    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'produk_id');
    }

    /**
     * Produk memiliki banyak entri keranjang.
     */
    public function keranjangs(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'produk_id');
    }
}
