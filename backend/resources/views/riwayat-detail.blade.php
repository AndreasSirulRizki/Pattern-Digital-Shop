@extends('layouts.app')

@section('title', 'Detail Pesanan - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Riwayat Detail ── */

    .detail-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        margin-bottom: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .detail-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 8px;
        background: #faf8f5;
    }
    .detail-card-body { padding: 20px; }

    .card-icon-num {
        width: 24px; height: 24px; border-radius: 50%;
        background: #1a1a1a;
        border: 1px solid #1a1a1a;
        display: inline-flex; align-items: center; justify-content: center;
        font-size: 10px; font-weight: 700; color: #ffffff;
        margin-right: 8px; flex-shrink: 0;
    }

    /* Produk row */
    .item-row {
        display: flex;
        align-items: center;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .item-row:last-child { border-bottom: none; }

    .item-thumb {
        width: 64px; height: 64px;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        flex-shrink: 0;
    }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* Status badges */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.04em;
    }
    .status-badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; }

    .status-dikirim  { background: rgba(59,130,246,0.1);  border:1px solid rgba(59,130,246,0.3);  color: #1d4ed8; }
    .status-dikirim::before  { background: #3b82f6; }
    .status-selesai  { background: rgba(22,163,74,0.1);   border:1px solid rgba(22,163,74,0.3);   color: #15803d; }
    .status-selesai::before  { background: #16a34a; }
    .status-diproses { background: rgba(234,179,8,0.1);   border:1px solid rgba(234,179,8,0.3);   color: #b45309; }
    .status-diproses::before { background: #d97706; }
    .status-lunas    { background: rgba(22,163,74,0.1);   border:1px solid rgba(22,163,74,0.3);   color: #15803d; }
    .status-lunas::before    { background: #16a34a; }

    /* Info label-value */
    .info-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 9px 0;
        border-bottom: 1px solid #f0f0f0;
        gap: 12px;
        font-size: 13px;
    }
    .info-row:last-child { border-bottom: none; }

    /* Summary card (sticky) */
    .summary-sticky {
        position: sticky;
        top: 80px;
    }

    .summary-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
        margin-bottom: 14px;
    }
    .summary-card-header {
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        background: #faf8f5;
    }
    .summary-card-body { padding: 20px; }

    .sum-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 9px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }
    .sum-row:last-child { border-bottom: none; }

    /* Timeline */
    .timeline-item {
        display: flex;
        gap: 14px;
        padding-bottom: 20px;
        position: relative;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item:not(:last-child)::before {
        content: '';
        position: absolute;
        left: 13px; top: 26px;
        width: 1px;
        bottom: 0;
        background: linear-gradient(to bottom, #e5e7eb, transparent);
    }
    .timeline-dot {
        width: 28px; height: 28px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        position: relative; z-index: 1;
        border: 1px solid #e5e7eb;
        background: #f5f5f5;
    }
    .timeline-dot.done {
        background: #e5e7eb;
        border-color: #6b7280;
    }
    .timeline-dot.active {
        background: #1a1a1a;
        border-color: #1a1a1a;
        box-shadow: 0 0 10px rgba(26,26,26,0.2);
    }
    .timeline-dot.active i { color: #ffffff !important; }

    /* Type badges */
    .badge-fisik {
        font-size: 9px; font-weight: 700;
        padding: 2px 6px; border-radius: 4px;
        background: rgba(168,85,247,0.08);
        border: 1px solid rgba(168,85,247,0.2);
        color: #7c3aed;
        letter-spacing: 0.04em;
    }
    .badge-digital {
        font-size: 9px; font-weight: 700;
        padding: 2px 6px; border-radius: 4px;
        background: rgba(51,51,51,0.07);
        border: 1px solid rgba(51,51,51,0.15);
        color: #333333;
        letter-spacing: 0.04em;
    }

    /* Buttons */
    .btn-back {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #6b7280;
        font-size: 13px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .btn-back:hover { border-color: #1a1a1a; color: #1a1a1a; }

    .btn-outline-sm {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px;
        background: #ffffff;
        border: 1px solid #333333;
        border-radius: 8px;
        color: #333333;
        font-size: 12px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-outline-sm:hover { background: #f5f5f5; border-color: #1a1a1a; color: #1a1a1a; }

    .btn-primary-sm {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 9px 16px;
        background: #1a1a1a;
        border: none;
        border-radius: 8px;
        color: #ffffff;
        font-size: 12px; font-weight: 600;
        font-family: 'Montserrat', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-primary-sm:hover {
        background: #333333;
        box-shadow: 0 2px 8px rgba(26,26,26,0.2);
        transform: translateY(-1px);
    }

    /* Breadcrumb */
    .bc-sep { color: #d1d5db; margin: 0 6px; font-size: 9px; }

    /* Resi pill */
    .resi-pill {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 5px 12px; border-radius: 6px;
        background: rgba(59,130,246,0.06);
        border: 1px solid rgba(59,130,246,0.2);
        color: #1d4ed8; font-size: 12px; font-weight: 600;
        font-family: 'Montserrat', monospace;
        letter-spacing: 0.04em;
    }
</style>
@endsection

@section('content')
@php
$pesanan = [
    'no_order'  => 'ORD-20260928-001',
    'tanggal'   => '28 Sep 2026 · 10:05 WIB',
    'status'    => 'dikirim',
    'tipe'      => 'fisik',
    'kurir'     => 'JNE Reguler',
    'no_resi'   => 'JNE123456789',
    'metode'    => 'QRIS',
    'pembayaran'=> 'Lunas',
    'items'     => [
        ['nama' => 'Pola Kemeja Pria Slim Fit', 'tipe' => 'fisik', 'qty' => 1, 'harga' => 75000,  'gambar' => ''],
        ['nama' => 'Pola Gaun Pesta Malam',     'tipe' => 'fisik', 'qty' => 2, 'harga' => 150000, 'gambar' => ''],
    ],
    'alamat'    => [
        'nama'   => 'Budi Santoso — Atelier Taller',
        'hp'     => '+62 812-3456-7890',
        'detail' => 'Jl. Kebun Jaya Raya No. 42B, RT 03 / RW 03, Workshop Taller LL 2',
        'kota'   => 'Jakarta Selatan — Kebun Jeruk',
        'kodepos'=> '11510',
    ],
    'subtotal'  => 375000,
    'ongkir'    => 15000,
    'diskon'    => 0,
    'total'     => 390000,
];

$timeline = [
    ['time' => '28 Sep · 10:00', 'label' => 'Pesanan Dibuat',          'desc' => 'Pesanan #ORD-20260928-001 berhasil dibuat.',      'done' => true,  'active' => false],
    ['time' => '28 Sep · 10:05', 'label' => 'Pembayaran Dikonfirmasi', 'desc' => 'Pembayaran via QRIS berhasil diverifikasi.',     'done' => true,  'active' => false],
    ['time' => '28 Sep · 14:00', 'label' => 'Pesanan Diproses',        'desc' => 'Tim sedang mempersiapkan & mengemas pola kamu.', 'done' => true,  'active' => false],
    ['time' => '29 Sep · 08:00', 'label' => 'Pesanan Dikirim',         'desc' => 'Paket diserahkan ke JNE Reguler. Resi: JNE123456789', 'done' => false, 'active' => true ],
    ['time' => '—',              'label' => 'Pesanan Tiba / Selesai',  'desc' => 'Menunggu konfirmasi penerimaan.',                'done' => false, 'active' => false],
];
@endphp

<div class="min-h-screen" style="background:#faf8f5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center text-xs mb-5" style="color:#6b7280;">
            <a href="{{ route('home') }}"    style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <a href="{{ route('riwayat') }}" style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Pesanan Saya</a>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <span style="color:#1a1a1a;">Detail Pesanan</span>
        </div>

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
            <div>
                <div class="flex items-center gap-3 flex-wrap mb-1">
                    <h1 class="font-montserrat font-bold text-[#1a1a1a] text-2xl tracking-tight">
                        Detail Pesanan
                    </h1>
                    <span class="font-montserrat font-bold tracking-wide text-sm"
                          style="color:#333333; background:#f5f5f5; border:1px solid #e5e7eb; padding:4px 12px; border-radius:6px;">
                        #{{ $pesanan['no_order'] }}
                    </span>
                    <span class="status-badge status-{{ $pesanan['status'] }}">
                        @switch($pesanan['status'])
                            @case('dikirim')  <i class="fas fa-truck" style="font-size:9px;"></i> Dikirim   @break
                            @case('selesai')  <i class="fas fa-check-circle" style="font-size:9px;"></i> Selesai  @break
                            @case('diproses') <i class="fas fa-clock" style="font-size:9px;"></i> Diproses @break
                        @endswitch
                    </span>
                </div>
                <p class="text-xs" style="color:#6b7280;">
                    <i class="fas fa-calendar-alt mr-1.5" style="font-size:9px;"></i>{{ $pesanan['tanggal'] }}
                </p>
            </div>
            <a href="{{ route('riwayat') }}" class="btn-back self-start">
                <i class="fas fa-arrow-left" style="font-size:11px;"></i> Kembali
            </a>
        </div>

        {{-- ── 2 Kolom ── --}}
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ══════════════════════════════════════ --}}
            {{-- KIRI — Detail Produk                   --}}
            {{-- ══════════════════════════════════════ --}}
            <div class="w-full lg:w-[60%]">

                {{-- ─ Produk ─ --}}
                <div class="detail-card">
                    <div class="detail-card-header">
                        <div class="flex items-center">
                            <span class="card-icon-num"><i class="fas fa-box" style="font-size:9px;"></i></span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Produk yang Dipesan</span>
                        </div>
                        <span class="text-xs" style="color:#6b7280;">{{ count($pesanan['items']) }} item</span>
                    </div>
                    <div class="detail-card-body">
                        @foreach($pesanan['items'] as $item)
                        <div class="item-row">
                            <div class="item-thumb">
                                <img src="https://via.placeholder.com/64x64/f5f5f5/6b7280?text=P"
                                     alt="{{ $item['nama'] }}"
                                     onerror="this.src='https://via.placeholder.com/64x64/f5f5f5/6b7280?text=P'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-montserrat font-semibold text-[#1a1a1a] text-sm leading-snug">{{ $item['nama'] }}</p>
                                <div class="flex items-center gap-2 mt-1.5">
                                    <span class="text-xs" style="color:#6b7280;">Qty: {{ $item['qty'] }}</span>
                                    <span style="color:#d1d5db;">·</span>
                                    <span class="{{ $item['tipe'] === 'digital' ? 'badge-digital' : 'badge-fisik' }}">
                                        {{ $item['tipe'] === 'digital' ? 'Digital PDF' : 'Fisik' }}
                                    </span>
                                </div>
                                <p class="text-xs mt-1" style="color:#6b7280;">
                                    Rp {{ number_format($item['harga'], 0, ',', '.') }} / pcs
                                </p>
                            </div>
                            <div class="shrink-0 text-right">
                                <div class="font-montserrat font-bold" style="color:#1a1a1a; font-size:15px;">
                                    Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                </div>
                                @if($item['qty'] > 1)
                                <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $item['qty'] }} × Rp {{ number_format($item['harga'], 0, ',', '.') }}</div>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- ─ Alamat Pengiriman ─ --}}
                @if($pesanan['tipe'] === 'fisik')
                <div class="detail-card">
                    <div class="detail-card-header">
                        <div class="flex items-center">
                            <span class="card-icon-num"><i class="fas fa-map-marker-alt" style="font-size:9px;"></i></span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Alamat Pengiriman</span>
                        </div>
                        <span class="text-xs px-2 py-1 rounded-md"
                              style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280;">
                            <i class="fas fa-home mr-1" style="font-size:9px;"></i>Workshop / Studio
                        </span>
                    </div>
                    <div class="detail-card-body" style="background:#faf8f5;">
                        <div class="info-row">
                            <span style="color:#6b7280;">Nama Penerima</span>
                            <span class="font-semibold text-right text-sm" style="color:#1a1a1a;">{{ $pesanan['alamat']['nama'] }}</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">No. HP</span>
                            <span class="text-sm text-right" style="color:#1a1a1a;">{{ $pesanan['alamat']['hp'] }}</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280; flex-shrink:0;">Alamat</span>
                            <span class="text-sm text-right leading-relaxed" style="color:#333333;">{{ $pesanan['alamat']['detail'] }}</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">Kota / Kecamatan</span>
                            <span class="text-sm text-right" style="color:#1a1a1a;">{{ $pesanan['alamat']['kota'] }}</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">Kode Pos</span>
                            <span class="text-sm" style="color:#1a1a1a;">{{ $pesanan['alamat']['kodepos'] }}</span>
                        </div>
                    </div>
                </div>

                {{-- ─ Info Pengiriman ─ --}}
                <div class="detail-card">
                    <div class="detail-card-header">
                        <div class="flex items-center">
                            <span class="card-icon-num"><i class="fas fa-truck" style="font-size:9px;"></i></span>
                            <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Info Pengiriman</span>
                        </div>
                        <span class="status-badge status-dikirim" style="font-size:10px;">
                            <i class="fas fa-truck" style="font-size:8px;"></i> Dalam Perjalanan
                        </span>
                    </div>
                    <div class="detail-card-body">
                        <div class="info-row">
                            <span style="color:#6b7280;">Kurir</span>
                            <span class="font-semibold text-sm" style="color:#1a1a1a;">{{ $pesanan['kurir'] }}</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">Estimasi</span>
                            <span class="text-sm" style="color:#1a1a1a;">2–3 hari kerja</span>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">No. Resi</span>
                            <div class="text-right">
                                @if($pesanan['no_resi'])
                                <div class="resi-pill">
                                    <i class="fas fa-barcode" style="font-size:10px;"></i>
                                    {{ $pesanan['no_resi'] }}
                                </div>
                                @else
                                <span class="text-sm" style="color:#6b7280;">Belum tersedia</span>
                                @endif
                            </div>
                        </div>
                        <div class="info-row">
                            <span style="color:#6b7280;">Packaging</span>
                            <span class="text-sm" style="color:#333333;">Hard Tube Silinder · Tahan Air</span>
                        </div>

                        @if($pesanan['no_resi'])
                        <div class="mt-4">
                            <a href="#" class="btn-primary-sm gap-2" style="width:fit-content;">
                                <i class="fas fa-map-marker-alt" style="font-size:11px;"></i>
                                Lacak Paket di JNE
                                <i class="fas fa-external-link-alt" style="font-size:10px; opacity:0.7;"></i>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

            </div>

            {{-- ══════════════════════════════════════ --}}
            {{-- KANAN — Ringkasan + Timeline           --}}
            {{-- ══════════════════════════════════════ --}}
            <div class="w-full lg:w-[40%]">
                <div class="summary-sticky">

                    {{-- ─ Ringkasan Pembayaran ─ --}}
                    <div class="summary-card">
                        <div class="summary-card-header">
                            <div class="flex items-center justify-between">
                                <h3 class="font-montserrat font-bold text-[#1a1a1a] text-sm uppercase tracking-wide">
                                    Ringkasan Pembayaran
                                </h3>
                                <span class="status-badge status-lunas" style="font-size:10px;">
                                    <i class="fas fa-check" style="font-size:8px;"></i> Lunas
                                </span>
                            </div>
                        </div>
                        <div class="summary-card-body">
                            <div class="sum-row">
                                <span style="color:#6b7280;">Subtotal</span>
                                <span class="font-medium" style="color:#1a1a1a;">Rp {{ number_format($pesanan['subtotal'], 0, ',', '.') }}</span>
                            </div>
                            <div class="sum-row">
                                <span style="color:#6b7280;">Ongkos Kirim</span>
                                @if($pesanan['ongkir'] === 0)
                                    <span style="color:#16a34a; font-weight:600; font-size:12px;">Gratis</span>
                                @else
                                    <span class="font-medium" style="color:#1a1a1a;">Rp {{ number_format($pesanan['ongkir'], 0, ',', '.') }}</span>
                                @endif
                            </div>
                            @if($pesanan['diskon'] > 0)
                            <div class="sum-row">
                                <span style="color:#6b7280;">Diskon</span>
                                <span style="color:#16a34a; font-weight:600;">−Rp {{ number_format($pesanan['diskon'], 0, ',', '.') }}</span>
                            </div>
                            @endif
                            <div class="sum-row">
                                <span style="color:#6b7280;">Metode Pembayaran</span>
                                <span class="text-sm flex items-center gap-1.5" style="color:#1a1a1a;">
                                    <i class="fas fa-qrcode" style="color:#333333; font-size:11px;"></i>
                                    {{ $pesanan['metode'] }}
                                </span>
                            </div>

                            <div class="flex justify-between items-baseline pt-4 mt-1"
                                 style="border-top:1px solid #e5e7eb;">
                                <span class="font-montserrat font-bold text-[#1a1a1a] text-base">Total</span>
                                <span class="font-montserrat font-bold" style="color:#1a1a1a; font-size:1.5rem;">
                                    Rp {{ number_format($pesanan['total'], 0, ',', '.') }}
                                </span>
                            </div>

                            <div class="mt-5 flex gap-2">
                                <a href="#" class="btn-outline-sm flex-1 justify-center">
                                    <i class="fas fa-file-invoice" style="font-size:11px;"></i>
                                    Download Invoice
                                </a>
                                <a href="#" class="btn-outline-sm flex-1 justify-center">
                                    <i class="fas fa-share-alt" style="font-size:11px;"></i>
                                    Bagikan
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- ─ Timeline Pesanan ─ --}}
                    <div class="detail-card" style="border-color:#e5e7eb;">
                        <div class="detail-card-header">
                            <div class="flex items-center">
                                <span class="card-icon-num"><i class="fas fa-history" style="font-size:9px;"></i></span>
                                <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm">Timeline Pesanan</span>
                            </div>
                        </div>
                        <div class="detail-card-body">
                            @foreach($timeline as $tl)
                            <div class="timeline-item">
                                <div class="timeline-dot {{ $tl['active'] ? 'active' : ($tl['done'] ? 'done' : '') }}">
                                    @if($tl['active'])
                                        <i class="fas fa-truck" style="font-size:10px; color:#ffffff;"></i>
                                    @elseif($tl['done'])
                                        <i class="fas fa-check" style="font-size:9px; color:#6b7280;"></i>
                                    @else
                                        <i class="fas fa-circle" style="font-size:6px; color:#d1d5db;"></i>
                                    @endif
                                </div>
                                <div class="flex-1 pt-0.5">
                                    <div class="flex items-start justify-between gap-2">
                                        <p class="text-sm font-semibold"
                                           style="{{ $tl['active'] ? 'color:#1a1a1a;' : ($tl['done'] ? 'color:#333333;' : 'color:#9ca3af;') }}">
                                            {{ $tl['label'] }}
                                        </p>
                                        <span class="text-xs shrink-0"
                                              style="{{ $tl['active'] ? 'color:#333333;' : ($tl['done'] ? 'color:#6b7280;' : 'color:#d1d5db;') }}">
                                            {{ $tl['time'] }}
                                        </span>
                                    </div>
                                    <p class="text-xs mt-1 leading-relaxed"
                                       style="{{ $tl['active'] ? 'color:#6b7280;' : ($tl['done'] ? 'color:#6b7280;' : 'color:#d1d5db;') }}">
                                        {{ $tl['desc'] }}
                                    </p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ─ Aksi ─ --}}
                    <div class="flex flex-col gap-2">
                        @if($pesanan['status'] === 'dikirim')
                        <a href="#" class="btn-primary-sm w-full justify-center" style="padding:11px 24px;">
                            <i class="fas fa-map-marker-alt" style="font-size:11px;"></i>
                            Lacak Pesanan
                        </a>
                        @endif
                        <a href="{{ route('riwayat') }}" class="btn-outline-sm w-full justify-center">
                            <i class="fas fa-arrow-left" style="font-size:10px;"></i>
                            Kembali ke Daftar Pesanan
                        </a>
                        <a href="{{ route('katalog') }}" class="btn-outline-sm w-full justify-center">
                            <i class="fas fa-store" style="font-size:10px;"></i>
                            Beli Lagi
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
