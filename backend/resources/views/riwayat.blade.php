@extends('layouts.app')

@section('title', 'Pesanan Saya - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Riwayat Page ── */

    /* Tab Filter */
    .tab-nav {
        display: flex;
        gap: 0;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 24px;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .tab-nav::-webkit-scrollbar { display: none; }

    .tab-btn {
        padding: 10px 18px;
        font-size: 13px;
        font-weight: 500;
        font-family: 'Inter', sans-serif;
        color: #6b7280;
        background: transparent;
        border: none;
        border-bottom: 2px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        white-space: nowrap;
        position: relative;
        bottom: -1px;
    }
    .tab-btn:hover { color: #1a1a1a; }
    .tab-btn.active {
        color: #1a1a1a;
        border-bottom-color: #1a1a1a;
        font-weight: 600;
    }

    .tab-count {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 18px;
        height: 18px;
        padding: 0 5px;
        border-radius: 9px;
        background: #e5e7eb;
        color: #6b7280;
        font-size: 10px;
        font-weight: 700;
        margin-left: 6px;
    }
    .tab-btn.active .tab-count {
        background: #1a1a1a;
        color: #ffffff;
    }

    /* Order Card */
    .order-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        margin-bottom: 16px;
        overflow: hidden;
        transition: border-color 0.2s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .order-card:hover { border-color: #333333; }

    .order-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 14px 20px;
        border-bottom: 1px solid #e5e7eb;
        flex-wrap: wrap;
        gap: 8px;
        background: #faf8f5;
    }
    .order-card-body { padding: 16px 20px; }
    .order-card-footer {
        padding: 12px 20px;
        border-top: 1px solid #e5e7eb;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
        background: #faf8f5;
    }

    /* Status badges */
    .status-badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 4px 10px; border-radius: 20px;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.04em;
    }
    .status-badge::before {
        content: ''; width: 5px; height: 5px; border-radius: 50%;
    }
    .status-diproses {
        background: rgba(234,179,8,0.1);
        border: 1px solid rgba(234,179,8,0.3);
        color: #b45309;
    }
    .status-diproses::before { background: #d97706; }

    .status-dikirim {
        background: rgba(59,130,246,0.1);
        border: 1px solid rgba(59,130,246,0.3);
        color: #1d4ed8;
    }
    .status-dikirim::before { background: #3b82f6; }

    .status-selesai {
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.3);
        color: #15803d;
    }
    .status-selesai::before { background: #16a34a; }

    .status-dibatalkan {
        background: rgba(239,68,68,0.1);
        border: 1px solid rgba(239,68,68,0.3);
        color: #dc2626;
    }
    .status-dibatalkan::before { background: #ef4444; }

    /* Product row in card */
    .prod-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .prod-row:last-child { border-bottom: none; }

    .prod-thumb {
        width: 52px; height: 52px;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        flex-shrink: 0;
    }
    .prod-thumb img { width: 100%; height: 100%; object-fit: cover; }

    /* Resi / info bar */
    .resi-bar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 6px;
        background: rgba(59,130,246,0.06);
        border: 1px solid rgba(59,130,246,0.15);
        font-size: 11px; color: #1d4ed8;
        margin-top: 6px;
    }
    .download-bar {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 10px; border-radius: 6px;
        background: rgba(22,163,74,0.06);
        border: 1px solid rgba(22,163,74,0.15);
        font-size: 11px; color: #16a34a;
        margin-top: 6px;
        cursor: pointer;
        transition: background 0.2s;
    }
    .download-bar:hover { background: rgba(22,163,74,0.12); }

    /* Buttons */
    .btn-sm-outline {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: #ffffff;
        border: 1px solid #333333;
        border-radius: 7px;
        color: #333333;
        font-size: 12px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-sm-outline:hover { background: #f5f5f5; border-color: #1a1a1a; color: #1a1a1a; }

    .btn-sm-primary {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: #1a1a1a;
        border: none;
        border-radius: 7px;
        color: #ffffff;
        font-size: 12px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-sm-primary:hover {
        background: #333333;
        box-shadow: 0 2px 8px rgba(26,26,26,0.2);
        transform: translateY(-1px);
    }

    .btn-sm-blue {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 7px 14px;
        background: rgba(59,130,246,0.08);
        border: 1px solid rgba(59,130,246,0.25);
        border-radius: 7px;
        color: #1d4ed8;
        font-size: 12px; font-weight: 500;
        font-family: 'Inter', sans-serif;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
        white-space: nowrap;
    }
    .btn-sm-blue:hover { background: rgba(59,130,246,0.15); border-color: #3b82f6; }

    /* Type badge */
    .badge-fisik {
        font-size: 9px; font-weight: 700;
        padding: 2px 6px; border-radius: 4px;
        background: rgba(168,85,247,0.08);
        border: 1px solid rgba(168,85,247,0.2);
        color: #7c3aed;
        letter-spacing: 0.04em; text-transform: uppercase;
    }
    .badge-digital {
        font-size: 9px; font-weight: 700;
        padding: 2px 6px; border-radius: 4px;
        background: rgba(51,51,51,0.07);
        border: 1px solid rgba(51,51,51,0.15);
        color: #333333;
        letter-spacing: 0.04em; text-transform: uppercase;
    }

    /* Search input */
    .search-order {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        padding: 9px 14px 9px 36px;
        outline: none;
        width: 100%;
        max-width: 280px;
        transition: border-color 0.2s;
    }
    .search-order:focus { border-color: #1a1a1a; }
    .search-order::placeholder { color: #9ca3af; }

    /* Empty state */
    .empty-icon-wrap {
        width: 90px; height: 90px; border-radius: 50%;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 20px;
    }

    /* Stats bar */
    .stat-pill {
        display: flex; align-items: center; gap: 8px;
        padding: 10px 16px; border-radius: 10px;
        background: #ffffff;
        border: 1px solid #e5e7eb;
        transition: border-color 0.2s;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .stat-pill:hover { border-color: #d1d5db; }

    /* Breadcrumb */
    .bc-sep { color: #d1d5db; margin: 0 6px; font-size: 9px; }
</style>
@endsection

@section('content')
@php
// ── Data statis pesanan ──
$pesanan = [
    [
        'id'       => 1,
        'no_order' => 'ORD-20260928-001',
        'tanggal'  => '28 Sep 2026 · 10:05 WIB',
        'status'   => 'dikirim',
        'tipe'     => 'fisik',
        'kurir'    => 'JNE Reguler',
        'no_resi'  => 'JNE123456789',
        'items'    => [
            ['nama' => 'Pola Kemeja Pria Slim Fit',      'tipe' => 'fisik',   'qty' => 1, 'harga' => 75000],
            ['nama' => 'Pola Gaun Pesta Malam',          'tipe' => 'fisik',   'qty' => 2, 'harga' => 150000],
        ],
        'subtotal' => 375000,
        'ongkir'   => 15000,
        'total'    => 390000,
        'metode'   => 'QRIS',
    ],
    [
        'id'       => 2,
        'no_order' => 'ORD-20260928-002',
        'tanggal'  => '28 Sep 2026 · 11:30 WIB',
        'status'   => 'selesai',
        'tipe'     => 'digital',
        'kurir'    => null,
        'no_resi'  => null,
        'items'    => [
            ['nama' => 'Pola Celana Chino Tapered Fit',  'tipe' => 'digital', 'qty' => 1, 'harga' => 55000],
            ['nama' => 'Pola Kemeja Flannel Slim Oxford', 'tipe' => 'digital', 'qty' => 1, 'harga' => 65000],
        ],
        'subtotal' => 120000,
        'ongkir'   => 0,
        'total'    => 120000,
        'metode'   => 'QRIS',
    ],
    [
        'id'       => 3,
        'no_order' => 'ORD-20260927-014',
        'tanggal'  => '27 Sep 2026 · 09:15 WIB',
        'status'   => 'diproses',
        'tipe'     => 'fisik',
        'kurir'    => 'SiCepat BEST',
        'no_resi'  => null,
        'items'    => [
            ['nama' => 'Pola Gaun Pesta A-Line Merah',   'tipe' => 'fisik',   'qty' => 1, 'harga' => 85000],
        ],
        'subtotal' => 85000,
        'ongkir'   => 28000,
        'total'    => 113000,
        'metode'   => 'Transfer Bank',
    ],
    [
        'id'       => 4,
        'no_order' => 'ORD-20260926-033',
        'tanggal'  => '26 Sep 2026 · 16:44 WIB',
        'status'   => 'dibatalkan',
        'tipe'     => 'digital',
        'kurir'    => null,
        'no_resi'  => null,
        'items'    => [
            ['nama' => 'Pola Kemeja Pria Slim Fit Oxford','tipe' => 'digital', 'qty' => 1, 'harga' => 75000],
        ],
        'subtotal' => 75000,
        'ongkir'   => 0,
        'total'    => 75000,
        'metode'   => 'QRIS',
    ],
];

$counts = [
    'semua'       => count($pesanan),
    'diproses'    => collect($pesanan)->where('status','diproses')->count(),
    'dikirim'     => collect($pesanan)->where('status','dikirim')->count(),
    'selesai'     => collect($pesanan)->where('status','selesai')->count(),
    'dibatalkan'  => collect($pesanan)->where('status','dibatalkan')->count(),
];

$isEmpty = false;
@endphp

<div class="min-h-screen" style="background:#faf8f5;"
     x-data="{ activeTab: 'semua' }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- ── Breadcrumb ── --}}
        <div class="flex items-center text-xs mb-5" style="color:#6b7280;">
            <a href="{{ route('home') }}" style="color:#6b7280;" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
            <span class="bc-sep"><i class="fas fa-chevron-right" style="font-size:8px;"></i></span>
            <span style="color:#1a1a1a;">Pesanan Saya</span>
        </div>

        {{-- ── Header ── --}}
        <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-8">
            <div>
                <h1 class="font-montserrat font-bold text-[#1a1a1a] text-3xl tracking-tight">Pesanan Saya</h1>
                <p class="mt-1.5 text-sm" style="color:#6b7280;">
                    Kelola dan pantau semua transaksi pola jahit kamu di sini. Total
                    <span style="color:#1a1a1a; font-weight:600;">{{ $counts['semua'] }}</span> pesanan.
                </p>
            </div>
            <div class="relative shrink-0">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b7280; font-size:11px;"></i>
                <input type="text" placeholder="Cari no. order / produk..." class="search-order">
            </div>
        </div>

        {{-- ── Stats Pills ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-7">
            <div class="stat-pill">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                     style="background:rgba(234,179,8,0.1); border:1px solid rgba(234,179,8,0.2);">
                    <i class="fas fa-clock" style="color:#d97706; font-size:12px;"></i>
                </div>
                <div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $counts['diproses'] }}</div>
                    <div class="text-xs mt-0.5" style="color:#6b7280;">Diproses</div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                     style="background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.2);">
                    <i class="fas fa-truck" style="color:#3b82f6; font-size:12px;"></i>
                </div>
                <div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $counts['dikirim'] }}</div>
                    <div class="text-xs mt-0.5" style="color:#6b7280;">Dikirim</div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                     style="background:rgba(22,163,74,0.1); border:1px solid rgba(22,163,74,0.2);">
                    <i class="fas fa-check-circle" style="color:#16a34a; font-size:12px;"></i>
                </div>
                <div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $counts['selesai'] }}</div>
                    <div class="text-xs mt-0.5" style="color:#6b7280;">Selesai</div>
                </div>
            </div>
            <div class="stat-pill">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                     style="background:rgba(239,68,68,0.1); border:1px solid rgba(239,68,68,0.2);">
                    <i class="fas fa-times-circle" style="color:#ef4444; font-size:12px;"></i>
                </div>
                <div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $counts['dibatalkan'] }}</div>
                    <div class="text-xs mt-0.5" style="color:#6b7280;">Dibatalkan</div>
                </div>
            </div>
        </div>

        {{-- ── Tab Filter ── --}}
        <div class="tab-nav">
            @foreach([
                ['key' => 'semua',      'label' => 'Semua'],
                ['key' => 'diproses',   'label' => 'Diproses'],
                ['key' => 'dikirim',    'label' => 'Dikirim'],
                ['key' => 'selesai',    'label' => 'Selesai'],
                ['key' => 'dibatalkan', 'label' => 'Dibatalkan'],
            ] as $tab)
            <button class="tab-btn" :class="activeTab === '{{ $tab['key'] }}' ? 'active' : ''"
                    @click="activeTab = '{{ $tab['key'] }}'">
                {{ $tab['label'] }}
                <span class="tab-count">{{ $counts[$tab['key']] }}</span>
            </button>
            @endforeach
        </div>

        {{-- ── 2 Kolom ── --}}
        <div class="flex flex-col lg:flex-row gap-6 items-start">

            {{-- ════════════════════════════════════════ --}}
            {{-- KIRI — List Pesanan                      --}}
            {{-- ════════════════════════════════════════ --}}
            <div class="w-full lg:w-[65%]">

                @if($isEmpty)
                <div class="flex flex-col items-center justify-center py-20 text-center"
                     style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px;">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-box-open" style="font-size:32px; color:#6b7280;"></i>
                    </div>
                    <h3 class="font-montserrat font-bold text-[#1a1a1a] text-xl mb-2">Belum ada pesanan</h3>
                    <p class="text-sm max-w-xs leading-relaxed mb-6" style="color:#6b7280;">
                        Yuk, mulai belanja pola jahit berkualitas dan temukan koleksi favoritmu.
                    </p>
                    <a href="{{ route('katalog') }}" class="btn-sm-primary px-6 py-2.5 text-sm gap-2">
                        <i class="fas fa-store" style="font-size:11px;"></i> Mulai Belanja
                    </a>
                </div>

                @else

                @foreach($pesanan as $p)
                <div x-show="activeTab === 'semua' || activeTab === '{{ $p['status'] }}'"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="order-card">

                    {{-- Header --}}
                    <div class="order-card-header">
                        <div>
                            <div class="flex items-center gap-3 flex-wrap">
                                <span class="font-montserrat font-bold text-[#1a1a1a] text-sm tracking-wide">
                                    #{{ $p['no_order'] }}
                                </span>
                                @if($p['tipe'] === 'digital')
                                    <span class="badge-digital"><i class="fas fa-file-pdf" style="font-size:8px; margin-right:3px;"></i>Digital</span>
                                @else
                                    <span class="badge-fisik"><i class="fas fa-box" style="font-size:8px; margin-right:3px;"></i>Fisik</span>
                                @endif
                            </div>
                            <div class="text-xs mt-1" style="color:#6b7280;">
                                <i class="fas fa-calendar-alt mr-1.5" style="font-size:9px;"></i>{{ $p['tanggal'] }}
                            </div>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="status-badge status-{{ $p['status'] }}">
                                @switch($p['status'])
                                    @case('diproses')   <i class="fas fa-clock" style="font-size:9px;"></i> Diproses @break
                                    @case('dikirim')    <i class="fas fa-truck" style="font-size:9px;"></i> Dikirim @break
                                    @case('selesai')    <i class="fas fa-check-circle" style="font-size:9px;"></i> Selesai @break
                                    @case('dibatalkan') <i class="fas fa-times-circle" style="font-size:9px;"></i> Dibatalkan @break
                                @endswitch
                            </span>
                        </div>
                    </div>

                    {{-- Body --}}
                    <div class="order-card-body">

                        @if($p['status'] === 'dikirim' && $p['no_resi'])
                        <div class="mb-3 p-3 rounded-lg flex items-start gap-2.5"
                             style="background:rgba(59,130,246,0.05); border:1px solid rgba(59,130,246,0.15);">
                            <i class="fas fa-truck mt-0.5 shrink-0" style="color:#3b82f6; font-size:11px;"></i>
                            <div>
                                <p class="text-xs font-semibold" style="color:#1d4ed8;">Paket sedang dalam perjalanan</p>
                                <p class="text-xs mt-0.5" style="color:#6b7280;">
                                    {{ $p['kurir'] }} · No. Resi: <span style="color:#2563eb; font-weight:600;">{{ $p['no_resi'] }}</span>
                                </p>
                            </div>
                        </div>
                        @endif

                        @if($p['status'] === 'selesai' && $p['tipe'] === 'digital')
                        <div class="mb-3 p-3 rounded-lg flex items-start gap-2.5"
                             style="background:rgba(22,163,74,0.05); border:1px solid rgba(22,163,74,0.15);">
                            <i class="fas fa-check-circle mt-0.5 shrink-0" style="color:#16a34a; font-size:11px;"></i>
                            <p class="text-xs" style="color:#15803d;">
                                File PDF sudah tersedia. Download ulang tersedia kapan saja dari halaman akun.
                            </p>
                        </div>
                        @endif

                        @foreach($p['items'] as $item)
                        <div class="prod-row">
                            <div class="prod-thumb">
                                <img src="https://via.placeholder.com/52x52/f5f5f5/6b7280?text=P"
                                     alt="{{ $item['nama'] }}"
                                     onerror="this.src='https://via.placeholder.com/52x52/f5f5f5/6b7280?text=P'">
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-semibold text-[#1a1a1a] leading-snug truncate">{{ $item['nama'] }}</p>
                                <div class="flex items-center gap-2 mt-1">
                                    <span class="text-xs" style="color:#6b7280;">Qty: {{ $item['qty'] }}</span>
                                    <span style="color:#d1d5db;">·</span>
                                    <span class="{{ $item['tipe'] === 'digital' ? 'badge-digital' : 'badge-fisik' }}" style="font-size:8px;">
                                        {{ $item['tipe'] === 'digital' ? 'PDF' : 'Fisik' }}
                                    </span>
                                </div>
                                @if($p['tipe'] === 'digital' && $p['status'] === 'selesai')
                                <div class="download-bar mt-1.5">
                                    <i class="fas fa-download" style="font-size:9px;"></i>
                                    Download Ulang File PDF
                                </div>
                                @endif
                            </div>
                            <div class="shrink-0 text-right">
                                <div class="text-sm font-semibold" style="color:#1a1a1a;">
                                    Rp {{ number_format($item['harga'] * $item['qty'], 0, ',', '.') }}
                                </div>
                                <div class="text-xs mt-0.5" style="color:#6b7280;">
                                    @if($item['qty'] > 1) Rp {{ number_format($item['harga'], 0, ',', '.') }}/pcs @endif
                                </div>
                            </div>
                        </div>
                        @endforeach

                        @if($p['tipe'] === 'fisik' && $p['kurir'])
                        <div class="mt-3 flex items-center gap-2 text-xs" style="color:#6b7280;">
                            <i class="fas fa-shipping-fast" style="color:#6b7280; font-size:11px;"></i>
                            <span>Kurir: <span style="color:#1a1a1a;">{{ $p['kurir'] }}</span></span>
                            @if($p['no_resi'])
                            <span style="color:#d1d5db;">·</span>
                            <span>Resi: <span style="color:#2563eb;">{{ $p['no_resi'] }}</span></span>
                            @else
                            <span style="color:#d1d5db;">·</span>
                            <span style="color:#9ca3af;">Resi belum tersedia</span>
                            @endif
                        </div>
                        @endif
                    </div>

                    {{-- Footer --}}
                    <div class="order-card-footer">
                        <div>
                            <div class="text-xs mb-0.5" style="color:#6b7280;">Total Pembayaran</div>
                            <div class="font-montserrat font-bold" style="color:#1a1a1a; font-size:18px;">
                                Rp {{ number_format($p['total'], 0, ',', '.') }}
                            </div>
                            <div class="text-xs mt-0.5" style="color:#6b7280;">
                                via {{ $p['metode'] }}
                                @if($p['ongkir'] > 0) · Ongkir Rp {{ number_format($p['ongkir'], 0, ',', '.') }} @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-2 flex-wrap justify-end">
                            @if($p['status'] === 'dikirim')
                            <a href="#" class="btn-sm-blue">
                                <i class="fas fa-map-marker-alt" style="font-size:10px;"></i> Lacak Pesanan
                            </a>
                            @endif
                            @if($p['status'] === 'dibatalkan')
                            <a href="{{ route('katalog') }}" class="btn-sm-outline">
                                <i class="fas fa-redo" style="font-size:10px;"></i> Beli Lagi
                            </a>
                            @endif
                            <a href="{{ route('riwayat.detail', $p['id']) }}" class="btn-sm-outline">
                                <i class="fas fa-eye" style="font-size:10px;"></i> Lihat Detail
                            </a>
                        </div>
                    </div>

                </div>
                @endforeach

                <div x-show="activeTab !== 'semua' && {{ json_encode($pesanan) }}.filter(p => p.status === activeTab).length === 0"
                     class="flex flex-col items-center justify-center py-16 text-center"
                     style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px;">
                    <div class="empty-icon-wrap">
                        <i class="fas fa-inbox" style="font-size:28px; color:#6b7280;"></i>
                    </div>
                    <p class="font-montserrat font-semibold text-[#1a1a1a] text-base mb-1">Tidak ada pesanan</p>
                    <p class="text-xs" style="color:#6b7280;">Belum ada pesanan dengan status ini.</p>
                </div>

                @endif
            </div>

            {{-- ════════════════════════════════════════ --}}
            {{-- KANAN — Info / Promo                     --}}
            {{-- ════════════════════════════════════════ --}}
            <div class="w-full lg:w-[35%]">
                <div style="position: sticky; top: 80px;">

                    {{-- Panduan Status --}}
                    <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:14px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                        <h3 class="font-montserrat font-semibold text-[#1a1a1a] text-sm uppercase tracking-wide mb-4">
                            <i class="fas fa-info-circle mr-2" style="color:#6b7280; font-size:11px;"></i>
                            Panduan Status Pesanan
                        </h3>
                        @foreach([
                            ['status'=>'Diproses',   'color'=>'#d97706', 'icon'=>'fa-clock',        'desc'=>'Pesanan diterima & sedang disiapkan oleh tim kami.'],
                            ['status'=>'Dikirim',    'color'=>'#3b82f6', 'icon'=>'fa-truck',        'desc'=>'Paket dalam perjalanan ke alamat kamu.'],
                            ['status'=>'Selesai',    'color'=>'#16a34a', 'icon'=>'fa-check-circle', 'desc'=>'Pesanan sudah diterima / file sudah bisa didownload.'],
                            ['status'=>'Dibatalkan', 'color'=>'#ef4444', 'icon'=>'fa-times-circle', 'desc'=>'Pesanan dibatalkan. Refund diproses dalam 1×3 hari kerja.'],
                        ] as $s)
                        <div class="flex items-start gap-3 mb-3 last:mb-0">
                            <div class="w-7 h-7 rounded-full flex items-center justify-center shrink-0 mt-0.5"
                                 style="background:{{ $s['color'] }}18; border:1px solid {{ $s['color'] }}35;">
                                <i class="fas {{ $s['icon'] }}" style="color:{{ $s['color'] }}; font-size:10px;"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold" style="color:{{ $s['color'] }};">{{ $s['status'] }}</p>
                                <p class="text-xs leading-relaxed mt-0.5" style="color:#6b7280;">{{ $s['desc'] }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    {{-- Butuh Bantuan --}}
                    <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; padding:20px; margin-bottom:14px; box-shadow:0 1px 3px rgba(0,0,0,0.05);">
                        <h3 class="font-montserrat font-semibold text-[#1a1a1a] text-sm uppercase tracking-wide mb-3">
                            <i class="fas fa-headset mr-2" style="color:#6b7280; font-size:11px;"></i>
                            Butuh Bantuan?
                        </h3>
                        <p class="text-xs leading-relaxed mb-4" style="color:#6b7280;">
                            Tim support kami siap membantu kamu setiap hari Senin–Sabtu, pukul 08.00–20.00 WIB.
                        </p>
                        <div class="flex flex-col gap-2">
                            <a href="#" class="btn-sm-outline w-full justify-center gap-2" style="border-color:rgba(34,197,94,0.3); color:#16a34a; background:#f0fdf4;">
                                <i class="fab fa-whatsapp" style="color:#22c55e; font-size:13px;"></i>
                                Chat via WhatsApp
                            </a>
                            <a href="#" class="btn-sm-outline w-full justify-center gap-2">
                                <i class="fas fa-envelope" style="font-size:11px;"></i>
                                Email Support
                            </a>
                        </div>
                    </div>

                    {{-- Promo --}}
                    <div style="background:#fffbeb; border:1px solid rgba(234,179,8,0.25); border-radius:12px; padding:20px;">
                        <div class="flex items-center gap-2 mb-2">
                            <i class="fas fa-star" style="color:#d97706; font-size:12px;"></i>
                            <span class="text-xs font-bold uppercase tracking-wide" style="color:#d97706;">Seminar Pola Garment CAD</span>
                        </div>
                        <p class="text-xs leading-relaxed mb-3" style="color:#6b7280;">
                            Pelajari teknik pola profesional berbasis software CAD. Cocok untuk penjahit studio dan fashion designer.
                        </p>
                        <a href="{{ route('katalog') }}" class="btn-sm-outline w-full justify-center gap-2"
                           style="border-color:rgba(234,179,8,0.3); color:#d97706; background:#fef9c3;">
                            <i class="fas fa-external-link-alt" style="font-size:10px;"></i>
                            Info Selengkapnya
                        </a>
                    </div>

                </div>
            </div>

        </div>

    </div>
</div>
@endsection
