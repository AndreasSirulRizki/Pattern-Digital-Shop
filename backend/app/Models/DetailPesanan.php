<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPesanan extends Model
{
    protected $table = 'detail_pesanan';

    protected $fillable = [
        'pesanan_id',
        'produk_id',
        'jumlah',
        'harga',
        'subtotal',
    ];

    protected $casts = [
        'jumlah'   => 'integer',
        'harga'    => 'decimal:0',
        'subtotal' => 'decimal:0',
    ];

    /**
     * Detail pesanan dimiliki oleh satu pesanan.
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }

    /**
     * Detail pesanan merujuk ke satu produk.
     */
    public function produk(): BelongsTo
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
