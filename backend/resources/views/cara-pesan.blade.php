@extends('layouts.app')

@section('title', 'Cara Pesan - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Hero ── */
    .hero-cara-pesan {
        background-color: #faf8f5;
        background-image:
            linear-gradient(rgba(26,26,26,0.04) 1px, transparent 1px),
            linear-gradient(90deg, rgba(26,26,26,0.04) 1px, transparent 1px);
        background-size: 32px 32px;
        position: relative;
        overflow: hidden;
    }
    .hero-cara-pesan::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse 70% 60% at 50% 0%, rgba(255,255,255,0.85) 0%, transparent 100%);
        pointer-events: none;
    }

    /* ── Step card ── */
    .step-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 28px 24px;
        position: relative;
        transition: all 0.3s ease;
    }
    .step-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 8px 28px rgba(0,0,0,0.07), 0 0 0 1px rgba(0,0,0,0.03);
        transform: translateY(-3px);
    }

    .step-number {
        width: 36px; height: 36px;
        border-radius: 10px;
        background: #1a1a1a;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 14px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }

    .step-icon {
        width: 52px; height: 52px;
        border-radius: 14px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 16px;
        transition: all 0.3s ease;
    }
    .step-card:hover .step-icon {
        background: #1a1a1a;
        border-color: #1a1a1a;
    }
    .step-card:hover .step-icon i {
        color: #ffffff !important;
    }

    /* Connector line between steps */
    .steps-connector {
        position: absolute;
        top: 26px; left: calc(100% + 1px);
        width: calc(100% - 2px);
        height: 1px;
        background: linear-gradient(90deg, #e5e7eb, #d1d5db, #e5e7eb);
        display: none;
    }
    @media (min-width: 768px) {
        .steps-connector { display: block; }
    }

    /* ── Perbandingan cards ── */
    .compare-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 32px;
        transition: all 0.3s ease;
    }
    .compare-card:hover {
        border-color: #1a1a1a;
        box-shadow: 0 12px 36px rgba(0,0,0,0.08);
    }
    .compare-card.featured {
        background: #1a1a1a;
        border-color: #1a1a1a;
    }
    .compare-icon {
        width: 56px; height: 56px;
        border-radius: 16px;
        display: flex; align-items: center; justify-content: center;
        margin-bottom: 20px;
    }
    .compare-list-item {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 8px 0;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
    }
    .compare-list-item:last-child { border-bottom: none; }
    .compare-card.featured .compare-list-item { border-bottom-color: rgba(255,255,255,0.08); }

    /* ── FAQ ── */
    .faq-item {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: border-color 0.2s ease;
    }
    .faq-item.open { border-color: #1a1a1a; }

    .faq-trigger {
        width: 100%;
        display: flex; align-items: center; justify-content: space-between;
        padding: 16px 20px;
        background: transparent;
        border: none;
        cursor: pointer;
        font-family: 'Inter', sans-serif;
        font-weight: 600;
        font-size: 14px;
        color: #1a1a1a;
        text-align: left;
        transition: background 0.2s ease;
    }
    .faq-trigger:hover { background: #faf8f5; }
    .faq-item.open .faq-trigger { background: #faf8f5; }

    .faq-icon {
        width: 24px; height: 24px;
        border-radius: 6px;
        background: #f3f4f6;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }
    .faq-item.open .faq-icon {
        background: #1a1a1a;
        border-color: #1a1a1a;
    }
    .faq-item.open .faq-icon i { color: #ffffff !important; transform: rotate(45deg); }
    .faq-icon i { transition: transform 0.2s ease, color 0.2s ease; }

    .faq-body {
        max-height: 0;
        overflow: hidden;
        transition: max-height 0.3s ease, padding 0.3s ease;
        padding: 0 20px;
    }
    .faq-item.open .faq-body {
        max-height: 200px;
        padding: 0 20px 16px;
    }

    /* ── CTA ── */
    .cta-section {
        background: #1a1a1a;
        border-radius: 20px;
        position: relative;
        overflow: hidden;
    }
    .cta-section::before {
        content: '';
        position: absolute; inset: 0;
        background: radial-gradient(ellipse 60% 80% at 30% 50%, rgba(255,255,255,0.04) 0%, transparent 70%);
        pointer-events: none;
    }
    .cta-section::after {
        content: '';
        position: absolute; top: -60px; right: -60px;
        width: 200px; height: 200px;
        border-radius: 50%;
        background: rgba(255,255,255,0.03);
        pointer-events: none;
    }

    /* ── Section label ── */
    .section-label {
        display: inline-flex; align-items: center; gap: 6px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 100px;
        padding: 5px 12px;
        font-size: 11px;
        font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.06em;
        text-transform: uppercase;
    }

    /* ── Payment badge ── */
    .payment-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 12px;
        font-weight: 500;
    }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════════ --}}
{{-- HERO                                       --}}
{{-- ══════════════════════════════════════════ --}}
<section class="hero-cara-pesan py-16 md:py-24">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">

        <div class="flex justify-center mb-5">
            <span class="section-label">
                <i class="fas fa-book-open" style="font-size:9px; color:#9ca3af;"></i>
                Panduan Pembelian
            </span>
        </div>

        <h1 class="text-4xl md:text-5xl font-bold text-[#1a1a1a] mb-4 leading-tight"
            style="font-family:'Montserrat',sans-serif; letter-spacing:-0.02em;">
            Cara Pesan<br class="hidden md:block">
            <span style="color:#4b5563;">Pola Jahit</span>
        </h1>

        <p class="text-base md:text-lg max-w-xl mx-auto leading-relaxed" style="color:#6b7280;">
            Panduan lengkap untuk memesan pola jahit <strong style="color:#1a1a1a;">fisik</strong>
            &amp; <strong style="color:#1a1a1a;">digital</strong> di Pattern Digital Shop —
            mudah, cepat, dan aman.
        </p>

        {{-- Quick links --}}
        <div class="flex flex-wrap items-center justify-center gap-3 mt-8">
            <a href="#langkah" class="btn-primary px-5 py-2.5 text-sm gap-2">
                <i class="fas fa-arrow-down" style="font-size:10px;"></i> Lihat Langkah
            </a>
            <a href="{{ route('katalog') }}" class="btn-outline px-5 py-2.5 text-sm gap-2">
                <i class="fas fa-th-large" style="font-size:10px;"></i> Buka Katalog
            </a>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════ --}}
{{-- STEP-BY-STEP                               --}}
{{-- ══════════════════════════════════════════ --}}
<section id="langkah" class="py-16" style="background:#faf8f5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="text-center mb-12">
            <div class="flex justify-center mb-4">
                <span class="section-label">
                    <i class="fas fa-list-ol" style="font-size:9px; color:#9ca3af;"></i>
                    5 Langkah Mudah
                </span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-[#1a1a1a]"
                style="font-family:'Montserrat',sans-serif;">
                Begini Cara Pesannya
            </h2>
            <p class="text-sm mt-2" style="color:#9ca3af;">Ikuti langkah berikut dan pesanan kamu segera diproses</p>
        </div>

        {{-- Steps grid --}}
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            {{-- Step 1 --}}
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-search" style="font-size:20px; color:#6b7280;"></i>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="step-number">1</div>
                    <h3 class="font-bold text-[#1a1a1a] text-sm" style="font-family:'Montserrat',sans-serif;">
                        Pilih Pola Jahit
                    </h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:#6b7280;">
                    Jelajahi katalog kami dan temukan pola jahit yang Anda butuhkan. Gunakan filter kategori untuk mempermudah pencarian.
                </p>
            </div>

            {{-- Step 2 --}}
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-shopping-cart" style="font-size:20px; color:#6b7280;"></i>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="step-number">2</div>
                    <h3 class="font-bold text-[#1a1a1a] text-sm" style="font-family:'Montserrat',sans-serif;">
                        Tambah ke Keranjang
                    </h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:#6b7280;">
                    Klik tombol "Tambah ke Keranjang" pada produk yang ingin dibeli. Anda bisa memilih beberapa pola sekaligus.
                </p>
            </div>

            {{-- Step 3 --}}
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-map-marker-alt" style="font-size:20px; color:#6b7280;"></i>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="step-number">3</div>
                    <h3 class="font-bold text-[#1a1a1a] text-sm" style="font-family:'Montserrat',sans-serif;">
                        Isi Data Pengiriman
                    </h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:#6b7280;">
                    Lengkapi data pengiriman untuk pola fisik. Untuk pola digital, langsung lanjut ke langkah pembayaran.
                </p>
            </div>

            {{-- Step 4 --}}
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-credit-card" style="font-size:20px; color:#6b7280;"></i>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="step-number">4</div>
                    <h3 class="font-bold text-[#1a1a1a] text-sm" style="font-family:'Montserrat',sans-serif;">
                        Pilih Pembayaran
                    </h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:#6b7280;">
                    Pilih metode pembayaran: QRIS, Transfer Bank, atau COD (khusus pola fisik). Pembayaran aman & terenkripsi.
                </p>
            </div>

            {{-- Step 5 --}}
            <div class="step-card">
                <div class="step-icon">
                    <i class="fas fa-check-circle" style="font-size:20px; color:#6b7280;"></i>
                </div>
                <div class="flex items-center gap-2 mb-3">
                    <div class="step-number">5</div>
                    <h3 class="font-bold text-[#1a1a1a] text-sm" style="font-family:'Montserrat',sans-serif;">
                        Terima Pesanan
                    </h3>
                </div>
                <p class="text-sm leading-relaxed" style="color:#6b7280;">
                    Pola fisik dikirim ke alamat Anda. Pola digital bisa langsung diunduh setelah pembayaran dikonfirmasi.
                </p>
            </div>

        </div>

        {{-- Progress bar visual --}}
        <div class="hidden md:flex items-center justify-center mt-6 gap-2">
            @foreach([1,2,3,4,5] as $n)
            <div style="width:32px; height:4px; border-radius:2px; background:{{ $n <= 5 ? '#1a1a1a' : '#e5e7eb' }};"></div>
            @if($n < 5)
            <div style="width:64px; height:1px; background:#e5e7eb;"></div>
            @endif
            @endforeach
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════ --}}
{{-- PERBEDAAN FISIK vs DIGITAL                 --}}
{{-- ══════════════════════════════════════════ --}}
<section class="py-16" style="background:#ffffff;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section header --}}
        <div class="text-center mb-12">
            <div class="flex justify-center mb-4">
                <span class="section-label">
                    <i class="fas fa-exchange-alt" style="font-size:9px; color:#9ca3af;"></i>
                    Jenis Produk
                </span>
            </div>
            <h2 class="text-2xl md:text-3xl font-bold text-[#1a1a1a]"
                style="font-family:'Montserrat',sans-serif;">
                Pola Fisik vs Pola Digital
            </h2>
            <p class="text-sm mt-2" style="color:#9ca3af;">Pilih sesuai kebutuhan kamu</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-3xl mx-auto">

            {{-- Pola Fisik --}}
            <div class="compare-card">
                <div class="compare-icon" style="background:#f5f5f5; border:1px solid #e5e7eb;">
                    <i class="fas fa-box" style="font-size:22px; color:#1a1a1a;"></i>
                </div>
                <h3 class="font-bold text-[#1a1a1a] text-lg mb-1" style="font-family:'Montserrat',sans-serif;">
                    Pola Fisik
                </h3>
                <p class="text-xs mb-5" style="color:#9ca3af;">Dikirim langsung ke alamat Anda</p>

                <div>
                    <div class="compare-list-item">
                        <i class="fas fa-truck mt-0.5 shrink-0" style="color:#1a1a1a; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-[#1a1a1a]">Dikirim ke alamat Anda</div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">Via JNE, J&T, SiCepat, dll.</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-money-bill-wave mt-0.5 shrink-0" style="color:#f59e0b; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-[#1a1a1a]">Ada biaya ongkir</div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">Sesuai kurir & lokasi</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-clock mt-0.5 shrink-0" style="color:#6b7280; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-[#1a1a1a]">Estimasi 2–5 hari kerja</div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">Tergantung lokasi & kurir</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-wallet mt-0.5 shrink-0" style="color:#1a1a1a; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-[#1a1a1a]">Metode Pembayaran</div>
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                <span class="payment-badge" style="background:#f0fdf4; border:1px solid #bbf7d0; color:#16a34a;">
                                    <i class="fas fa-qrcode" style="font-size:9px;"></i> QRIS
                                </span>
                                <span class="payment-badge" style="background:#eff6ff; border:1px solid #bfdbfe; color:#2563eb;">
                                    <i class="fas fa-university" style="font-size:9px;"></i> Transfer
                                </span>
                                <span class="payment-badge" style="background:#fef3c7; border:1px solid #fde68a; color:#d97706;">
                                    <i class="fas fa-hand-holding-usd" style="font-size:9px;"></i> COD
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Pola Digital --}}
            <div class="compare-card featured">
                <div class="compare-icon" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15);">
                    <i class="fas fa-file-pdf" style="font-size:22px; color:#ffffff;"></i>
                </div>
                <h3 class="font-bold text-white text-lg mb-1" style="font-family:'Montserrat',sans-serif;">
                    Pola Digital
                </h3>
                <p class="text-xs mb-5" style="color:rgba(255,255,255,0.5);">File PDF siap download setelah bayar</p>

                <div>
                    <div class="compare-list-item">
                        <i class="fas fa-download mt-0.5 shrink-0" style="color:#ffffff; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-white">Langsung download</div>
                            <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">Setelah pembayaran dikonfirmasi</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-check mt-0.5 shrink-0" style="color:#4ade80; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-white">Tanpa ongkir</div>
                            <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">Harga lebih hemat</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-bolt mt-0.5 shrink-0" style="color:#facc15; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-white">Instan — tidak perlu tunggu</div>
                            <div class="text-xs mt-0.5" style="color:rgba(255,255,255,0.5);">Akses 24/7 dari mana saja</div>
                        </div>
                    </div>
                    <div class="compare-list-item">
                        <i class="fas fa-wallet mt-0.5 shrink-0" style="color:#ffffff; font-size:13px; width:16px;"></i>
                        <div>
                            <div class="font-medium text-white">Metode Pembayaran</div>
                            <div class="flex flex-wrap gap-1.5 mt-2">
                                <span class="payment-badge" style="background:rgba(74,222,128,0.15); border:1px solid rgba(74,222,128,0.3); color:#4ade80;">
                                    <i class="fas fa-qrcode" style="font-size:9px;"></i> QRIS
                                </span>
                                <span class="payment-badge" style="background:rgba(96,165,250,0.15); border:1px solid rgba(96,165,250,0.3); color:#60a5fa;">
                                    <i class="fas fa-university" style="font-size:9px;"></i> Transfer
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════ --}}
{{-- FAQ                                        --}}
{{-- ══════════════════════════════════════════ --}}
<section class="py-16" style="background:#faf8f5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-start">

            {{-- Left: header --}}
            <div class="lg:sticky" style="top: 88px;">
                <div class="flex mb-5">
                    <span class="section-label">
                        <i class="fas fa-question-circle" style="font-size:9px; color:#9ca3af;"></i>
                        FAQ
                    </span>
                </div>
                <h2 class="text-2xl md:text-3xl font-bold text-[#1a1a1a] mb-4"
                    style="font-family:'Montserrat',sans-serif; line-height:1.25;">
                    Pertanyaan yang Sering Ditanyakan
                </h2>
                <p class="text-sm leading-relaxed mb-6" style="color:#6b7280;">
                    Masih ada pertanyaan? Hubungi tim support kami lewat WhatsApp atau halaman Kontak.
                </p>
                <a href="{{ route('kontak') }}" class="btn-outline px-5 py-2.5 text-sm gap-2">
                    <i class="fas fa-headset" style="font-size:11px;"></i> Hubungi Support
                </a>
            </div>

            {{-- Right: FAQ list --}}
            <div class="space-y-3">

                <div class="faq-item" onclick="toggleFaq(this)">
                    <button class="faq-trigger">
                        <span>Berapa lama pengiriman pola fisik?</span>
                        <div class="faq-icon">
                            <i class="fas fa-plus" style="font-size:11px; color:#6b7280;"></i>
                        </div>
                    </button>
                    <div class="faq-body">
                        <p style="font-size:14px; color:#6b7280; line-height:1.65;">
                            Estimasi pengiriman pola fisik adalah <strong style="color:#1a1a1a;">2–5 hari kerja</strong> tergantung kurir dan lokasi pengiriman. Untuk wilayah Jawa, biasanya 1–3 hari. Luar Jawa 3–5 hari kerja.
                        </p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <button class="faq-trigger">
                        <span>Apakah pola digital bisa di-refund?</span>
                        <div class="faq-icon">
                            <i class="fas fa-plus" style="font-size:11px; color:#6b7280;"></i>
                        </div>
                    </button>
                    <div class="faq-body">
                        <p style="font-size:14px; color:#6b7280; line-height:1.65;">
                            Maaf, pola digital <strong style="color:#1a1a1a;">tidak bisa di-refund</strong> setelah download berhasil, karena produk digital langsung bisa diakses dan digunakan. Harap pastikan pilihan pola sudah sesuai sebelum melakukan pembelian.
                        </p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <button class="faq-trigger">
                        <span>Metode pembayaran apa saja yang tersedia?</span>
                        <div class="faq-icon">
                            <i class="fas fa-plus" style="font-size:11px; color:#6b7280;"></i>
                        </div>
                    </button>
                    <div class="faq-body">
                        <p style="font-size:14px; color:#6b7280; line-height:1.65;">
                            Kami menerima pembayaran via <strong style="color:#1a1a1a;">QRIS</strong> dan <strong style="color:#1a1a1a;">Transfer Bank</strong> untuk semua jenis produk. Untuk pola fisik, tersedia juga opsi <strong style="color:#1a1a1a;">COD (Cash on Delivery)</strong> di wilayah tertentu.
                        </p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <button class="faq-trigger">
                        <span>Apakah bisa pesan dalam jumlah banyak (grosir)?</span>
                        <div class="faq-icon">
                            <i class="fas fa-plus" style="font-size:11px; color:#6b7280;"></i>
                        </div>
                    </button>
                    <div class="faq-body">
                        <p style="font-size:14px; color:#6b7280; line-height:1.65;">
                            Bisa! Untuk pesanan grosir atau dalam jumlah besar, silakan hubungi kami langsung via <strong style="color:#1a1a1a;">WhatsApp Business</strong>. Kami menyediakan harga khusus dan layanan konsultasi untuk pesanan grosir.
                        </p>
                    </div>
                </div>

                <div class="faq-item" onclick="toggleFaq(this)">
                    <button class="faq-trigger">
                        <span>Apakah perlu daftar akun untuk memesan?</span>
                        <div class="faq-icon">
                            <i class="fas fa-plus" style="font-size:11px; color:#6b7280;"></i>
                        </div>
                    </button>
                    <div class="faq-body">
                        <p style="font-size:14px; color:#6b7280; line-height:1.65;">
                            Ya, kamu perlu <strong style="color:#1a1a1a;">membuat akun</strong> terlebih dahulu untuk melakukan pemesanan. Pendaftaran gratis dan mudah — cukup isi nama, email, dan password. Dengan akun, kamu bisa memantau status pesanan dan mengunduh ulang pola digital kapan saja.
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════ --}}
{{-- CTA                                        --}}
{{-- ══════════════════════════════════════════ --}}
<section class="py-16" style="background:#ffffff;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="cta-section px-8 py-14 md:py-16 text-center">

            {{-- Badge --}}
            <div class="flex justify-center mb-6">
                <span style="display:inline-flex; align-items:center; gap:6px; background:rgba(255,255,255,0.08); border:1px solid rgba(255,255,255,0.15); border-radius:100px; padding:5px 14px; font-size:11px; font-weight:700; color:rgba(255,255,255,0.7); letter-spacing:0.06em; text-transform:uppercase;">
                    <i class="fas fa-sparkles" style="font-size:9px;"></i>
                    Mulai Belanja
                </span>
            </div>

            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4"
                style="font-family:'Montserrat',sans-serif; letter-spacing:-0.02em;">
                Siap Memesan?
            </h2>
            <p class="text-base max-w-md mx-auto mb-8" style="color:rgba(255,255,255,0.6); line-height:1.65;">
                Jelajahi katalog kami dan temukan pola jahit favorit Anda. Ratusan pilihan pola siap dikirim ke seluruh Indonesia.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center gap-3 relative z-10">
                <a href="{{ route('katalog') }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; background:#ffffff; border:1px solid #ffffff; border-radius:10px; font-family:'Inter',sans-serif; font-weight:600; font-size:14px; color:#1a1a1a; text-decoration:none; transition:all 0.25s ease;"
                   onmouseover="this.style.background='#f5f5f5'; this.style.boxShadow='0 4px 16px rgba(255,255,255,0.2)';"
                   onmouseout="this.style.background='#ffffff'; this.style.boxShadow='none';">
                    <i class="fas fa-th-large" style="font-size:12px;"></i>
                    Lihat Katalog
                </a>
                <a href="{{ route('kontak') }}"
                   style="display:inline-flex; align-items:center; gap:8px; padding:12px 28px; background:transparent; border:1px solid rgba(255,255,255,0.3); border-radius:10px; font-family:'Inter',sans-serif; font-weight:500; font-size:14px; color:rgba(255,255,255,0.8); text-decoration:none; transition:all 0.25s ease;"
                   onmouseover="this.style.borderColor='rgba(255,255,255,0.6)'; this.style.color='#ffffff'; this.style.background='rgba(255,255,255,0.05)';"
                   onmouseout="this.style.borderColor='rgba(255,255,255,0.3)'; this.style.color='rgba(255,255,255,0.8)'; this.style.background='transparent';">
                    <i class="fas fa-headset" style="font-size:12px;"></i>
                    Hubungi Kami
                </a>
            </div>

            {{-- Stats --}}
            <div class="flex flex-col sm:flex-row items-center justify-center gap-8 mt-12 pt-8"
                 style="border-top:1px solid rgba(255,255,255,0.08);">
                <div class="text-center">
                    <div class="text-2xl font-bold text-white" style="font-family:'Montserrat',sans-serif;">200+</div>
                    <div class="text-xs mt-1" style="color:rgba(255,255,255,0.4);">Pilihan Pola</div>
                </div>
                <div class="hidden sm:block" style="width:1px; height:32px; background:rgba(255,255,255,0.1);"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white" style="font-family:'Montserrat',sans-serif;">5.000+</div>
                    <div class="text-xs mt-1" style="color:rgba(255,255,255,0.4);">Pelanggan Puas</div>
                </div>
                <div class="hidden sm:block" style="width:1px; height:32px; background:rgba(255,255,255,0.1);"></div>
                <div class="text-center">
                    <div class="text-2xl font-bold text-white" style="font-family:'Montserrat',sans-serif;">4.9 ★</div>
                    <div class="text-xs mt-1" style="color:rgba(255,255,255,0.4);">Rating Rata-rata</div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection

@section('scripts')
<script>
    // ── FAQ Toggle ─────────────────────────────
    function toggleFaq(item) {
        var isOpen = item.classList.contains('open');
        // Tutup semua yang lain
        document.querySelectorAll('.faq-item.open').forEach(function (el) {
            el.classList.remove('open');
        });
        // Buka yang diklik kalau sebelumnya tertutup
        if (!isOpen) {
            item.classList.add('open');
        }
    }

    // ── Smooth scroll untuk anchor ─────────────
    document.querySelectorAll('a[href^="#"]').forEach(function (anchor) {
        anchor.addEventListener('click', function (e) {
            var target = document.querySelector(this.getAttribute('href'));
            if (target) {
                e.preventDefault();
                var offset = 80; // tinggi navbar
                var top = target.getBoundingClientRect().top + window.pageYOffset - offset;
                window.scrollTo({ top: top, behavior: 'smooth' });
            }
        });
    });
</script>
@endsection
