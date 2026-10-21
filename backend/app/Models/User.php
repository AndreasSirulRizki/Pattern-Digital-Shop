<?php

namespace App\Models;

use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status',
        'no_hp',
        'alamat',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    /**
     * User memiliki banyak pesanan.
     * Alias 'pesanan' untuk withCount/withSum compatibility.
     */
    public function pesanan(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    /**
     * Relasi lama (tetap ada untuk backward compatibility).
     */
    public function pesanans(): HasMany
    {
        return $this->hasMany(Pesanan::class, 'user_id');
    }

    /**
     * User memiliki banyak item keranjang.
     */
    public function keranjang(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }

    public function keranjangs(): HasMany
    {
        return $this->hasMany(Keranjang::class, 'user_id');
    }

    /**
     * Helper: apakah user aktif.
     */
    public function isAktif(): bool
    {
        return $this->status === 'aktif';
    }
}
