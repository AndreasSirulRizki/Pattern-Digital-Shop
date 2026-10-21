<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayaran';

    protected $fillable = [
        'pesanan_id',
        'metode',
        'status',
        'bukti',
        'tgl_bayar',
        'midtrans_order_id',
        'midtrans_transaction_id',
    ];

    protected $casts = [
        'tgl_bayar' => 'datetime',
    ];

    /**
     * Pembayaran dimiliki oleh satu pesanan.
     */
    public function pesanan(): BelongsTo
    {
        return $this->belongsTo(Pesanan::class, 'pesanan_id');
    }
}
