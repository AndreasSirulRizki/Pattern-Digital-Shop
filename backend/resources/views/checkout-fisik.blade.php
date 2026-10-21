@extends('layouts.app')

@section('title', 'Checkout - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Checkout Fisik Styles ── */

    .checkout-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .checkout-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
    }
    .checkout-card-body { padding: 20px; }

    .card-step-num {
        width: 26px; height: 26px;
        border-radius: 50%;
        background: #1a1a1a;
        border: 1px solid #1a1a1a;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700;
        color: #ffffff;
        margin-right: 10px;
        flex-shrink: 0;
    }

    /* Form */
    .form-label {
        display: block;
        font-size: 12px;
        font-weight: 500;
        color: #1a1a1a;
        margin-bottom: 6px;
        letter-spacing: 0.03em;
    }
    .form-label span { color: #ef4444; margin-left: 2px; }

    .form-input {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-size: 14px;
        font-family: 'Inter', sans-serif;
        padding: 10px 14px;
        outline: none;
        transition: border-color 0.2s ease;
    }
    .form-input:focus { border-color: #1a1a1a; box-shadow: 0 0 0 2px rgba(26,26,26,0.06); }
    .form-input::placeholder { color: #9ca3af; }
    .form-input:disabled { opacity: 0.4; cursor: not-allowed; }

    select.form-input { cursor: pointer; }
    select.form-input option { background: #ffffff; color: #1a1a1a; }

    textarea.form-input { resize: vertical; min-height: 80px; }

    /* Stepper */
    .stepper {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0;
        margin-bottom: 36px;
    }
    .step-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        position: relative;
        z-index: 1;
    }
    .step-circle {
        width: 36px; height: 36px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 13px; font-weight: 700;
        transition: all 0.2s ease;
        border: 2px solid #e5e7eb;
        background: #f5f5f5;
        color: #9ca3af;
    }
    .step-circle.done {
        background: #e5e7eb;
        border-color: #e5e7eb;
        color: #6b7280;
    }
    .step-circle.active {
        background: #1a1a1a;
        border-color: #1a1a1a;
        color: #ffffff;
        box-shadow: 0 0 16px rgba(26,26,26,0.2);
    }
    .step-label {
        font-size: 11px;
        font-weight: 500;
        white-space: nowrap;
    }
    .step-label.done   { color: #6b7280; }
    .step-label.active { color: #1a1a1a; font-weight: 600; }
    .step-label.pending { color: #9ca3af; }

    .step-line {
        flex: 1;
        height: 2px;
        background: #e5e7eb;
        min-width: 40px;
        max-width: 80px;
        margin-bottom: 22px;
    }
    .step-line.done { background: #6b7280; }

    /* Kurir radio */
    .kurir-option {
        position: relative;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f5f5f5;
    }
    .kurir-option:hover { border-color: #6b7280; }
    .kurir-option.selected {
        border-color: #1a1a1a;
        background: #ffffff;
        box-shadow: 0 0 0 1px #1a1a1a;
    }
    .kurir-option input[type="radio"] { display: none; }

    .kurir-badge {
        font-size: 9px; font-weight: 700;
        padding: 2px 6px; border-radius: 4px;
        letter-spacing: 0.06em; text-transform: uppercase;
    }
    .kurir-badge.rekomendasi { background: rgba(51,51,51,0.08); color: #333333; border: 1px solid rgba(51,51,51,0.2); }
    .kurir-badge.express    { background: rgba(251,191,36,0.1); color: #d97706; border: 1px solid rgba(251,191,36,0.3); }
    .kurir-badge.ekonomis   { background: rgba(22,163,74,0.08); color: #16a34a; border: 1px solid rgba(22,163,74,0.2); }

    /* Metode bayar */
    .payment-option {
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        cursor: pointer;
        transition: all 0.2s ease;
        background: #f5f5f5;
        margin-bottom: 10px;
    }
    .payment-option:last-child { margin-bottom: 0; }
    .payment-option:hover { border-color: #6b7280; }
    .payment-option.selected {
        border-color: #1a1a1a;
        background: #ffffff;
        box-shadow: 0 0 0 1px #1a1a1a;
    }
    .payment-option input[type="radio"] { display: none; }

    .pay-badge-instant { background: rgba(22,163,74,0.08); color: #16a34a; border: 1px solid rgba(22,163,74,0.2); font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 4px; letter-spacing: 0.05em; text-transform: uppercase; }

    /* QRIS preview */
    .qris-preview {
        background: #ffffff;
        border-radius: 10px;
        padding: 16px;
        display: inline-block;
        margin-top: 12px;
        border: 1px solid #e5e7eb;
    }

    /* Summary card */
    .summary-card {
        position: sticky;
        top: 80px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        padding: 24px;
    }

    .summary-item {
        display: flex;
        gap: 12px;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .summary-item:last-child { border-bottom: none; }

    .summary-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }
    .summary-row:last-child { border-bottom: none; }

    .btn-bayar {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%;
        padding: 14px 24px;
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
    .btn-bayar::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 50%;
        background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 100%);
        pointer-events: none;
    }
    .btn-bayar:hover {
        background: #333333;
        box-shadow: 0 4px 20px rgba(26,26,26,0.2);
        transform: translateY(-1px);
    }

    /* Checkbox */
    .custom-checkbox {
        display: flex; align-items: center; gap: 10px;
        cursor: pointer; user-select: none;
    }
    .custom-checkbox input[type="checkbox"] { display: none; }
    .checkbox-box {
        width: 18px; height: 18px;
        border: 1px solid #e5e7eb; border-radius: 4px;
        background: #ffffff;
        display: flex; align-items: center; justify-content: center;
        transition: all 0.2s ease;
        flex-shrink: 0;
    }
    .custom-checkbox input:checked + .checkbox-box {
        background: #1a1a1a; border-color: #1a1a1a;
    }
    .custom-checkbox input:checked + .checkbox-box::after {
        content: '✓'; color: #ffffff; font-size: 11px; font-weight: 700;
    }

    /* Trust badge */
    .trust-badge {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        padding: 10px 16px; border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        margin-top: 12px;
    }

    /* Breadcrumb */
    .breadcrumb-sep { color: #d1d5db; margin: 0 6px; font-size: 9px; }
</style>
</div>{{-- end min-h --}}
</form>
@endsection

@section('content')
{{-- Data dinamis dari KeranjangController/CheckoutController --}}
@php
    $ongkir = $ongkir ?? 15000;
    $total  = $total  ?? ($subtotal + $ongkir);
@endphp

<form action="{{ route('checkout.store') }}" method="POST" id="checkout-form" enctype="multipart/form-data">
@csrf
<input type="hidden" name="tipe_pesanan" value="fisik">
<div class="min-h-screen" style="background:#faf8f5;"
     x-data="{
        kurir: 'jne',
        payment: 'qris',
        simpanAlamat: false,
     }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center text-xs mb-5" style="color:#6b7280;">
            <a href="{{ route('home') }}"     style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
            <span class="breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <a href="{{ route('keranjang') }}" style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Keranjang</a>
            <span class="breadcrumb-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <span style="color:#1a1a1a;">Checkout</span>
        </div>

        {{-- ── Judul ── --}}
        <div class="mb-8">
            <div class="inline-block px-3 py-1 rounded-full text-xs font-semibold mb-3"
                 style="background:rgba(51,51,51,0.07); border:1px solid rgba(51,51,51,0.15); color:#333333; letter-spacing:0.08em; text-transform:uppercase;">
                <i class="fas fa-box mr-1.5" style="font-size:9px;"></i> Produk Fisik
            </div>
            <h1 class="font-montserrat font-bold text-[#1a1a1a] text-3xl tracking-tight">Checkout</h1>
        </div>

        {{-- ── Stepper ── --}}
        <div class="stepper">
            {{-- Step 1: Keranjang (done) --}}
            <div class="step-item">
                <div class="step-circle done"><i class="fas fa-check" style="font-size:12px;"></i></div>
                <span class="step-label done">Keranjang</span>
            </div>
            <div class="step-line done"></div>

            {{-- Step 2: Pengiriman (active) --}}
            <div class="step-item">
                <div class="step-circle active">2</div>
                <span class="step-label active">Pengiriman &amp; Bayar</span>
            </div>
            <div class="step-line"></div>

            {{-- Step 3: Verifikasi --}}
            <div class="step-item">
                <div class="step-circle">3</div>
                <span class="step-label pending">Verifikasi</span>
            </div>
            <div class="step-line"></div>

            {{-- Step 4: Selesai --}}
            <div class="step-item">
                <div class="step-circle">4</div>
                <span class="step-label pending">Selesai</span>
            </div>
        </div>

        {{-- ── 2 Kolom ── --}}
        <div class="flex flex-col lg:flex-row gap-7 items-start">

            {{-- ══════════════════════════════════════ --}}
            {{-- KIRI — Form                            --}}
            {{-- ══════════════════════════════════════ --}}
            <div class="w-full lg:w-[60%]">

                {{-- ─ Card 1: Alamat ─ --}}
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <div class="flex items-center">
                            <span class="card-step-num">1</span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Alamat Pengiriman</span>
                        </div>
                        <span class="text-xs" style="color:#6b7280;">Lengkapi data ini</span>
                    </div>
                    <div class="checkout-card-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            {{-- Nama --}}
                            <div>
                                <label class="form-label">Nama Penerima <span>*</span></label>
                                <input type="text" name="nama_penerima" class="form-input" placeholder="Contoh: Budi Santoso" value="{{ old('nama_penerima') }}" required>
                            </div>
                            {{-- HP --}}
                            <div>
                                <label class="form-label">No. HP / WhatsApp <span>*</span></label>
                                <input type="tel" name="no_hp" class="form-input" placeholder="Contoh: 08123456789" value="{{ old('no_hp') }}" required>
                            </div>
                        </div>

                        {{-- Alamat --}}
                        <div class="mt-4">
                            <label class="form-label">Alamat Lengkap (Workshop / Studio Taller) <span>*</span></label>
                            <textarea name="alamat" class="form-input" placeholder="Jl. Merdeka No. 10, RT 02/RW 05, Bandung..." required>{{ old('alamat') }}</textarea>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                            {{-- Kota --}}
                            <div>
                                <label class="form-label">Kota / Kecamatan <span>*</span></label>
                                <select class="form-input">
                                    <option value="">Pilih kota...</option>
                                    <option>Jakarta Pusat</option>
                                    <option>Jakarta Selatan</option>
                                    <option>Jakarta Barat</option>
                                    <option>Jakarta Timur</option>
                                    <option>Jakarta Utara</option>
                                    <option>Bandung</option>
                                    <option>Surabaya</option>
                                    <option>Yogyakarta</option>
                                    <option>Semarang</option>
                                    <option>Medan</option>
                                    <option>Makassar</option>
                                </select>
                            </div>
                            {{-- Kode pos --}}
                            <div>
                                <label class="form-label">Kode Pos <span>*</span></label>
                                <input type="text" name="kode_pos" class="form-input" placeholder="Contoh: 10110" maxlength="5" value="{{ old('kode_pos') }}">
                            </div>
                        </div>

                        {{-- Checkbox simpan alamat --}}
                        <div class="mt-4">
                            <label class="custom-checkbox">
                                <input type="checkbox" x-model="simpanAlamat">
                                <div class="checkbox-box"></div>
                                <span class="text-sm" style="color:#6b7280;">Simpan sebagai alamat utama workshop</span>
                            </label>
                        </div>

                        {{-- Note packaging --}}
                        <div class="mt-4 p-3 rounded-lg flex gap-3" style="background:#f5f5f5; border:1px solid #e5e7eb;">
                            <i class="fas fa-info-circle mt-0.5 shrink-0" style="color:#6b7280; font-size:12px;"></i>
                            <p class="text-xs leading-relaxed" style="color:#6b7280;">
                                <strong style="color:#1a1a1a;">Standard Packaging:</strong> Pola fisik menggunakan hard tube silinder 2mm unit tebal &amp; tahan air. Pola pattern dicetak setiap sudut bebas tepatan jalan.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- ─ Card 2: Kurir ─ --}}
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <div class="flex items-center">
                            <span class="card-step-num">2</span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Opsi Kurir Ekspedisi</span>
                        </div>
                        <span class="text-xs" style="color:#6b7280;">Estimasi tiba 1-4 hari kerja Pulau Jawa &amp; Bali</span>
                    </div>
                    <div class="checkout-card-body">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                            {{-- JNE --}}
                            <label class="kurir-option" :class="kurir === 'jne' ? 'selected' : ''" @click="kurir='jne'">
                                <input type="radio" name="kurir" value="jne" x-bind:checked="kurir === 'jne'">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-[#1a1a1a] text-sm">JNE Reguler</span>
                                            <span class="kurir-badge rekomendasi">Rekomendasi</span>
                                        </div>
                                        <div class="text-xs" style="color:#6b7280;">Estimasi tiba 2-3 hari</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Tarif 2 hari: 1 kg</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-montserrat font-bold" style="color:#1a1a1a;">Rp 24.000</div>
                                        <div class="w-4 h-4 rounded-full border-2 mt-1 ml-auto transition-all"
                                             :style="kurir === 'jne' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                                    </div>
                                </div>
                            </label>

                            {{-- SiCepat --}}
                            <label class="kurir-option" :class="kurir === 'sicepat' ? 'selected' : ''" @click="kurir='sicepat'">
                                <input type="radio" name="kurir" value="sicepat" x-bind:checked="kurir === 'sicepat'">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-[#1a1a1a] text-sm">SiCepat BEST</span>
                                            <span class="kurir-badge express">Express</span>
                                        </div>
                                        <div class="text-xs" style="color:#6b7280;">Estimasi tiba 1-2 hari</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Tarif 2 hari: 1 kg</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-montserrat font-bold" style="color:#1a1a1a;">Rp 28.000</div>
                                        <div class="w-4 h-4 rounded-full border-2 mt-1 ml-auto transition-all"
                                             :style="kurir === 'sicepat' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                                    </div>
                                </div>
                            </label>

                            {{-- J&T --}}
                            <label class="kurir-option" :class="kurir === 'jt' ? 'selected' : ''" @click="kurir='jt'">
                                <input type="radio" name="kurir" value="jt" x-bind:checked="kurir === 'jt'">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-[#1a1a1a] text-sm">J&amp;T Express</span>
                                        </div>
                                        <div class="text-xs" style="color:#6b7280;">Estimasi tiba 2-3 hari</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Tarif 2 hari: 1 kg</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-montserrat font-bold" style="color:#1a1a1a;">Rp 22.000</div>
                                        <div class="w-4 h-4 rounded-full border-2 mt-1 ml-auto transition-all"
                                             :style="kurir === 'jt' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                                    </div>
                                </div>
                            </label>

                            {{-- POS --}}
                            <label class="kurir-option" :class="kurir === 'pos' ? 'selected' : ''" @click="kurir='pos'">
                                <input type="radio" name="kurir" value="pos" x-bind:checked="kurir === 'pos'">
                                <div class="flex items-start justify-between gap-2">
                                    <div>
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="font-semibold text-[#1a1a1a] text-sm">POS Kilat Khusus</span>
                                            <span class="kurir-badge ekonomis">Ekonomis</span>
                                        </div>
                                        <div class="text-xs" style="color:#6b7280;">Estimasi tiba 2-4 hari</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Tarif Ekonomis</div>
                                    </div>
                                    <div class="text-right shrink-0">
                                        <div class="font-montserrat font-bold" style="color:#1a1a1a;">Rp 19.000</div>
                                        <div class="w-4 h-4 rounded-full border-2 mt-1 ml-auto transition-all"
                                             :style="kurir === 'pos' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                                    </div>
                                </div>
                            </label>

                        </div>

                        <p class="text-xs mt-3" style="color:#6b7280;">
                            <i class="fas fa-info-circle mr-1"></i>
                            Termasuk Asuransi Kerusakan Penjual &amp; Proteksi. Suka Kurir Kirim Garment Bandung.
                        </p>
                    </div>
                </div>

                {{-- ─ Card 3: Metode Bayar ─ --}}
                <div class="checkout-card">
                    <div class="checkout-card-header">
                        <div class="flex items-center">
                            <span class="card-step-num">3</span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Metode Pembayaran</span>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-md"
                              style="background:rgba(22,163,74,0.08); color:#16a34a; border:1px solid rgba(22,163,74,0.2); font-size:10px; font-weight:600;">
                            MANUAL TRANSFER
                        </span>
                    </div>
                    <div class="checkout-card-body">

                        {{-- QRIS DANA --}}
                        <label class="payment-option" :class="payment === 'qris' ? 'selected' : ''" @click="payment='qris'">
                            <input type="radio" name="metode_pembayaran" value="qris" x-bind:checked="payment === 'qris'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                         style="background:#ffffff; border:1px solid #e5e7eb;">
                                        <i class="fas fa-qrcode" style="color:#1a1a1a; font-size:16px;"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-semibold text-[#1a1a1a] text-sm">QRIS (DANA, GoPay, OVO, ShopeePay)</span>
                                            <span class="pay-badge-instant">Instant</span>
                                        </div>
                                        <p class="text-xs mt-0.5" style="color:#6b7280;">Scan QR code pakai aplikasi e-wallet</p>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 shrink-0 transition-all"
                                     :style="payment === 'qris' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                            </div>
                        </label>

                        {{-- Detail QRIS: QR DANA + upload bukti --}}
                        <div x-show="payment === 'qris'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="background:#f5f5f5; border:1px solid #e5e7eb; border-radius:10px; padding:20px; margin-top:4px; margin-bottom:10px;">
                            <h4 class="font-semibold text-[#1a1a1a] text-sm mb-4 text-center">Scan QR Code untuk Bayar:</h4>

                            {{-- QR DANA --}}
                            <div class="flex justify-center mb-4">
                                <div style="background:#ffffff; padding:16px; border-radius:10px; border:2px solid #e5e7eb; display:inline-block;">
                                    <img src="{{ asset('images/qris-dana.png') }}"
                                         alt="QRIS DANA"
                                         style="width:200px; height:200px; object-fit:contain; display:block;"
                                         onerror="this.src='https://placehold.co/200x200/ffffff/1a1a1a?text=QRIS+DANA'">
                                </div>
                            </div>

                            <p class="text-xs text-center mb-4" style="color:#6b7280;">
                                Scan pakai DANA, GoPay, OVO, ShopeePay, atau m-Banking
                            </p>

                            {{-- Upload bukti QRIS --}}
                            <div style="border-top:1px solid #e5e7eb; padding-top:16px;">
                                <label class="form-label">
                                    Upload Bukti Pembayaran <span>*</span>
                                </label>
                                <input type="file" name="bukti" accept="image/jpeg,image/png,image/jpg"
                                       class="w-full text-sm"
                                       style="color:#6b7280; cursor:pointer;"
                                       required>
                                <p class="text-xs mt-1" style="color:#9ca3af;">Format: JPG, PNG. Maks 2MB.</p>
                            </div>
                        </div>

                        {{-- Transfer Bank --}}
                        <label class="payment-option" :class="payment === 'transfer' ? 'selected' : ''" @click="payment='transfer'">
                            <input type="radio" name="metode_pembayaran" value="transfer" x-bind:checked="payment === 'transfer'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                         style="background:#ffffff; border:1px solid #e5e7eb;">
                                        <i class="fas fa-university" style="color:#6b7280; font-size:14px;"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-[#1a1a1a] text-sm">Transfer Bank</span>
                                        <p class="text-xs mt-0.5" style="color:#6b7280;">SeaBank · 901339829925 a/n Saepudin</p>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 shrink-0 transition-all"
                                     :style="payment === 'transfer' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                            </div>
                        </label>

                        {{-- Detail Transfer Bank --}}
                        <div x-show="payment === 'transfer'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="background:#f5f5f5; border:1px solid #e5e7eb; border-radius:10px; padding:20px; margin-top:4px; margin-bottom:10px;">
                            <div class="flex items-center gap-2 mb-3">
                                <i class="fas fa-university" style="color:#1a1a1a; font-size:12px;"></i>
                                <span style="font-size:11px; font-weight:700; color:#1a1a1a; letter-spacing:0.05em; text-transform:uppercase;">Rekening Tujuan Transfer</span>
                            </div>

                            <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:8px; overflow:hidden; margin-bottom:12px;">
                                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; border-bottom:1px solid #f3f4f6;">
                                    <span style="font-size:13px; color:#6b7280;">Bank</span>
                                    <span style="font-size:13px; font-weight:600; color:#1a1a1a;">SeaBank</span>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px; border-bottom:1px solid #f3f4f6;">
                                    <span style="font-size:13px; color:#6b7280;">No. Rekening</span>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span style="font-family:monospace; font-size:14px; font-weight:700; color:#1a1a1a;" id="norek-fisik">901339829925</span>
                                        <button type="button" onclick="copyNorek('norek-fisik')"
                                                title="Copy no. rekening"
                                                style="width:28px; height:28px; border-radius:6px; background:#f5f5f5; border:1px solid #e5e7eb; cursor:pointer; display:flex; align-items:center; justify-content:center; transition:all 0.15s;"
                                                onmouseover="this.style.borderColor='#9ca3af';"
                                                onmouseout="this.style.borderColor='#e5e7eb';">
                                            <i class="fas fa-copy" style="color:#6b7280; font-size:11px;"></i>
                                        </button>
                                    </div>
                                </div>
                                <div style="display:flex; justify-content:space-between; align-items:center; padding:10px 14px;">
                                    <span style="font-size:13px; color:#6b7280;">Atas Nama</span>
                                    <span style="font-size:13px; font-weight:600; color:#1a1a1a;">Saepudin</span>
                                </div>
                            </div>

                            {{-- Upload bukti transfer --}}
                            <div style="border-top:1px solid #e5e7eb; padding-top:16px;">
                                <label class="form-label">
                                    Upload Bukti Transfer <span>*</span>
                                </label>
                                <input type="file" name="bukti" accept="image/jpeg,image/png,image/jpg"
                                       class="w-full text-sm"
                                       style="color:#6b7280; cursor:pointer;"
                                       required>
                                <p class="text-xs mt-1" style="color:#9ca3af;">Format: JPG, PNG. Maks 2MB.</p>
                            </div>
                        </div>

                        {{-- COD --}}
                        <label class="payment-option" :class="payment === 'cod' ? 'selected' : ''" @click="payment='cod'">
                            <input type="radio" name="metode_pembayaran" value="cod" x-bind:checked="payment === 'cod'">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-lg flex items-center justify-center shrink-0"
                                         style="background:#ffffff; border:1px solid #e5e7eb;">
                                        <i class="fas fa-money-bill-wave" style="color:#6b7280; font-size:13px;"></i>
                                    </div>
                                    <div>
                                        <span class="font-semibold text-[#1a1a1a] text-sm">COD (Bayar di Tempat)</span>
                                        <p class="text-xs mt-0.5" style="color:#6b7280;">Khusus produk fisik · Bayar saat barang diterima</p>
                                    </div>
                                </div>
                                <div class="w-5 h-5 rounded-full border-2 shrink-0 transition-all"
                                     :style="payment === 'cod' ? 'border-color:#1a1a1a; background:#1a1a1a;' : 'border-color:#e5e7eb;'"></div>
                            </div>
                        </label>

                        {{-- Detail COD --}}
                        <div x-show="payment === 'cod'"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:10px; padding:14px 16px; margin-top:4px; display:flex; align-items:flex-start; gap:10px;">
                            <i class="fas fa-truck" style="color:#16a34a; font-size:13px; margin-top:2px; flex-shrink:0;"></i>
                            <p style="font-size:13px; color:#166534; line-height:1.6;">
                                Pesanan akan langsung diproses. Kamu cukup bayar saat barang tiba — tidak perlu upload bukti apapun.
                            </p>
                        </div>

                    </div>
                </div>

            </div>{{-- end kiri --}}

            {{-- ══════════════════════════════════════ --}}
            {{-- KANAN — Ringkasan                      --}}
            {{-- ══════════════════════════════════════ --}}
            <div class="w-full lg:w-[40%]">
                <div class="summary-card">

                    {{-- Header --}}
                    <div class="flex items-center justify-between mb-5" style="border-bottom:1px solid #e5e7eb; padding-bottom:14px;">
                        <h2 class="font-montserrat font-bold text-[#1a1a1a] text-sm uppercase tracking-wide">
                            Ringkasan Pesanan
                        </h2>
                        <span class="text-xs px-2 py-1 rounded-md"
                              style="background:#f5f5f5; border:1px solid #e5e7eb; color:#333333;">
                            Fisik · {{ $keranjang->count() }} item
                        </span>
                    </div>

                    {{-- Item list --}}
                    <div class="mb-4">
                        @foreach($keranjang as $item)
                        @php
                            $imgSrc = $item->produk->gambar
                                ? asset('storage/' . $item->produk->gambar)
                                : 'https://via.placeholder.com/40x40/f5f5f5/6b7280?text=P';
                        @endphp
                        <div class="summary-item">
                            <div class="w-10 h-10 rounded-lg shrink-0 overflow-hidden"
                                 style="background:#f5f5f5; border:1px solid #e5e7eb;">
                                <img src="{{ $imgSrc }}"
                                     class="w-full h-full object-cover" alt="{{ $item->produk->nama_produk }}"
                                     onerror="this.src='https://via.placeholder.com/40x40/f5f5f5/6b7280?text=P'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-[#1a1a1a] leading-snug truncate">{{ $item->produk->nama_produk }}</p>
                                <p class="text-xs mt-0.5" style="color:#6b7280;">Qty: {{ $item->jumlah }}</p>
                            </div>
                            <div class="shrink-0 text-right">
                                <span class="text-sm font-semibold" style="color:#1a1a1a;">
                                    Rp {{ number_format($item->produk->harga * $item->jumlah, 0, ',', '.') }}
                                </span>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Summary rows --}}
                    <div style="border-top:1px solid #e5e7eb;">
                        <div class="summary-row">
                            <span style="color:#6b7280;">Subtotal Pola Fisik</span>
                            <span class="font-medium" style="color:#1a1a1a;">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span style="color:#6b7280;">Diskon Bundle Taller</span>
                            <span style="color:#16a34a; font-weight:600; font-size:12px;">Rp 0</span>
                        </div>
                        <div class="summary-row" x-show="kurir !== ''">
                            <span style="color:#6b7280;">Ongkir JNE Reguler</span>
                            <span class="font-medium" style="color:#1a1a1a;">Rp {{ number_format($ongkir, 0, ',', '.') }}</span>
                        </div>
                        <div class="summary-row">
                            <span style="color:#6b7280;">Biaya Proteksi Packing Hard Tube</span>
                            <span style="color:#16a34a; font-weight:600; font-size:12px;">GRATIS (RP 0)</span>
                        </div>
                    </div>

                    {{-- Total --}}
                    <div class="flex items-baseline justify-between mt-4 pt-4"
                         style="border-top:1px solid #e5e7eb;">
                        <div>
                            <div class="text-xs mb-1" style="color:#6b7280;">Total Tagihan Bersih</div>
                            <div class="text-xs" style="color:#6b7280;">Sudah termasuk PPN 11%</div>
                        </div>
                        <div class="font-montserrat font-bold text-3xl" style="color:#1a1a1a;">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="mt-6">
                        @if(session('error'))
                        <div class="mb-3 p-3 rounded-lg text-xs" style="background:#fef2f2; border:1px solid #fecaca; color:#dc2626;">
                            <i class="fas fa-exclamation-circle mr-1.5"></i>{{ session('error') }}
                        </div>
                        @endif
                        <button type="submit" form="checkout-form" class="btn-bayar"
                                x-bind:data-payment="payment">
                            <i class="fas fa-lock" style="font-size:12px; opacity:0.8;"></i>
                            <span x-text="payment === 'qris' ? 'Bayar Sekarang (QRIS)' : payment === 'cod' ? 'Pesan (Bayar di Tempat)' : 'Bayar via Transfer Bank'"></span>
                            <i class="fas fa-arrow-right" style="font-size:11px; opacity:0.7;"></i>
                        </button>
                    </div>

                    {{-- Trust --}}
                    <div class="trust-badge">
                        <i class="fas fa-shield-alt" style="color:#333333; font-size:12px;"></i>
                        <span class="text-xs" style="color:#6b7280;">Pembayaran aman via</span>
                        <span class="text-xs font-semibold" style="color:#1a1a1a;">Midtrans</span>
                    </div>

                    {{-- Back to cart --}}
                    <div class="mt-4 text-center">
                        <a href="{{ route('keranjang') }}" class="text-xs hover:text-[#1a1a1a] transition-colors" style="color:#6b7280;">
                            <i class="fas fa-arrow-left mr-1" style="font-size:9px;"></i> Kembali ke Keranjang
                        </a>
                    </div>

                </div>
            </div>

        </div>{{-- end 2 col --}}

    </div>
</div>

<script>
    function copyNorek(elId) {
        var norek = document.getElementById(elId).textContent.trim();
        navigator.clipboard.writeText(norek).then(function () {
            var btn = document.querySelector('[onclick="copyNorek(\'' + elId + '\')"]');
            if (btn) {
                btn.innerHTML = '<i class="fas fa-check" style="color:#16a34a; font-size:11px;"></i>';
                setTimeout(function () {
                    btn.innerHTML = '<i class="fas fa-copy" style="color:#6b7280; font-size:11px;"></i>';
                }, 2000);
            }
        }).catch(function () {
            alert('No. rekening: ' + norek);
        });
    }
</script>
@endsection
