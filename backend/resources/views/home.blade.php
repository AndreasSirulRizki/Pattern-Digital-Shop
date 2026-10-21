@extends('layouts.app')

@section('title', 'Beranda - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Hero ── */
    .hero-section {
        background: linear-gradient(180deg, #faf8f5 0%, #ffffff 100%);
        min-height: calc(100vh - 64px);
        display: flex; align-items: center;
    }
    .hero-badge {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        border-radius: 100px; padding: 6px 14px;
        font-size: 12px; color: #166534; font-weight: 500;
        font-family: 'Inter', sans-serif;
    }
    .hero-badge-dot {
        width: 6px; height: 6px; border-radius: 50%;
        background: #22c55e;
        box-shadow: 0 0 6px rgba(34,197,94,0.6);
        animation: pulse-dot 2s ease infinite;
    }
    @keyframes pulse-dot {
        0%,100% { opacity: 1; }
        50% { opacity: 0.4; }
    }
    .hero-image-wrap {
        position: relative;
        border-radius: 16px; overflow: hidden;
        border: 1px solid #e5e7eb;
        box-shadow: 0 20px 60px rgba(0,0,0,0.10), 0 0 0 1px rgba(0,0,0,0.03);
    }
    .hero-image-wrap::before {
        content: '';
        position: absolute; inset: 0;
        background: linear-gradient(135deg, rgba(255,255,255,0.06) 0%, transparent 60%);
        z-index: 1; pointer-events: none;
    }
    .hero-image-label {
        position: absolute; bottom: 0; left: 0; right: 0; z-index: 2;
        padding: 24px 20px 16px;
        background: linear-gradient(0deg, rgba(0,0,0,0.70) 0%, transparent 100%);
    }
    .stat-item {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 20px;
        flex: 1;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }

    /* ── Products ── */
    .section-label {
        display: inline-flex; align-items: center; gap: 8px;
        background: #f5f5f5; border: 1px solid #e5e7eb;
        border-radius: 100px; padding: 4px 12px;
        font-size: 11px; font-weight: 600; color: #6b7280;
        letter-spacing: 0.1em; text-transform: uppercase;
        font-family: 'Montserrat', sans-serif;
    }
    .filter-tab {
        padding: 7px 18px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        border: none;
    }
    .filter-tab.active {
        background: #1a1a1a; color: #ffffff;
    }
    .filter-tab:not(.active) {
        background: transparent; color: #6b7280;
        border: 1px solid #e5e7eb;
    }
    .filter-tab:not(.active):hover { color: #1a1a1a; border-color: #9ca3af; background: #f5f5f5; }

    /* Product Card */
    .product-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex; flex-direction: column;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .product-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 12px 32px rgba(0,0,0,0.10), 0 0 0 1px rgba(0,0,0,0.03);
        transform: translateY(-4px);
    }
    .product-img-wrap {
        background: #f5f5f5;
        position: relative; overflow: hidden;
        aspect-ratio: 4/3;
    }
    .product-img-wrap img {
        width: 100%; height: 100%; object-fit: cover;
        transition: transform 0.4s ease;
    }
    .product-card:hover .product-img-wrap img { transform: scale(1.04); }
    .badge-tipe {
        position: absolute; top: 10px; left: 10px;
        font-size: 10px; font-weight: 600;
        padding: 3px 9px; border-radius: 6px;
        font-family: 'Inter', sans-serif;
    }
    .badge-digital-tag { background: rgba(219,234,254,0.95); border: 1px solid #93c5fd; color: #1d4ed8; }
    .badge-fisik-tag   { background: rgba(220,252,231,0.95); border: 1px solid #86efac; color: #15803d; }

    .product-body { padding: 16px; flex: 1; display: flex; flex-direction: column; gap: 10px; }
    .product-rating { display: flex; align-items: center; gap: 5px; }
    .product-rating .stars { color: #f59e0b; font-size: 11px; }
    .product-rating .score { font-size: 12px; color: #9ca3af; font-family: 'Inter', sans-serif; }
    .product-name {
        font-family: 'Montserrat', sans-serif;
        font-size: 14px; font-weight: 600; color: #1a1a1a;
        line-height: 1.4; margin: 0;
    }
    .product-category { font-size: 12px; color: #9ca3af; font-family: 'Inter', sans-serif; }
    .product-footer { display: flex; align-items: center; justify-content: space-between; margin-top: auto; padding-top: 10px; border-top: 1px solid #f3f4f6; }
    .product-price {
        font-family: 'Montserrat', sans-serif;
        font-size: 15px; font-weight: 700; color: #1a1a1a;
    }
    .btn-beli {
        background: #1a1a1a;
        border: 1px solid #1a1a1a;
        color: #ffffff;
        font-size: 12px; font-weight: 600;
        padding: 7px 16px; border-radius: 7px;
        cursor: pointer; transition: all 0.2s ease;
        font-family: 'Inter', sans-serif;
        text-decoration: none;
        display: inline-flex; align-items: center; gap: 5px;
    }
    .btn-beli:hover {
        background: #000000;
        border-color: #000000;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }

    /* ── CTA Banner ── */
    .cta-banner {
        background: linear-gradient(135deg, #f5f5f5 0%, #ffffff 50%, #f5f5f5 100%);
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        position: relative; overflow: hidden;
        box-shadow: 0 4px 16px rgba(0,0,0,0.05);
    }
    .cta-banner::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0,0,0,0.06), transparent);
    }

    /* ── Why Section ── */
    .why-section {
        background: #faf8f5;
    }
    .why-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 32px 24px;
        transition: all 0.3s ease;
        position: relative; overflow: hidden;
        box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    }
    .why-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 2px;
        background: linear-gradient(90deg, transparent, #1a1a1a, transparent);
        transition: opacity 0.3s ease; opacity: 0;
    }
    .why-card:hover { border-color: #d1d5db; transform: translateY(-3px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
    .why-card:hover::before { opacity: 1; }
    .why-icon-wrap {
        width: 56px; height: 56px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        margin-bottom: 20px;
    }
    .why-check {
        display: flex; align-items: center; gap: 8px;
        font-size: 13px; color: #6b7280; font-family: 'Inter', sans-serif;
    }
    .why-check i { color: #22c55e; font-size: 10px; }
</style>
@endsection

@section('content')

{{-- ═══════════════════════════════════════════════
     HERO SECTION
═══════════════════════════════════════════════ --}}
<section class="hero-section px-4 sm:px-6 lg:px-8 py-12 lg:py-0" x-data>
    <div class="max-w-7xl mx-auto w-full">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16 items-center">

            {{-- Kiri: Teks --}}
            <div>
                {{-- Badge --}}
                <div class="hero-badge mb-6">
                    <span class="hero-badge-dot"></span>
                    Industri Garment #1 di Indonesia
                </div>

                {{-- Headline --}}
                <h1 class="font-montserrat font-bold text-[#1a1a1a] leading-tight mb-5"
                    style="font-size: clamp(2rem, 4vw, 3.25rem);">
                    Pola Jahit Presisi untuk
                    <span style="background: linear-gradient(135deg, #1a1a1a, #555555, #333333);
                                 -webkit-background-clip: text; -webkit-text-fill-color: transparent;
                                 background-clip: text;">
                        Kreativitas Tanpa Batas
                    </span>
                </h1>

                {{-- Subheadline --}}
                <p class="text-base leading-relaxed mb-8" style="color: #6b7280; max-width: 500px;">
                    Solusi andalan untuk penjahit, mahasiswa, dan pengrajin garment dalam menemukan
                    pola berkualitas tinggi untuk karya tak terbatas.
                </p>

                {{-- CTA Buttons --}}
                <div class="flex flex-wrap gap-3 mb-10">
                    <a href="{{ route('katalog') }}"
                       class="btn-primary px-6 py-3 text-sm font-semibold gap-2">
                        <i class="fas fa-th-large" style="font-size: 12px;"></i>
                        Lihat Katalog
                        <i class="fas fa-chevron-right" style="font-size: 10px;"></i>
                    </a>
                    <a href="{{ route('cara-pesan') }}"
                       class="btn-outline px-6 py-3 text-sm font-semibold gap-2">
                        <i class="fas fa-info-circle" style="font-size: 12px;"></i>
                        Cara Pesan
                    </a>
                </div>

                {{-- Stats --}}
                <div class="flex gap-3">
                    <div class="stat-item text-center">
                        <div class="font-montserrat font-bold text-[#1a1a1a] text-xl mb-0.5">15.000+</div>
                        <div class="text-xs" style="color: #6b7280;">Pola Terjual</div>
                    </div>
                    <div class="stat-item text-center">
                        <div class="font-montserrat font-bold text-[#1a1a1a] text-xl mb-0.5">99.8%</div>
                        <div class="text-xs" style="color: #6b7280;">Kepuasan</div>
                    </div>
                    <div class="stat-item text-center">
                        <div class="font-montserrat font-bold text-[#1a1a1a] text-xl mb-0.5">24/7</div>
                        <div class="text-xs" style="color: #6b7280;">Layanan</div>
                    </div>
                </div>
            </div>

            {{-- Kanan: Gambar Hero --}}
            <div class="hero-image-wrap">
                <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=800&q=80"
                     alt="Mesin jahit profesional"
                     class="w-full block"
                     onerror="this.src='https://placehold.co/800x560/f5f5f5/333333?text=Pattern+Digital+Shop'">
                <div class="hero-image-label">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="text-white font-semibold text-sm font-montserrat">Industri Garment Terpercaya</div>
                            <div class="text-xs mt-0.5" style="color: #d1d5db;">Ribuan pengrajin sudah bergabung</div>
                        </div>
                        <div class="flex -space-x-2">
                            @foreach(['bg-blue-500','bg-emerald-500','bg-violet-500','bg-amber-500'] as $color)
                            <div class="w-7 h-7 rounded-full border-2 border-white {{ $color }} flex items-center justify-center">
                                <i class="fas fa-user text-white" style="font-size: 9px;"></i>
                            </div>
                            @endforeach
                            <div class="w-7 h-7 rounded-full border-2 border-white flex items-center justify-center text-white font-bold"
                                 style="background: #1a1a1a; font-size: 8px;">+</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Divider --}}
<div style="background: linear-gradient(90deg, transparent, #e5e7eb, transparent); height: 1px;"></div>

{{-- ═══════════════════════════════════════════════
     PRODUK TERBARU
═══════════════════════════════════════════════ --}}
<section id="katalog" class="py-20 px-4 sm:px-6 lg:px-8" style="background: #ffffff;"
         x-data="{ activeFilter: 'semua' }">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="flex flex-col lg:flex-row lg:items-end justify-between gap-6 mb-10">
            <div>
                <div class="section-label mb-3">
                    <i class="fas fa-fire" style="color: #ef4444; font-size: 10px;"></i>
                    Pilihan Terbaik
                </div>
                <h2 class="font-montserrat font-bold text-[#1a1a1a] mb-2" style="font-size: 2rem;">
                    Produk Terbaru
                </h2>
                <p class="text-sm" style="color: #6b7280; max-width: 440px;">
                    Temukan pola jahit pilihan kami untuk kebutuhan kreasi Anda, tersedia dalam format fisik maupun digital.
                </p>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex items-center gap-2 flex-wrap shrink-0">
                <button @click="activeFilter = 'semua'"
                        :class="activeFilter === 'semua' ? 'active' : ''"
                        class="filter-tab">Semua</button>
                <button @click="activeFilter = 'fisik'"
                        :class="activeFilter === 'fisik' ? 'active' : ''"
                        class="filter-tab">Pola Fisik</button>
                <button @click="activeFilter = 'digital'"
                        :class="activeFilter === 'digital' ? 'active' : ''"
                        class="filter-tab">Pola Digital</button>
            </div>
        </div>

        {{-- Grid Produk --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
            @forelse($produk as $item)
            <div class="product-card"
                 x-show="activeFilter === 'semua' || activeFilter === '{{ $item->tipe }}'">

                {{-- Gambar --}}
                <div class="product-img-wrap">
                    <img src="{{ $item->gambar ? asset('storage/' . $item->gambar) : 'https://placehold.co/400x300/f5f5f5/9ca3af?text=' . urlencode($item->nama_produk) }}"
                         alt="{{ $item->nama_produk }}"
                         onerror="this.onerror=null;this.src='https://placehold.co/400x300/f5f5f5/9ca3af?text=Pola+Jahit'">
                    <span class="badge-tipe {{ $item->tipe === 'digital' ? 'badge-digital-tag' : 'badge-fisik-tag' }}">
                        <i class="fas {{ $item->tipe === 'digital' ? 'fa-file-pdf' : 'fa-box' }} mr-1" style="font-size: 9px;"></i>
                        {{ ucfirst($item->tipe) }}
                    </span>
                </div>

                {{-- Body --}}
                <div class="product-body">
                    <div class="product-rating">
                        <div class="stars">
                            <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                            <i class="fas fa-star"></i><i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="score">4.8 (24)</span>
                    </div>

                    <div>
                        <p class="product-name">{{ $item->nama_produk }}</p>
                        <p class="product-category mt-1">
                            <i class="fas fa-tag mr-1" style="font-size: 9px;"></i>
                            {{ $item->kategori->nama_kategori ?? 'Uncategorized' }}
                        </p>
                    </div>

                    @if($item->tipe === 'fisik')
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-box-open" style="color: #9ca3af; font-size: 10px;"></i>
                        <span style="color: #9ca3af; font-size: 12px; font-family: 'Inter', sans-serif;">
                            Stok: {{ $item->stok }} pcs
                        </span>
                    </div>
                    @else
                    <div class="flex items-center gap-1.5">
                        <i class="fas fa-download" style="color: #9ca3af; font-size: 10px;"></i>
                        <span style="color: #9ca3af; font-size: 12px; font-family: 'Inter', sans-serif;">
                            Download instan
                        </span>
                    </div>
                    @endif

                    <div class="product-footer">
                        <div class="product-price">
                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                        </div>
                        <a href="#" class="btn-beli">
                            <i class="fas fa-shopping-cart" style="font-size: 10px;"></i>
                            Beli
                        </a>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-span-4 py-20 text-center" style="color: #9ca3af;">
                <i class="fas fa-box-open text-4xl mb-4 block" style="color: #d1d5db;"></i>
                <p class="font-montserrat">Belum ada produk tersedia.</p>
            </div>
            @endforelse
        </div>

        {{-- CTA Banner --}}
        <div class="cta-banner mt-10 px-6 py-5 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shrink-0"
                     style="background: #f5f5f5; border: 1px solid #e5e7eb;">
                    <i class="fas fa-tags" style="color: #1a1a1a; font-size: 14px;"></i>
                </div>
                <div>
                    <p class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Butuh Pola Custom Sesuai Desain Sendiri?</p>
                    <p class="text-xs mt-0.5" style="color: #6b7280;">Layanan print-on-demand (POD) tersedia untuk pemesanan dalam jumlah besar.</p>
                </div>
            </div>
            <a href="#kontak" class="btn-primary px-5 py-2.5 text-sm font-semibold whitespace-nowrap shrink-0 gap-2">
                Konsultasi Gratis
                <i class="fas fa-arrow-right" style="font-size: 10px;"></i>
            </a>
        </div>
    </div>
</section>

{{-- Divider --}}
<div style="background: linear-gradient(90deg, transparent, #e5e7eb, transparent); height: 1px;"></div>

{{-- ═══════════════════════════════════════════════
     KENAPA PESAN DI SINI
═══════════════════════════════════════════════ --}}
<section id="cara-pesan" class="why-section py-20 px-4 sm:px-6 lg:px-8">
    <div class="max-w-7xl mx-auto">

        {{-- Header --}}
        <div class="text-center mb-14">
            <div class="section-label mb-4" style="display: inline-flex;">
                <i class="fas fa-shield-alt" style="color: #1a1a1a; font-size: 10px;"></i>
                Keunggulan Kami
            </div>
            <h2 class="font-montserrat font-bold text-[#1a1a1a] mb-4" style="font-size: clamp(1.6rem, 3vw, 2.5rem); max-width: 600px; margin-left: auto; margin-right: auto;">
                Standar Tertinggi untuk Hasil Jahitan Sempurna
            </h2>
            <p class="text-base leading-relaxed" style="color: #6b7280; max-width: 520px; margin: 0 auto;">
                Setiap pola dibuat dengan teliti dan presisi, menggunakan referensi material ukuran industri biar hasil jahitanmu selalu optimal.
            </p>
        </div>

        {{-- 3 Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">

            {{-- Card 1 --}}
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="fas fa-ruler-combined" style="color: #1a1a1a; font-size: 22px;"></i>
                </div>
                <h3 class="font-montserrat font-bold text-[#1a1a1a] text-lg mb-3">
                    Kualitas Pola Presisi
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: #6b7280;">
                    Dibuat oleh desainer garment berpengalaman dengan standar industri yang ketat. Setiap detail ukuran diverifikasi untuk hasil jahit yang akurat dan presisi.
                </p>
                <div class="space-y-2">
                    <div class="why-check"><i class="fas fa-check-circle"></i> Ukuran standar SNI</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Diverifikasi oleh ahli</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Tersedia 8+ ukuran</div>
                </div>
            </div>

            {{-- Card 2 --}}
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="fas fa-shipping-fast" style="color: #1a1a1a; font-size: 22px;"></i>
                </div>
                <h3 class="font-montserrat font-bold text-[#1a1a1a] text-lg mb-3">
                    Pengiriman Cepat
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: #6b7280;">
                    Pola fisik dikirim via kurir terpercaya. Pola digital tersedia langsung setelah pembayaran selesai — download instan ke perangkat kamu.
                </p>
                <div class="space-y-2">
                    <div class="why-check"><i class="fas fa-check-circle"></i> Pola digital instant</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Fisik same-day dispatch</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Tracking nomor resi</div>
                </div>
            </div>

            {{-- Card 3 --}}
            <div class="why-card">
                <div class="why-icon-wrap">
                    <i class="fas fa-shield-alt" style="color: #1a1a1a; font-size: 22px;"></i>
                </div>
                <h3 class="font-montserrat font-bold text-[#1a1a1a] text-lg mb-3">
                    Pembayaran Aman
                </h3>
                <p class="text-sm leading-relaxed mb-5" style="color: #6b7280;">
                    Transaksi dilindungi dengan enkripsi SSL dan diproses melalui payment gateway terpercaya. Uang kamu aman, kami jamin 100%.
                </p>
                <div class="space-y-2">
                    <div class="why-check"><i class="fas fa-check-circle"></i> SSL encrypted</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Transfer, QRIS, e-wallet</div>
                    <div class="why-check"><i class="fas fa-check-circle"></i> Jaminan uang kembali</div>
                </div>
            </div>
        </div>

        {{-- Bottom trust indicators --}}
        <div class="flex flex-wrap items-center justify-center gap-6 pt-6"
             style="border-top: 1px solid #e5e7eb;">
            @foreach([
                ['fas fa-star', '#f59e0b', '4.9/5 Rating', '1.200+ ulasan'],
                ['fas fa-users', '#3b82f6', '15.000+ Pelanggan', 'Aktif berbelanja'],
                ['fas fa-award', '#a855f7', '3+ Tahun', 'Melayani Indonesia'],
                ['fas fa-headset', '#22c55e', 'Support 24/7', 'Siap membantu'],
            ] as [$icon, $color, $title, $sub])
            <div class="flex items-center gap-3 px-4 py-3"
                 style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: 10px; min-width: 160px; box-shadow: 0 2px 6px rgba(0,0,0,0.04);">
                <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                     style="background: #f5f5f5; border: 1px solid #e5e7eb;">
                    <i class="{{ $icon }}" style="color: {{ $color }}; font-size: 14px;"></i>
                </div>
                <div>
                    <div class="font-montserrat font-semibold text-[#1a1a1a] text-sm">{{ $title }}</div>
                    <div class="text-xs" style="color: #6b7280;">{{ $sub }}</div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

@endsection
