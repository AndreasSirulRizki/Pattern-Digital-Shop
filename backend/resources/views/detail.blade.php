@extends('layouts.app')

@section('title', $produk->nama_produk . ' - Pattern Digital Shop')

@section('styles')
<style>
    /* ══════════════════════════════════
       DETAIL PRODUK — LOCAL STYLES
    ══════════════════════════════════ */

    /* ── Galeri ── */
    .galeri-main {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        aspect-ratio: 4/3;
        position: relative;
    }
    .galeri-main img {
        width: 100%; height: 100%;
        object-fit: contain;
        display: block;
        transition: opacity 0.25s ease;
    }
    .galeri-thumb {
        background: #ffffff;
        border: 2px solid #e5e7eb;
        border-radius: 8px;
        overflow: hidden;
        aspect-ratio: 1/1;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .galeri-thumb:hover,
    .galeri-thumb.active {
        border-color: #333333;
        box-shadow: 0 0 10px rgba(51,51,51,0.12);
    }
    .galeri-thumb img {
        width: 100%; height: 100%;
        object-fit: cover;
    }

    /* ── Badge tipe ── */
    .badge-tipe-fisik {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(51,51,51,0.08);
        border: 1px solid rgba(51,51,51,0.2);
        color: #333333;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.08em;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .badge-tipe-digital {
        display: inline-flex; align-items: center; gap: 5px;
        background: rgba(26,26,26,0.07);
        border: 1px solid rgba(26,26,26,0.18);
        color: #1a1a1a;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.08em;
        padding: 4px 12px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    /* ── Info card (kanan) ── */
    .info-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    /* ── Harga besar ── */
    .harga-besar {
        color: #1a1a1a;
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        letter-spacing: 0.01em;
        line-height: 1;
    }

    /* ── Ukuran selector ── */
    .ukuran-btn {
        min-width: 44px; height: 38px;
        padding: 0 12px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #f5f5f5;
        color: #6b7280;
        font-size: 13px; font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .ukuran-btn:hover {
        border-color: #6b7280;
        color: #1a1a1a;
    }
    .ukuran-btn.selected {
        border-color: #1a1a1a;
        background: #1a1a1a;
        color: #ffffff;
        box-shadow: 0 0 10px rgba(26,26,26,0.15);
    }

    /* ── Quantity input ── */
    .qty-btn {
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #f5f5f5;
        color: #6b7280;
        font-size: 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .qty-btn:hover {
        border-color: #1a1a1a;
        color: #1a1a1a;
    }
    .qty-input {
        width: 56px; height: 36px;
        text-align: center;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-size: 14px; font-weight: 600;
    }
    .qty-input:focus { outline: none; border-color: #1a1a1a; }

    /* ── Digital info box ── */
    .digital-box {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
    }

    /* ── Info tambahan row ── */
    .info-row {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .info-row:last-child { border-bottom: none; }
    .info-row-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    /* ── Tombol aksi ── */
    .btn-beli {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        padding: 14px 20px;
        border-radius: 10px;
        background: #1a1a1a;
        border: none;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 15px;
        letter-spacing: 0.03em;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative; overflow: hidden;
        text-decoration: none;
    }
    .btn-beli::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 50%;
        background: linear-gradient(180deg, rgba(255,255,255,0.1) 0%, transparent 100%);
        pointer-events: none;
    }
    .btn-beli:hover {
        background: #333333;
        box-shadow: 0 4px 16px rgba(26,26,26,0.25);
        transform: translateY(-1px);
    }

    .btn-keranjang {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        padding: 13px 20px;
        border-radius: 10px;
        background: #ffffff;
        border: 1px solid #1a1a1a;
        color: #1a1a1a;
        font-family: 'Montserrat', sans-serif;
        font-weight: 600;
        font-size: 14px;
        letter-spacing: 0.03em;
        cursor: pointer;
        transition: all 0.25s ease;
        text-decoration: none;
    }
    .btn-keranjang:hover {
        background: #f5f5f5;
        color: #333333;
        border-color: #333333;
        box-shadow: 0 2px 8px rgba(26,26,26,0.1);
    }

    /* ── Tab Deskripsi ── */
    .tab-nav {
        display: flex;
        border-bottom: 1px solid #e5e7eb;
        gap: 0;
    }
    .tab-btn {
        padding: 12px 20px;
        font-size: 13px; font-weight: 600;
        color: #6b7280;
        cursor: pointer;
        border: none; background: none;
        border-bottom: 2px solid transparent;
        margin-bottom: -1px;
        transition: all 0.2s ease;
        white-space: nowrap;
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.02em;
    }
    .tab-btn:hover { color: #1a1a1a; }
    .tab-btn.active {
        color: #1a1a1a;
        border-bottom-color: #1a1a1a;
    }
    .tab-panel { display: none; }
    .tab-panel.active { display: block; }

    /* ── Section Deskripsi ── */
    .desc-section {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }
    .desc-content {
        color: #6b7280;
        font-size: 14px;
        line-height: 1.8;
    }
    .desc-content p { margin-bottom: 12px; }
    .desc-content ul { list-style: disc; padding-left: 20px; margin-bottom: 12px; }
    .desc-content li { margin-bottom: 4px; }
    .desc-content strong { color: #1a1a1a; }

    /* ── Ulasan ── */
    .ulasan-card {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px;
    }
    .avatar-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        background: #e5e7eb;
        border: 1px solid #d1d5db;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700; color: #6b7280;
        flex-shrink: 0;
    }

    /* ── Produk terkait cards ── */
    .terkait-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex; flex-direction: column;
        text-decoration: none;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .terkait-card:hover {
        border-color: #333333;
        box-shadow: 0 8px 28px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
    .terkait-img {
        background: #f5f5f5;
        aspect-ratio: 4/3;
        overflow: hidden;
    }
    .terkait-img img {
        width: 100%; height: 100%;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .terkait-card:hover .terkait-img img { transform: scale(1.04); }

    /* ── Glossy divider ── */
    .glossy-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 20px 0;
    }

    /* ── Breadcrumb ── */
    .breadcrumb-link {
        color: #6b7280; text-decoration: none; font-size: 13px;
        transition: color 0.2s ease;
    }
    .breadcrumb-link:hover { color: #1a1a1a; }
</style>
@endsection

@section('content')
{{-- ════════════════════════════════════════
     HALAMAN DETAIL PRODUK
════════════════════════════════════════ --}}
<div class="min-h-screen py-10" style="background:#faf8f5;"
     x-data="detailApp()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── BREADCRUMB ── --}}
        <nav class="flex items-center gap-2 mb-7 flex-wrap">
            <a href="{{ route('home') }}" class="breadcrumb-link">
                <i class="fas fa-home mr-1" style="font-size:11px;"></i>Beranda
            </a>
            <i class="fas fa-chevron-right" style="color:#d1d5db; font-size:9px;"></i>
            <a href="{{ route('katalog') }}" class="breadcrumb-link">Katalog</a>
            <i class="fas fa-chevron-right" style="color:#d1d5db; font-size:9px;"></i>
            <span class="text-sm truncate max-w-xs" style="color:#333333;">{{ $produk->nama_produk }}</span>
        </nav>

        {{-- ════════════════════════════════
             LAYOUT 2 KOLOM UTAMA
        ════════════════════════════════ --}}
        <div class="flex flex-col lg:flex-row gap-8 mb-12">

            {{-- ══════════════════════════
                 KIRI — GALERI FOTO (60%)
            ══════════════════════════ --}}
            <div class="w-full lg:w-[58%]">

                {{-- Gambar utama --}}
                <div class="galeri-main mb-3">
                    <img :src="activeImg"
                         alt="{{ $produk->nama_produk }}"
                         id="mainImg">

                    {{-- Badge tipe di pojok gambar --}}
                    <div class="absolute top-3 left-3 z-10">
                        @if($produk->tipe === 'digital')
                            <span class="badge-tipe-digital">
                                <i class="fas fa-download" style="font-size:10px;"></i> Digital PDF
                            </span>
                        @else
                            <span class="badge-tipe-fisik">
                                <i class="fas fa-box" style="font-size:10px;"></i> Fisik / Cetak
                            </span>
                        @endif
                    </div>

                    {{-- Zoom hint --}}
                    <div class="absolute bottom-3 right-3 opacity-0 group-hover:opacity-100">
                        <span class="px-2.5 py-1 rounded text-xs"
                              style="background:rgba(255,255,255,0.85); color:#6b7280; border:1px solid #e5e7eb;">
                            <i class="fas fa-expand-alt mr-1" style="font-size:9px;"></i>Zoom
                        </span>
                    </div>
                </div>

                {{-- Thumbnails --}}
                <div class="grid grid-cols-4 gap-2">
                    @php
                        // Gambar utama + up to 3 placeholder thumbnails
                        $imgSrc = $produk->gambar
                            ? asset('storage/'.$produk->gambar)
                            : 'https://via.placeholder.com/400x400/f5f5f5/333333?text=' . urlencode(Str::limit($produk->nama_produk, 15));

                        $thumbs = [
                            $imgSrc,
                            'https://via.placeholder.com/200x200/f5f5f5/6b7280?text=Detail+1',
                            'https://via.placeholder.com/200x200/f5f5f5/6b7280?text=Detail+2',
                            'https://via.placeholder.com/200x200/f5f5f5/6b7280?text=Detail+3',
                        ];
                    @endphp

                    @foreach($thumbs as $i => $thumb)
                    <div class="galeri-thumb {{ $i === 0 ? 'active' : '' }}"
                         @click="setImg('{{ $thumb }}', $el)"
                         :class="activeImg === '{{ $thumb }}' ? 'active' : ''">
                        <img src="{{ $thumb }}" alt="Thumbnail {{ $i+1 }}" loading="lazy">
                    </div>
                    @endforeach
                </div>

                {{-- Garansi strip --}}
                <div class="mt-4 grid grid-cols-3 gap-2">
                    @foreach([
                        ['fas fa-shield-alt', 'Produk Asli', '100% Garansi'],
                        ['fas fa-undo',       'Revisi',       'Jika ada kesalahan cetak'],
                        ['fas fa-headset',    'Support',      'Chat WA 08.00–20.00'],
                    ] as [$icon, $title, $sub])
                    <div class="flex flex-col items-center text-center px-2 py-3 rounded-10"
                         style="background:#ffffff; border:1px solid #e5e7eb; border-radius:10px;">
                        <i class="{{ $icon }} mb-1.5" style="color:#333333; font-size:14px;"></i>
                        <span class="text-xs font-semibold text-[#1a1a1a]">{{ $title }}</span>
                        <span class="text-xs leading-tight mt-0.5" style="color:#6b7280;">{{ $sub }}</span>
                    </div>
                    @endforeach
                </div>

            </div>
            {{-- ══ END KIRI ══ --}}

            {{-- ══════════════════════════
                 KANAN — INFO PRODUK (40%)
            ══════════════════════════ --}}
            <div class="flex-1">
                <div class="info-card">

                    {{-- Badge --}}
                    <div class="mb-4">
                        @if($produk->tipe === 'digital')
                            <span class="badge-tipe-digital">
                                <i class="fas fa-file-pdf" style="font-size:10px;"></i> Digital PDF
                            </span>
                        @else
                            <span class="badge-tipe-fisik">
                                <i class="fas fa-print" style="font-size:10px;"></i> Fisik / Cetak
                            </span>
                        @endif
                    </div>

                    {{-- Nama Produk --}}
                    <h1 class="text-3xl font-bold text-[#1a1a1a] font-montserrat leading-tight mb-3">
                        {{ $produk->nama_produk }}
                    </h1>

                    {{-- Rating --}}
                    <div class="flex items-center gap-2 mb-4">
                        <div class="flex items-center gap-0.5">
                            @for($s = 1; $s <= 5; $s++)
                                <i class="fas fa-star" style="font-size:13px; color:#fbbf24;"></i>
                            @endfor
                        </div>
                        <span class="font-semibold text-sm" style="color:#1a1a1a;">4.8</span>
                        <span class="text-sm" style="color:#d1d5db;">/</span>
                        <span class="text-sm" style="color:#6b7280;">5.0 · 24 ulasan</span>
                        <span class="ml-2 text-xs px-2 py-0.5 rounded"
                              style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280;">
                            <i class="fas fa-check-circle mr-1" style="color:#6b7280;"></i>Terverifikasi
                        </span>
                    </div>

                    <div class="glossy-divider"></div>

                    {{-- Harga --}}
                    <div class="mb-5">
                        <p class="text-xs uppercase tracking-widest mb-1" style="color:#6b7280;">Harga</p>
                        <div class="harga-besar">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </div>
                        @if($produk->tipe === 'digital')
                            <p class="text-xs mt-1.5 flex items-center gap-1.5" style="color:#6b7280;">
                                <i class="fas fa-truck-fast" style="font-size:10px; color:#6b7280;"></i>
                                Tidak ada ongkir · File dikirim via email setelah pembayaran
                            </p>
                        @else
                            <p class="text-xs mt-1.5 flex items-center gap-1.5" style="color:#6b7280;">
                                <i class="fas fa-truck" style="font-size:10px; color:#6b7280;"></i>
                                Harga belum termasuk ongkos kirim
                            </p>
                        @endif
                    </div>

                    {{-- Deskripsi singkat --}}
                    @if($produk->deskripsi)
                    <p class="text-sm leading-relaxed mb-5" style="color:#6b7280;">
                        {{ Str::limit(strip_tags($produk->deskripsi), 160) }}
                    </p>
                    @endif

                    <div class="glossy-divider"></div>

                    {{-- ── FISIK: Ukuran + Qty ── --}}
                    @if($produk->tipe === 'fisik')
                    <div class="mb-5">
                        {{-- Pilihan Ukuran --}}
                        <div class="mb-4">
                            <p class="text-xs uppercase tracking-widest mb-2.5" style="color:#6b7280;">
                                Ukuran
                                <span class="ml-2 normal-case text-xs lowercase tracking-normal" style="color:#6b7280;">
                                    — pilih satu
                                </span>
                            </p>
                            <div class="flex gap-2 flex-wrap">
                                @foreach(['S','M','L','XL','XXL'] as $uk)
                                <button type="button"
                                        class="ukuran-btn"
                                        :class="ukuran === '{{ $uk }}' ? 'selected' : ''"
                                        @click="ukuran = '{{ $uk }}'">
                                    {{ $uk }}
                                </button>
                                @endforeach
                            </div>
                            <p class="text-xs mt-2" style="color:#6b7280;">
                                <i class="fas fa-ruler-combined mr-1" style="font-size:10px;"></i>
                                <a href="#tab-ukuran" @click.prevent="openTab('ukuran')"
                                   class="underline underline-offset-2 cursor-pointer hover:text-[#1a1a1a] transition-colors">
                                    Lihat panduan ukuran
                                </a>
                            </p>
                        </div>

                        {{-- Qty + Stok --}}
                        <div>
                            <p class="text-xs uppercase tracking-widest mb-2.5" style="color:#6b7280;">Jumlah</p>
                            <div class="flex items-center gap-3">
                                <div class="flex items-center gap-1.5">
                                    <button type="button" class="qty-btn" @click="qty = Math.max(1, qty - 1)">
                                        <i class="fas fa-minus" style="font-size:11px;"></i>
                                    </button>
                                    <input type="number" class="qty-input" x-model="qty"
                                           min="1" max="{{ $produk->stok }}"
                                           @input="qty = Math.min({{ $produk->stok }}, Math.max(1, parseInt($event.target.value)||1))">
                                    <button type="button" class="qty-btn"
                                            @click="qty = Math.min({{ $produk->stok }}, qty + 1)">
                                        <i class="fas fa-plus" style="font-size:11px;"></i>
                                    </button>
                                </div>
                                <div>
                                    @if($produk->stok > 0)
                                        <span class="flex items-center gap-1.5 text-sm" style="color:#6b7280;">
                                            <i class="fas fa-check-circle" style="color:#6b7280; font-size:12px;"></i>
                                            Stok tersedia:
                                            <span class="font-semibold" style="color:#1a1a1a;">
                                                {{ $produk->stok }} pcs
                                            </span>
                                        </span>
                                    @else
                                        <span class="flex items-center gap-1.5 text-sm" style="color:#1a1a1a;">
                                            <i class="fas fa-times-circle" style="font-size:12px;"></i>
                                            Stok habis
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- ── DIGITAL: Info box ── --}}
                    @else
                    <div class="digital-box mb-5">
                        <div class="flex gap-3">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center shrink-0"
                                 style="background:#ffffff; border:1px solid #e5e7eb;">
                                <i class="fas fa-file-pdf" style="color:#333333; font-size:16px;"></i>
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-[#1a1a1a] mb-1">File PDF Digital</p>
                                <p class="text-xs leading-relaxed" style="color:#6b7280;">
                                    Langsung didownload setelah pembayaran dikonfirmasi.
                                    File dikirim ke email kamu secara otomatis.
                                </p>
                            </div>
                        </div>
                        <div class="mt-3 pt-3" style="border-top:1px solid #e5e7eb;">
                            <div class="grid grid-cols-2 gap-2">
                                @foreach([
                                    ['fas fa-truck-slash', 'Tidak ada ongkir'],
                                    ['fas fa-infinity',    'Download ulang kapan saja'],
                                    ['fas fa-file-alt',    'Format PDF resolusi tinggi'],
                                    ['fas fa-print',       'Bisa dicetak sendiri'],
                                ] as [$ic, $lb])
                                <div class="flex items-center gap-1.5 text-xs" style="color:#6b7280;">
                                    <i class="{{ $ic }}" style="color:#6b7280; font-size:10px;"></i>
                                    {{ $lb }}
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endif

                    {{-- ── TOMBOL AKSI ── --}}
                    <div class="space-y-3 mb-6">
                        {{-- Beli Sekarang --}}
                        @if($produk->tipe === 'fisik' && $produk->stok <= 0)
                        <button disabled
                                class="btn-beli opacity-40 cursor-not-allowed"
                                style="background: #9ca3af;">
                            <i class="fas fa-times-circle"></i>
                            Stok Habis
                        </button>
                        @else
                        <a href="#"
                           class="btn-beli"
                           @click.prevent="beliSekarang()">
                            <i class="fas fa-bolt" style="font-size:14px;"></i>
                            Beli Sekarang
                        </a>
                        @endif

                        {{-- Tambah ke Keranjang --}}
                        @auth
                        @if($produk->tipe === 'fisik' && $produk->stok <= 0)
                        <button type="button" disabled
                                class="btn-keranjang opacity-50 cursor-not-allowed">
                            <i class="fas fa-shopping-cart" style="font-size:13px;"></i>
                            Stok Habis
                        </button>
                        @else
                        <form action="{{ route('keranjang.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="produk_id" value="{{ $produk->id }}">
                            <input type="hidden" name="jumlah" :value="qty" x-bind:value="qty">
                            <button type="submit" class="btn-keranjang w-full">
                                <i class="fas fa-shopping-cart" style="font-size:13px;"></i>
                                Tambah ke Keranjang
                            </button>
                        </form>
                        @endif
                        @else
                        <a href="{{ route('login') }}" class="btn-keranjang">
                            <i class="fas fa-shopping-cart" style="font-size:13px;"></i>
                            Login untuk Beli
                        </a>
                        @endauth
                    </div>

                    {{-- ── INFO TAMBAHAN ── --}}
                    <div style="background:#f5f5f5; border:1px solid #e5e7eb; border-radius:10px; padding:4px 12px;">

                        <div class="info-row">
                            <div class="info-row-icon">
                                <i class="fas fa-tag" style="color:#6b7280; font-size:11px;"></i>
                            </div>
                            <div>
                                <span class="text-xs" style="color:#6b7280;">Kategori</span>
                                <p class="text-sm font-medium" style="color:#1a1a1a;">
                                    {{ $produk->kategori->nama_kategori ?? '—' }}
                                </p>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-row-icon">
                                <i class="fas fa-circle-check" style="color:#6b7280; font-size:11px;"></i>
                            </div>
                            <div>
                                <span class="text-xs" style="color:#6b7280;">Status</span>
                                <p class="text-sm font-medium" style="color:#1a1a1a;">
                                    @if($produk->status === 'aktif')
                                        <span style="color:#16a34a;">
                                            <i class="fas fa-circle" style="font-size:8px; margin-right:4px;"></i>Aktif & Tersedia
                                        </span>
                                    @else
                                        <span style="color:#6b7280;">Tidak Tersedia</span>
                                    @endif
                                </p>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-row-icon">
                                <i class="fab fa-whatsapp" style="color:#22c55e; font-size:12px;"></i>
                            </div>
                            <div>
                                <span class="text-xs" style="color:#6b7280;">Free Konsultasi</span>
                                <p class="text-sm font-medium">
                                    <a href="https://wa.me/6282100000000?text={{ urlencode('Halo, saya mau tanya tentang produk: '.$produk->nama_produk) }}"
                                       target="_blank"
                                       class="transition-colors hover:text-[#1a1a1a]"
                                       style="color:#333333;">
                                        Chat via WhatsApp
                                        <i class="fas fa-external-link-alt ml-1" style="font-size:10px;"></i>
                                    </a>
                                </p>
                            </div>
                        </div>

                        <div class="info-row">
                            <div class="info-row-icon">
                                <i class="fas fa-share-alt" style="color:#6b7280; font-size:11px;"></i>
                            </div>
                            <div class="flex-1">
                                <span class="text-xs block mb-1.5" style="color:#6b7280;">Bagikan Produk</span>
                                <div class="flex gap-2">
                                    @foreach([
                                        ['fab fa-whatsapp',   '#22c55e', 'https://wa.me/?text='.urlencode($produk->nama_produk.' - '.url()->current())],
                                        ['fab fa-facebook-f', '#3b82f6', 'https://facebook.com/sharer/sharer.php?u='.url()->current()],
                                        ['fab fa-twitter',    '#1d9bf0', 'https://twitter.com/intent/tweet?text='.urlencode($produk->nama_produk).'&url='.url()->current()],
                                    ] as [$ic, $clr, $href])
                                    <a href="{{ $href }}" target="_blank"
                                       class="w-7 h-7 rounded-lg flex items-center justify-center text-xs transition-all hover:scale-110"
                                       style="background:#ffffff; border:1px solid #e5e7eb; color:{{ $clr }};">
                                        <i class="{{ $ic }}"></i>
                                    </a>
                                    @endforeach
                                    <button type="button"
                                            onclick="navigator.clipboard.writeText('{{ url()->current() }}').then(()=>alert('Link disalin!'))"
                                            class="w-7 h-7 rounded-lg flex items-center justify-center text-xs transition-all hover:scale-110"
                                            style="background:#ffffff; border:1px solid #e5e7eb; color:#6b7280;">
                                        <i class="fas fa-link"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                    </div>
                    {{-- ── END INFO TAMBAHAN ── --}}

                </div>
            </div>
            {{-- ══ END KANAN ══ --}}

        </div>
        {{-- ════ END LAYOUT 2 KOLOM ════ --}}


        {{-- ════════════════════════════════════
             SECTION DESKRIPSI LENGKAP (TAB)
        ════════════════════════════════════ --}}
        <div class="desc-section mb-12" id="tab-section">

            {{-- Tab Navigation --}}
            <div class="tab-nav px-6 overflow-x-auto">
                @foreach([
                    ['deskripsi', 'Deskripsi',      'fas fa-align-left'],
                    ['ukuran',    'Bahan & Ukuran',  'fas fa-ruler-combined'],
                    ['cara',      'Cara Pakai',      'fas fa-book-open'],
                    ['ulasan',    'Ulasan (24)',      'fas fa-star'],
                ] as [$id, $label, $icon])
                <button type="button"
                        class="tab-btn"
                        :class="activeTab === '{{ $id }}' ? 'active' : ''"
                        @click="activeTab = '{{ $id }}'">
                    <i class="{{ $icon }} mr-1.5" style="font-size:11px;"></i>{{ $label }}
                </button>
                @endforeach
            </div>

            {{-- Tab Content --}}
            <div class="p-6 lg:p-8">

                {{-- TAB: Deskripsi --}}
                <div class="tab-panel" :class="activeTab === 'deskripsi' ? 'active' : ''">
                    <div class="desc-content">
                        @if($produk->deskripsi)
                            {!! nl2br(e($produk->deskripsi)) !!}
                        @else
                            <p>Deskripsi produk belum tersedia.</p>
                        @endif
                    </div>
                </div>

                {{-- TAB: Bahan & Ukuran --}}
                <div class="tab-panel" :class="activeTab === 'ukuran' ? 'active' : ''">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                        {{-- Tabel Ukuran --}}
                        <div>
                            <h3 class="font-semibold text-[#1a1a1a] font-montserrat mb-4 text-sm uppercase tracking-wide">
                                <i class="fas fa-ruler-horizontal mr-2" style="color:#333333;"></i>
                                Tabel Ukuran (cm)
                            </h3>
                            <div class="overflow-hidden rounded-10" style="border:1px solid #e5e7eb; border-radius:10px;">
                                <table class="w-full text-sm">
                                    <thead>
                                        <tr style="background:#f5f5f5; border-bottom:1px solid #e5e7eb;">
                                            @foreach(['Ukuran','Lingkar Dada','Lingkar Pinggang','Panjang'] as $h)
                                            <th class="px-4 py-3 text-left font-semibold text-xs uppercase tracking-wide" style="color:#6b7280;">{{ $h }}</th>
                                            @endforeach
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach([
                                            ['S',  '88–92',  '72–76',  '65'],
                                            ['M',  '92–96',  '76–80',  '67'],
                                            ['L',  '96–100', '80–84',  '69'],
                                            ['XL', '100–105','84–88',  '71'],
                                            ['XXL','105–110','88–93',  '73'],
                                        ] as $row)
                                        <tr style="border-bottom:1px solid #f0f0f0;">
                                            @foreach($row as $i => $cell)
                                            <td class="px-4 py-3 text-sm"
                                                style="color: {{ $i === 0 ? '#1a1a1a' : '#6b7280' }}; font-weight: {{ $i === 0 ? '700' : '400' }};">
                                                {{ $cell }}
                                            </td>
                                            @endforeach
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- Info Bahan --}}
                        <div>
                            <h3 class="font-semibold text-[#1a1a1a] font-montserrat mb-4 text-sm uppercase tracking-wide">
                                <i class="fas fa-tshirt mr-2" style="color:#333333;"></i>
                                Informasi Bahan
                            </h3>
                            <div class="space-y-3">
                                @foreach([
                                    ['Bahan Utama',    'Katun Combed 30s'],
                                    ['Ketebalan',      'Medium (tidak menerawang)'],
                                    ['Perawatan',      'Cuci dengan air dingin'],
                                    ['Format Pola',    $produk->tipe === 'digital' ? 'PDF A4 (bisa diprint)' : 'Kertas asturo 100 x 80 cm'],
                                    ['Isi Pola',       'Depan, Belakang, Lengan, Kerah'],
                                ] as [$label, $val])
                                <div class="flex items-start gap-3 py-2.5" style="border-bottom:1px solid #f0f0f0;">
                                    <span class="text-sm w-32 shrink-0" style="color:#6b7280;">{{ $label }}</span>
                                    <span class="text-sm" style="color:#1a1a1a;">{{ $val }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- TAB: Cara Pakai --}}
                <div class="tab-panel" :class="activeTab === 'cara' ? 'active' : ''">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @php
                            $langkah = $produk->tipe === 'digital'
                                ? [
                                    ['fas fa-credit-card',  'Lakukan Pembayaran',       'Pilih metode pembayaran dan selesaikan transaksi.'],
                                    ['fas fa-envelope',     'Cek Email',                 'File PDF akan dikirim otomatis ke email kamu dalam 5 menit.'],
                                    ['fas fa-download',     'Download File PDF',          'Buka link download di email, simpan file ke perangkat.'],
                                    ['fas fa-print',        'Print & Potong',            'Cetak di kertas A4 sesuai skala. Gunting mengikuti garis pola.'],
                                    ['fas fa-cut',          'Gunting Kain',              'Tempelkan pola ke kain, tandai dan gunting dengan presisi.'],
                                    ['fas fa-sewing-needle','Jahit & Selesai',           'Ikuti petunjuk jahit yang tersedia di halaman terakhir PDF.'],
                                ]
                                : [
                                    ['fas fa-shopping-cart', 'Pesan & Bayar',            'Pilih ukuran, klik Beli Sekarang, dan selesaikan pembayaran.'],
                                    ['fas fa-box',           'Pola Dikirim',              'Pola dicetak di kertas asturo dan dikemas dengan aman.'],
                                    ['fas fa-truck',         'Terima Paket',              'Paket tiba 2–5 hari kerja tergantung lokasi.'],
                                    ['fas fa-cut',           'Gunting Kain',              'Tempelkan pola ke kain, tandai dan gunting dengan presisi.'],
                                    ['fas fa-sewing-needle', 'Jahit & Selesai',           'Ikuti petunjuk jahit yang tertera di dalam pola.'],
                                    ['fas fa-star',          'Beri Ulasan',               'Bagikan pengalamanmu agar membantu pembeli lain.'],
                                ];
                        @endphp

                        @foreach($langkah as $i => [$icon, $judul, $desc])
                        <div class="flex gap-4">
                            <div class="flex flex-col items-center">
                                <div class="w-9 h-9 rounded-full flex items-center justify-center shrink-0 font-bold text-sm font-montserrat"
                                     style="background: #1a1a1a; border: 1px solid #333333; color: #ffffff;">
                                    {{ $i + 1 }}
                                </div>
                                @if($i < count($langkah) - 1)
                                <div class="w-px flex-1 mt-2" style="background:#e5e7eb; min-height:20px;"></div>
                                @endif
                            </div>
                            <div class="pb-4">
                                <h4 class="font-semibold text-[#1a1a1a] text-sm mb-1 flex items-center gap-2">
                                    <i class="{{ $icon }}" style="color:#6b7280; font-size:11px;"></i>
                                    {{ $judul }}
                                </h4>
                                <p class="text-sm" style="color:#6b7280;">{{ $desc }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- TAB: Ulasan --}}
                <div class="tab-panel" :class="activeTab === 'ulasan' ? 'active' : ''">

                    {{-- Summary rating --}}
                    <div class="flex flex-col sm:flex-row gap-6 mb-8 pb-8" style="border-bottom:1px solid #e5e7eb;">
                        <div class="flex flex-col items-center justify-center shrink-0"
                             style="background:#f5f5f5; border:1px solid #e5e7eb; border-radius:12px; padding:24px 32px;">
                            <div class="font-montserrat font-black text-5xl" style="color:#1a1a1a; line-height:1;">4.8</div>
                            <div class="flex gap-0.5 my-2">
                                @for($s=1;$s<=5;$s++)
                                    <i class="fas fa-star" style="font-size:14px; color:#fbbf24;"></i>
                                @endfor
                            </div>
                            <span class="text-xs" style="color:#6b7280;">dari 24 ulasan</span>
                        </div>
                        <div class="flex-1 space-y-2">
                            @foreach([5=>85, 4=>10, 3=>3, 2=>1, 1=>1] as $star => $pct)
                            <div class="flex items-center gap-3">
                                <span class="text-xs w-3 text-right shrink-0" style="color:#6b7280;">{{ $star }}</span>
                                <i class="fas fa-star shrink-0" style="color:#fbbf24; font-size:10px;"></i>
                                <div class="flex-1 h-1.5 rounded-full overflow-hidden" style="background:#e5e7eb;">
                                    <div class="h-full rounded-full" style="width:{{ $pct }}%; background: #1a1a1a;"></div>
                                </div>
                                <span class="text-xs w-7 shrink-0" style="color:#6b7280;">{{ $pct }}%</span>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Daftar ulasan (dummy) --}}
                    <div class="space-y-4">
                        @foreach([
                            ['Siti R.',    5, '2 hari lalu',   'Pola sangat detail dan mudah dipahami! Hasil jahitannya rapi banget. Recommended!'],
                            ['Dewi A.',    5, '1 minggu lalu', 'File PDF-nya lengkap banget, ada petunjuk jahit juga. Langsung bisa dicoba.'],
                            ['Budi S.',    4, '2 minggu lalu', 'Pola bagus, tapi butuh sedikit penyesuaian di bagian kerah. Overall puas.'],
                        ] as [$nama, $rating, $waktu, $isi])
                        <div class="ulasan-card">
                            <div class="flex items-start gap-3 mb-2">
                                <div class="avatar-circle">{{ substr($nama, 0, 1) }}</div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center justify-between gap-2 flex-wrap">
                                        <span class="font-semibold text-sm text-[#1a1a1a]">{{ $nama }}</span>
                                        <span class="text-xs" style="color:#6b7280;">{{ $waktu }}</span>
                                    </div>
                                    <div class="flex gap-0.5 mt-0.5">
                                        @for($s=1;$s<=5;$s++)
                                        <i class="fas fa-star" style="font-size:10px; color:{{ $s<=$rating ? '#fbbf24' : '#d1d5db' }};"></i>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                            <p class="text-sm" style="color:#6b7280;">{{ $isi }}</p>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-6 text-center">
                        <button type="button"
                                class="btn-outline px-6 py-2.5 text-sm gap-2"
                                style="display:inline-flex; align-items:center;">
                            <i class="fas fa-chevron-down" style="font-size:10px;"></i>
                            Muat Lebih Banyak Ulasan
                        </button>
                    </div>

                </div>

            </div>
        </div>
        {{-- ════ END SECTION DESKRIPSI ════ --}}


        {{-- ════════════════════════════════════
             SECTION PRODUK TERKAIT
        ════════════════════════════════════ --}}
        @if($produk_terkait->count() > 0)
        <div class="mb-8">

            {{-- Judul section --}}
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-bold text-[#1a1a1a] font-montserrat tracking-tight">
                        Produk Serupa
                    </h2>
                    <p class="text-sm mt-0.5" style="color:#6b7280;">
                        Dari kategori {{ $produk->kategori->nama_kategori ?? 'sama' }}
                    </p>
                </div>
                <a href="{{ route('katalog', ['kategori' => [$produk->kategori_id]]) }}"
                   class="btn-outline px-4 py-2 text-xs gap-1.5"
                   style="display:inline-flex; align-items:center;">
                    Lihat Semua
                    <i class="fas fa-arrow-right" style="font-size:10px;"></i>
                </a>
            </div>

            {{-- Grid 4 kolom --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($produk_terkait as $item)
                <a href="{{ route('produk.detail', $item->slug) }}" class="terkait-card group">

                    {{-- Gambar --}}
                    <div class="terkait-img relative">
                        <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/300x225/f5f5f5/6b7280?text='.urlencode(Str::limit($item->nama_produk, 10)) }}"
                             alt="{{ $item->nama_produk }}"
                             loading="lazy"
                             onerror="this.onerror=null;this.src='https://via.placeholder.com/300x225/f5f5f5/6b7280?text=Pola+Jahit'">

                        {{-- Badge --}}
                        <div class="absolute top-2 left-2">
                            @if($item->tipe === 'digital')
                                <span class="badge-tipe-digital" style="font-size:9px; padding:2px 7px;">Digital</span>
                            @else
                                <span class="badge-tipe-fisik"   style="font-size:9px; padding:2px 7px;">Fisik</span>
                            @endif
                        </div>
                    </div>

                    {{-- Info --}}
                    <div class="p-3 flex flex-col flex-1">
                        <div class="flex items-center gap-0.5 mb-1.5">
                            @for($s=1;$s<=5;$s++)
                                <i class="fas fa-star" style="font-size:9px; color:{{ $s<=4 ? '#fbbf24' : '#d1d5db' }};"></i>
                            @endfor
                            <span class="ml-1 text-xs" style="color:#6b7280;">4.8</span>
                        </div>
                        <h4 class="font-semibold text-[#1a1a1a] text-xs leading-snug mb-1 font-montserrat line-clamp-2">
                            {{ $item->nama_produk }}
                        </h4>
                        <div class="mt-auto pt-2" style="border-top:1px solid #e5e7eb; margin-top:8px;">
                            <span class="font-bold text-sm font-montserrat" style="color:#1a1a1a;">
                                Rp {{ number_format($item->harga, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                </a>
                @endforeach
            </div>
        </div>
        @endif
        {{-- ════ END PRODUK TERKAIT ════ --}}

    </div>
</div>
@endsection

@section('scripts')
<script>
function detailApp() {
    return {
        // Gambar aktif galeri
        activeImg: '{{ $produk->gambar ? asset("storage/".$produk->gambar) : "https://via.placeholder.com/400x400/f5f5f5/333333?text=".urlencode(Str::limit($produk->nama_produk, 15)) }}',

        // Pilihan ukuran (fisik)
        ukuran: 'M',

        // Qty
        qty: 1,

        // Tab aktif
        activeTab: 'deskripsi',

        setImg(src, el) {
            this.activeImg = src;
            // Update active class pada thumbs
            document.querySelectorAll('.galeri-thumb').forEach(t => t.classList.remove('active'));
            el.classList.add('active');
        },

        openTab(tab) {
            this.activeTab = tab;
            // Scroll ke section tab
            const el = document.getElementById('tab-section');
            if (el) el.scrollIntoView({ behavior: 'smooth', block: 'start' });
        },

        beliSekarang() {
            // Langsung ke keranjang (nanti diganti ke checkout)
            window.location.href = '{{ route("keranjang") }}';
        },

        tambahKeranjang() {
            // Redirect ke halaman keranjang
            window.location.href = '{{ route("keranjang") }}';
        },
    }
}
</script>
@endsection
