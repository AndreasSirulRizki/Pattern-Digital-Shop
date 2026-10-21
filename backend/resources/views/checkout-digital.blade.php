@extends('layouts.app')

@section('title', 'Checkout - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Checkout Digital Styles ── */

    .co-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .co-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 15px 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    .co-card-body { padding: 20px; }

    .card-num {
        width: 24px; height: 24px; border-radius: 50%;
        background: #1a1a1a;
        border: 1px solid #1a1a1a;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 700; color: #ffffff;
        margin-right: 10px; flex-shrink: 0;
    }

    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 36px;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
    }
    .step-circle {
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700;
        border: 2px solid #e5e7eb;
        background: #f5f5f5; color: #9ca3af;
        transition: all 0.2s ease;
    }
    .step-circle.done {
        background: #e5e7eb;
        border-color: #e5e7eb; color: #6b7280;
    }
    .step-circle.active {
        background: #1a1a1a;
        border-color: #1a1a1a; color: #ffffff;
        box-shadow: 0 0 16px rgba(26,26,26,0.2);
    }
    .step-label { font-size: 11px; font-weight: 500; white-space: nowrap; }
    .step-label.done    { color: #6b7280; }
    .step-label.active  { color: #1a1a1a; font-weight: 600; }
    .step-label.pending { color: #9ca3af; }
    .step-line {
        flex: 1; height: 2px;
        background: #e5e7eb;
        min-width: 50px; max-width: 120px;
        margin-bottom: 22px;
    }
    .step-line.done { background: #6b7280; }

    /* Digital product item */
    .digital-item {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .digital-item:last-child { border-bottom: none; }

    .digital-thumb {
        width: 56px; height: 56px;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        overflow: hidden;
    }

    .badge-pdf {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 9px; font-weight: 700;
        padding: 2px 7px; border-radius: 4px;
        background: rgba(51,51,51,0.07);
        border: 1px solid rgba(51,51,51,0.15);
        color: #333333;
        letter-spacing: 0.05em; text-transform: uppercase;
    }

    .badge-instant {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 9px; font-weight: 700;
        padding: 2px 7px; border-radius: 4px;
        background: rgba(22,163,74,0.08);
        border: 1px solid rgba(22,163,74,0.2);
        color: #16a34a;
        letter-spacing: 0.05em; text-transform: uppercase;
    }
    .badge-encrypted {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 9px; font-weight: 700;
        padding: 2px 7px; border-radius: 4px;
        background: rgba(99,102,241,0.08);
        border: 1px solid rgba(99,102,241,0.2);
        color: #6366f1;
        letter-spacing: 0.05em;
    }

    /* Payment option */
    .payment-opt {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f5f5f5;
        margin-bottom: 10px;
    }
    .payment-opt:last-child { margin-bottom: 0; }
    .payment-opt:hover { border-color: #6b7280; }
    .payment-opt.selected {
        border-color: #1a1a1a;
        background: #ffffff;
        box-shadow: 0 0 0 1px #1a1a1a;
    }
    .payment-opt input[type="radio"] { display: none; }

    /* Total card */
    .total-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 24px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }

    .total-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 9px 0;
        font-size: 13px;
        border-bottom: 1px solid #f0f0f0;
    }
    .total-row:last-child { border-bottom: none; }

    .btn-bayar-lg {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        padding: 15px 24px;
        background: #1a1a1a;
        border: none;
        border-radius: 10px;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 15px;
        cursor: pointer;
        transition: all 0.25s ease;
        position: relative; overflow: hidden;
        text-decoration: none;
    }
    .btn-bayar-lg::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 50%;
        background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 100%);
        pointer-events: none;
    }
    .btn-bayar-lg:hover {
        background: #333333;
        box-shadow: 0 4px 20px rgba(26,26,26,0.2);
        transform: translateY(-1px);
    }

    /* QRIS preview */
    .qris-box {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
    }
    .qris-img-wrap {
        background: #ffffff;
        border-radius: 10px;
        padding: 14px;
        display: inline-block;
        border: 1px solid #e5e7eb;
    }

    /* Info download note */
    .download-note {
        background: rgba(22,163,74,0.05);
        border: 1px solid rgba(22,163,74,0.15);
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        align-items: flex-start;
        gap: 10px;
    }

    /* Breadcrumb */
    .breadcrumb-sep { color: #d1d5db; margin: 0 6px; font-size: 9px; }
</style>
</div>{{-- end min-h --}}
</form>
@endsection

@section('content')
{{-- Data dinamis dari CheckoutController --}}
@php
    $ongkir = $ongkir ?? 0;
    $total  = $total  ?? $subtotal;
@endphp

<form action="{{ route('checkout.store') }}" method="POST" id="checkout-digital-form">
@csrf
<input type="hidden" name="tipe_pesanan" value="digital">
<input type="hidden" name="metode_pembayaran" x-bind:value="payment">
<div class="min-h-screen" style="background:#faf8f5;"
     x-data="{ payment: 'qris' }">
    <div class="max-w-2xl mx-auto px-4 sm:px-6 py-10">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center text-xs mb-5" style="color:#6b7280;">
            <a href="{{ route('home') }}"      style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
            <span class="breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <a href="{{ route('keranjang') }}" style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Keranjang</a>
            <span class="breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <span style="color:#1a1a1a;">Checkout</span>
        </div>

        {{-- ── Stepper ── --}}
        <div class="stepper">
            <div class="step-item">
                <div class="step-circle done"><i class="fas fa-check" style="font-size:12px;"></i></div>
                <span class="step-label done">Keranjang</span>
            </div>
            <div class="step-line done"></div>
            <div class="step-item">
                <div class="step-circle active">2</div>
                <span class="step-label active">Pembayaran Digital</span>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label pending">Selesai / Download</span>
            </div>
        </div>

        {{-- ── Judul ── --}}
        <div class="mb-6 text-center">
            <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-3"
                 style="background:rgba(51,51,51,0.07); border:1px solid rgba(51,51,51,0.15); color:#333333; letter-spacing:0.08em; text-transform:uppercase;">
                <i class="fas fa-file-pdf mr-1.5" style="font-size:9px;"></i> Produk Digital
            </div>
            <h1 class="font-montserrat font-bold text-[#1a1a1a] text-3xl tracking-tight">
                Pembayaran Produk Digital
            </h1>
            <p class="text-sm mt-2" style="color:#6b7280;">
                File PDF &amp; CAD otomatis dikirim setelah bayar dan akan siap dalam hitungan detik
            </p>
            <div class="flex items-center justify-center gap-4 mt-3">
                <span class="badge-encrypted"><i class="fas fa-lock" style="font-size:9px;"></i> SSL 256-bit Encrypted</span>
                <span class="text-xs" style="color:#6b7280;">+62 821-XXXX-XXXX</span>
            </div>
        </div>

        {{-- ── Card: Akun Penerima ── --}}
        <div class="co-card">
            <div class="co-card-header">
                <div class="flex items-center">
                    <span class="card-num"><i class="fas fa-user" style="font-size:9px;"></i></span>
                    <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Akun Penerima File Digital</span>
                </div>
                <span class="text-xs px-2 py-1 rounded-md"
                      style="background:rgba(22,163,74,0.08); color:#16a34a; border:1px solid rgba(22,163,74,0.2); font-size:10px;">
                    OK terverifikasi
                </span>
            </div>
            <div class="co-card-body">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <div class="text-xs mb-1" style="color:#6b7280;">Nama Pembeli Akun</div>
                        <div class="text-sm font-semibold text-[#1a1a1a]">{{ Auth::user()->name }}</div>
                    </div>
                    <div>
                        <div class="text-xs mb-1" style="color:#6b7280;">Email Penerima File Download</div>
                        <div class="text-sm font-semibold" style="color:#333333;">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <p class="text-xs mt-3 leading-relaxed" style="color:#6b7280;">
                    File PDF akan otomatis dikirimkan ke email akun kamu setelah pembayaran terverifikasi. Kamu juga bisa download langsung melalui halaman akun kamu kapan saja.
                </p>
            </div>
        </div>

        {{-- ── Card: Item Digital ── --}}
        <div class="co-card">
            <div class="co-card-header">
                <div class="flex items-center">
                    <span class="card-num">1</span>
                    <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Item Pola Digital Siap Unduh ({{ $keranjang->count() }} File Master)</span>
                </div>
                <a href="{{ route('keranjang') }}" class="text-xs hover:text-[#1a1a1a] transition-colors" style="color:#6b7280;">
                    Edit item keranjang
                </a>
            </div>
            <div class="co-card-body">
                @foreach($keranjang as $item)
                <div class="digital-item">
                    <div class="digital-thumb">
                        @if($item->produk->gambar)
                            <img src="{{ asset('storage/' . $item->produk->gambar) }}"
                                 class="w-full h-full object-cover"
                                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex'">
                        @endif
                        <i class="fas fa-file-pdf" style="color:#333333; font-size:22px; {{ $item->produk->gambar ? 'display:none;' : '' }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start justify-between gap-3">
                            <div>
                                <p class="font-montserrat font-semibold text-[#1a1a1a] text-sm leading-snug">
                                    {{ $item->produk->nama_produk }} (PDF)
                                </p>
                                <p class="text-xs mt-1 leading-relaxed" style="color:#6b7280;">
                                    {{ $item->produk->kategori->nama_kategori ?? 'Digital' }} &middot; Format PDF
                                </p>
                                <div class="flex items-center gap-2 mt-2">
                                    <span class="badge-pdf"><i class="fas fa-file-pdf" style="font-size:8px;"></i> PDF</span>
                                    <span class="badge-instant"><i class="fas fa-bolt" style="font-size:8px;"></i> Instant</span>
                                </div>
                            </div>
                            <div class="shrink-0 text-right">
                                <div class="font-montserrat font-bold" style="color:#1a1a1a; font-size:15px;">
                                    Rp {{ number_format($item->produk->harga, 0, ',', '.') }}
                                </div>
                                <div class="text-xs mt-1" style="color:#6b7280;">Qty: {{ $item->jumlah }}</div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

                <div class="download-note mt-2">
                    <i class="fas fa-download mt-0.5 shrink-0" style="color:#16a34a; font-size:12px;"></i>
                    <p class="text-xs leading-relaxed" style="color:#16a34a;">
                        File PDF akan langsung tersedia setelah pembayaran dikonfirmasi &amp; bisa didownload ulang kapan saja dari halaman akun.
                    </p>
                </div>
            </div>
        </div>

        {{-- ── Card: Metode Pembayaran ── --}}
        <div class="co-card">
            <div class="co-card-header">
                <div class="flex items-center">
                    <span class="card-num">2</span>
                    <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Pilih Metode Pembayaran Instan</span>
                </div>
                <span class="text-xs" style="color:#6b7280;">Semua metode 100% aman</span>
            </div>
            <div class="co-card-body">

                <label class="payment-opt" :class="payment === 'qris' ? 'selected' : ''" @click="payment='qris'">
                    <input type="radio" name="metode_pembayaran" value="qris">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                 style="background:#ffffff; border:1px solid #e5e7eb;">
                                <i class="fas fa-qrcode" style="color:#1a1a1a; font-size:16px;"></i>
                            </div>
                            <div>
                                <div class="flex items-center gap-2">
                                    <span class="font-semibold text-[#1a1a1a] text-sm">QRIS Real-Time (Semua Bank &amp; E-Wallet)</span>
                                    <span class="badge-instant"><i class="fas fa-bolt" style="font-size:8px;"></i> RECOMMENDED</span>
                                </div>
                                <p class="text-xs mt-0.5" style="color:#6b7280;">BCA, Mandiri, BRI, BNI, GoPay, OVO, Dana, ShopeePay</p>
                            </div>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 shrink-0 ml-3 transition-all"
                             :style="payment === 'qris' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                    </div>
                </label>

                <label class="payment-opt" :class="payment === 'va' ? 'selected' : ''" @click="payment='va'">
                    <input type="radio" name="metode_pembayaran" value="transfer">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                 style="background:#ffffff; border:1px solid #e5e7eb;">
                                <i class="fas fa-university" style="color:#6b7280; font-size:14px;"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-[#1a1a1a] text-sm">Virtual Account Otomatis</span>
                                <p class="text-xs mt-0.5" style="color:#6b7280;">BCA VA, Mandiri, BRI, BNI, CIMB</p>
                            </div>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 shrink-0 ml-3 transition-all"
                             :style="payment === 'va' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                    </div>
                </label>

                {{-- Info Rekening Transfer (muncul saat pilih VA) --}}
                <div x-show="payment === 'va'"
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="background:#f5f5f5; border:1px solid #e5e7eb; border-radius:10px; padding:16px; margin-top:4px;">
                    <div class="flex items-center gap-2 mb-3">
                        <i class="fas fa-university" style="color:#1a1a1a; font-size:12px;"></i>
                        <span style="font-size:11px; font-weight:700; color:#1a1a1a; letter-spacing:0.05em; text-transform:uppercase;">Rekening Tujuan Transfer</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e5e7eb;">
                        <span style="font-size:13px; color:#6b7280;">Bank</span>
                        <span style="font-size:13px; font-weight:600; color:#1a1a1a;">SeaBank</span>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0; border-bottom:1px solid #e5e7eb;">
                        <span style="font-size:13px; color:#6b7280;">No. Rekening</span>
                        <div style="display:flex; align-items:center; gap:8px;">
                            <span style="font-family:monospace; font-size:14px; font-weight:700; color:#1a1a1a;" id="norek-digital">901339829925</span>
                            <button type="button" onclick="copyNorekDigital()"
                                    title="Copy no. rekening"
                                    style="width:28px; height:28px; border-radius:6px; background:#ffffff; border:1px solid #e5e7eb; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.15s;"
                                    onmouseover="this.style.borderColor='#9ca3af'; this.style.background='#f3f4f6';"
                                    onmouseout="this.style.borderColor='#e5e7eb'; this.style.background='#ffffff';">
                                <i class="fas fa-copy" id="copy-icon-digital" style="color:#6b7280; font-size:11px;"></i>
                            </button>
                        </div>
                    </div>
                    <div style="display:flex; justify-content:space-between; align-items:center; padding:8px 0;">
                        <span style="font-size:13px; color:#6b7280;">Atas Nama</span>
                        <span style="font-size:13px; font-weight:600; color:#1a1a1a;">Saepudin</span>
                    </div>
                    <div style="margin-top:10px; padding:10px 12px; background:rgba(234,179,8,0.07); border:1px solid rgba(234,179,8,0.25); border-radius:8px; display:flex; align-items:flex-start; gap:8px;">
                        <i class="fas fa-info-circle" style="color:#d97706; font-size:12px; margin-top:1px; flex-shrink:0;"></i>
                        <p style="font-size:12px; color:#92400e; line-height:1.5;">
                            Setelah transfer, kirim bukti pembayaran ke WhatsApp
                            <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer"
                               style="font-weight:600; color:#1a1a1a;">+62 882-9678-3577</a>
                            untuk aktivasi download file.
                        </p>
                    </div>
                </div>

                <label class="payment-opt" :class="payment === 'cc' ? 'selected' : ''" @click="payment='cc'">
                    <input type="radio" name="metode_pembayaran" value="qris">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                 style="background:#ffffff; border:1px solid #e5e7eb;">
                                <i class="fas fa-credit-card" style="color:#6b7280; font-size:14px;"></i>
                            </div>
                            <div>
                                <span class="font-semibold text-[#1a1a1a] text-sm">Kartu Kredit / Debit Online</span>
                                <p class="text-xs mt-0.5" style="color:#6b7280;">Visa, Mastercard, JCB — 3D Secure</p>
                            </div>
                        </div>
                        <div class="w-5 h-5 rounded-full border-2 shrink-0 ml-3 transition-all"
                             :style="payment === 'cc' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                    </div>
                </label>

            </div>
        </div>

        {{-- ── Total Card ── --}}
        <div class="total-card">

            <h2 class="font-montserrat font-bold text-[#1a1a1a] text-sm uppercase tracking-wide mb-4">
                Rincian Pembayaran Digital
            </h2>

            @foreach($keranjang as $item)
            <div class="total-row">
                <span style="color:#6b7280;">{{ $item->produk->nama_produk }} (PDF) &times;{{ $item->jumlah }}</span>
                <span class="font-medium" style="color:#1a1a1a;">Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}</span>
            </div>
            @endforeach

            <div class="total-row">
                <span style="color:#6b7280;">Diskon Produk Digital</span>
                <span style="color:#16a34a; font-weight:600;">−Rp 0</span>
            </div>
            <div class="total-row">
                <span style="color:#6b7280;">Biaya Layanan Gateway</span>
                <span style="color:#16a34a; font-weight:600;">GRATIS</span>
            </div>

            {{-- Grand Total --}}
            <div class="flex items-baseline justify-between pt-4 mt-2" style="border-top:1px solid #e5e7eb;">
                <div>
                    <div class="text-xs" style="color:#6b7280;">Total Tagihan (PDF Master)</div>
                    <div class="text-xs mt-1" style="color:#6b7280;">Sudah termasuk pajak</div>
                </div>
                <div class="font-montserrat font-bold" style="font-size:2rem; color:#1a1a1a;">
                    Rp {{ number_format($total, 0, ',', '.') }}
                </div>
            </div>

            {{-- QRIS preview --}}
            <div x-show="payment === 'qris'"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-y-2"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 class="qris-box">
                <div class="flex items-center gap-2">
                    <i class="fas fa-qrcode" style="color:#1a1a1a; font-size:14px;"></i>
                    <span class="text-xs font-semibold" style="color:#6b7280; letter-spacing:0.05em; text-transform:uppercase;">QRIS Siap Dibayar — Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="qris-img-wrap">
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=160x160&data=PATTERNDIGITAL-DIGITAL-ORDER-{{ now()->format('YmdHis') }}&color=000000&bgcolor=ffffff"
                         alt="QRIS Code"
                         class="w-40 h-40 rounded"
                         onerror="this.src='https://via.placeholder.com/160x160/ffffff/000000?text=QRIS'">
                </div>
                <p class="text-xs text-center leading-relaxed" style="color:#6b7280; max-width:260px;">
                    Scan menggunakan aplikasi m-Banking kamu &amp; bayar sebelum timer habis. Konfirmasi otomatis dalam 3-5 detik.
                </p>
                <div class="flex items-center gap-1 text-xs" style="color:#6b7280;">
                    <i class="fas fa-shield-alt" style="font-size:10px;"></i>
                    <span>PCI DSS Level 1 · Midtrans · SSL</span>
                </div>
            </div>

            {{-- CTA --}}
            <div class="mt-5">
                @if(session('error'))
                <div class="mb-3 p-3 rounded-lg text-xs" style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626;">
                    <i class="fas fa-exclamation-circle mr-1.5"></i>{{ session('error') }}
                </div>
                @endif
                <button type="submit" form="checkout-digital-form" class="btn-bayar-lg">
                    <i class="fas fa-lock" style="font-size:12px; opacity:0.8;"></i>
                    Bayar Sekarang (Konfirmasi Otomatis)
                    <i class="fas fa-arrow-right" style="font-size:11px; opacity:0.7;"></i>
                </button>
            </div>

            <div class="flex items-center justify-center gap-4 mt-4">
                <span class="text-xs" style="color:#6b7280;"><i class="fas fa-shield-alt mr-1"></i>Pembayaran Aman Midtrans</span>
                <span class="text-xs" style="color:#d1d5db;">·</span>
                <a href="{{ route('keranjang') }}" class="text-xs hover:text-[#1a1a1a] transition-colors" style="color:#6b7280;">
                    <i class="fas fa-arrow-left mr-1" style="font-size:9px;"></i> Kembali
                </a>
            </div>
        </div>

        {{-- ── Download guarantee note ── --}}
        <div class="mt-5 p-4 rounded-xl flex gap-3" style="background:#f5f5f5; border:1px solid #e5e7eb;">
            <i class="fas fa-download mt-0.5 shrink-0" style="color:#16a34a; font-size:14px;"></i>
            <div>
                <p class="text-sm font-semibold text-[#1a1a1a] mb-1">Pengiriman File Otomatis Tanpa Menunggu</p>
                <p class="text-xs leading-relaxed" style="color:#6b7280;">
                    File PDF &amp; CAD akan dikirim ke email kamu dalam hitungan detik setelah pembayaran berhasil. Tersedia download ulang tanpa batas dari halaman akun kamu.
                </p>
            </div>
        </div>

    </div>
</div>

<script>
    function copyNorekDigital() {
        var norek = document.getElementById('norek-digital').textContent.trim();
        navigator.clipboard.writeText(norek).then(function () {
            var icon = document.getElementById('copy-icon-digital');
            if (icon) {
                icon.className = 'fas fa-check';
                icon.style.color = '#16a34a';
                setTimeout(function () {
                    icon.className = 'fas fa-copy';
                    icon.style.color = '#6b7280';
                }, 2000);
            }
        }).catch(function () {
            alert('No. rekening: ' + norek);
        });
    }
</script>
@endsection
