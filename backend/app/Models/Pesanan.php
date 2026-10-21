<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Pesanan extends Model
{
    protected $table = 'pesanan';

    protected $fillable = [
        'user_id',
        'no_order',
        'tgl_order',
        'total',
        'status',
        'tipe_pesanan',
        'alamat',
        'kurir',
        'ongkir',
        'no_resi',
    ];

    protected $casts = [
        'tgl_order' => 'datetime',
        'total'     => 'decimal:0',
        'ongkir'    => 'decimal:0',
    ];

    /**
     * Pesanan dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Pesanan memiliki banyak detail pesanan.
     */
    public function detailPesanans(): HasMany
    {
        return $this->hasMany(DetailPesanan::class, 'pesanan_id');
    }

    /**
     * Pesanan memiliki satu pembayaran.
     */
    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'pesanan_id');
    }
}
