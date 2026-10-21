@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('header-title', 'Dashboard Atelier')

@section('styles')
<style>
    /* ── Dashboard Styles ── */

    /* Stat Card */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.25s ease;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .stat-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }

    .stat-icon {
        width: 40px; height: 40px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-size: 16px;
        flex-shrink: 0;
    }

    .stat-value {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 2rem;
        line-height: 1;
        color: #1a1a1a;
        margin-top: 12px;
    }
    .stat-label {
        font-size: 12px;
        color: #6b7280;
        margin-top: 5px;
    }

    .stat-trend {
        display: inline-flex; align-items: center; gap: 4px;
        font-size: 11px; font-weight: 600;
        padding: 2px 7px; border-radius: 10px;
        margin-top: 8px;
    }
    .trend-up   { background: rgba(22,163,74,0.1);  border:1px solid rgba(22,163,74,0.2);  color: #16a34a; }
    .trend-down { background: rgba(239,68,68,0.1);  border:1px solid rgba(239,68,68,0.2);  color: #dc2626; }
    .trend-warn { background: rgba(234,179,8,0.1);  border:1px solid rgba(234,179,8,0.2);  color: #d97706; }

    /* Chart card */
    .chart-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.04);
    }
    .chart-card-header {
        padding: 18px 22px 14px;
        border-bottom: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        flex-wrap: wrap; gap: 10px;
        background: #faf8f5;
    }

    /* Chart tab */
    .chart-tab {
        padding: 5px 12px;
        border-radius: 6px;
        font-size: 11px; font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        color: #6b7280;
        background: transparent;
        font-family: 'Inter', sans-serif;
    }
    .chart-tab:hover { color: #1a1a1a; }
    .chart-tab.active {
        background: #ffffff;
        border-color: #e5e7eb;
        color: #1a1a1a;
    }

    /* Section header */
    .section-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 16px;
        flex-wrap: wrap; gap: 10px;
    }

    /* Table */
    .admin-table { width: 100%; border-collapse: collapse; }
    .admin-table th {
        text-align: left;
        padding: 10px 14px;
        font-size: 10px;
        font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        background: #f5f5f5;
        white-space: nowrap;
    }
    .admin-table td {
        padding: 12px 14px;
        font-size: 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .admin-table tr:last-child td { border-bottom: none; }
    .admin-table tr:hover td { background: #faf8f5; }

    /* Status badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 12px;
        font-size: 10px; font-weight: 700;
        letter-spacing: 0.04em;
        white-space: nowrap;
    }
    .badge::before { content: ''; width: 5px; height: 5px; border-radius: 50%; flex-shrink: 0; }

    .badge-selesai    { background: rgba(22,163,74,0.1);  border:1px solid rgba(22,163,74,0.25);  color: #15803d; }
    .badge-selesai::before    { background: #16a34a; }
    .badge-diproses   { background: rgba(234,179,8,0.1);  border:1px solid rgba(234,179,8,0.25);  color: #b45309; }
    .badge-diproses::before   { background: #d97706; }
    .badge-dikirim    { background: rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.25); color: #1d4ed8; }
    .badge-dikirim::before    { background: #3b82f6; }
    .badge-dibatalkan { background: rgba(239,68,68,0.1);  border:1px solid rgba(239,68,68,0.25);  color: #dc2626; }
    .badge-dibatalkan::before { background: #ef4444; }
    .badge-pending    { background: rgba(168,85,247,0.1); border:1px solid rgba(168,85,247,0.25); color: #7c3aed; }
    .badge-pending::before    { background: #a855f7; }

    .badge-fisik   { background: rgba(168,85,247,0.08); border:1px solid rgba(168,85,247,0.2); color: #7c3aed; font-size:9px; }
    .badge-digital { background: rgba(51,51,51,0.07);   border:1px solid rgba(51,51,51,0.15);  color: #333333; font-size:9px; }
    .badge-combo   { background: rgba(234,179,8,0.08);  border:1px solid rgba(234,179,8,0.2);  color: #d97706; font-size:9px; }

    /* Table action btns */
    .tbl-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px;
        border-radius: 6px;
        font-size: 11px; font-weight: 500;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        white-space: nowrap;
    }
    .tbl-btn-outline {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        color: #6b7280;
    }
    .tbl-btn-outline:hover { border-color: #1a1a1a; color: #1a1a1a; }

    .tbl-btn-update {
        background: rgba(59,130,246,0.08);
        border: 1px solid rgba(59,130,246,0.2);
        color: #1d4ed8;
    }
    .tbl-btn-update:hover { background: rgba(59,130,246,0.15); }

    /* Metric small */
    .metric-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 12px;
    }
    .metric-row:last-child { border-bottom: none; }

    /* Page tabs */
    .page-tabs {
        display: flex; gap: 4px;
        padding: 4px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
    }
    .page-tab {
        padding: 5px 12px;
        border-radius: 5px;
        font-size: 11px; font-weight: 600;
        cursor: pointer;
        transition: all 0.15s;
        color: #6b7280;
        border: 1px solid transparent;
        background: transparent;
        font-family: 'Inter', sans-serif;
    }
    .page-tab.active {
        background: #ffffff;
        border-color: #e5e7eb;
        color: #1a1a1a;
    }
    .page-tab:hover:not(.active) { color: #1a1a1a; }
</style>
@endsection

@section('content')
@php
$stats = [
    [
        'title'   => 'Total Pesanan Hari Ini',
        'value'   => '48',
        'sub'     => 'Pesanan',
        'icon'    => 'fa-shopping-bag',
        'color'   => '#333333',
        'bg'      => 'rgba(51,51,51,0.07)',
        'border'  => 'rgba(51,51,51,0.15)',
        'trend'   => '+10%',
        'trend_type' => 'up',
        'desc'    => '42 Digital Instan + 6 Pola Fisik',
    ],
    [
        'title'   => 'Pendapatan Hari Ini',
        'value'   => 'Rp 6.840.000',
        'sub'     => '',
        'icon'    => 'fa-coins',
        'color'   => '#16a34a',
        'bg'      => 'rgba(22,163,74,0.1)',
        'border'  => 'rgba(22,163,74,0.2)',
        'trend'   => '+18.4%',
        'trend_type' => 'up',
        'desc'    => 'Bertambah QRIS &amp; VA Otomatis',
    ],
    [
        'title'   => 'Produk Stok Menipis',
        'value'   => '3 SKU',
        'sub'     => '',
        'icon'    => 'fa-exclamation-triangle',
        'color'   => '#d97706',
        'bg'      => 'rgba(234,179,8,0.1)',
        'border'  => 'rgba(234,179,8,0.2)',
        'trend'   => 'Perlu Restock',
        'trend_type' => 'warn',
        'desc'    => 'Kraft 100gsm stok 2 roll, Hartbase 2 roll',
    ],
    [
        'title'   => 'Total Pelanggan',
        'value'   => '3.542',
        'sub'     => '',
        'icon'    => 'fa-users',
        'color'   => '#3b82f6',
        'bg'      => 'rgba(59,130,246,0.1)',
        'border'  => 'rgba(59,130,246,0.2)',
        'trend'   => '+24 bulan ini',
        'trend_type' => 'up',
        'desc'    => '98% Konversi Pelanggan Tinggi',
    ],
];

$chartDays   = ['Sen (29 Sept)', 'Sel (31 Sept)', 'Rab (22 Sept)', 'Kam (23 Sept)', 'Jum (24 Sept)', 'Sab (28 Sept)', 'Min (26 Sept)'];
$chartSales  = [4200000, 3800000, 5100000, 4600000, 6200000, 8240000, 5920000];
$chartTarget = [5000000, 5000000, 5000000, 5000000, 5000000, 5000000, 5000000];

$pesananTerbaru = [
    ['no'=>'FORD-20260928-047','customer'=>'Rian Pratama','workshop'=>'Atelier Riau, Garment, Bandung','tipe'=>'digital','tipe_label'=>'Digital CAD','metode'=>'Rp 95.000','metode_sub'=>'QRIS · Transfer · Lunas','status'=>'selesai','status_label'=>'Selesai (Terkirim)'],
    ['no'=>'FORD-20260928-046','customer'=>'CV Sinar Busana Mandiri','workshop'=>'Surabaya Workshop','tipe'=>'fisik','tipe_label'=>'Cetak Fisik Kraft 100gsm (5 Roll)','metode'=>'Rp 310.000','metode_sub'=>'Account · Lunas','status'=>'diproses','status_label'=>'Sedang Cetak di Mesin Plotter #2'],
    ['no'=>'FORD-20260928-045','customer'=>'Budi Anggraini','workshop'=>'Jakarta Selatan','tipe'=>'combo','tipe_label'=>'Combo (Digital + Fisik Tabung)','metode'=>'Rp 368.000','metode_sub'=>'QRIS Instan','status'=>'diproses','status_label'=>'Packing Hard-Tube Silinder'],
    ['no'=>'FORD-20260928-045','customer'=>'Hendra Wijaya Taller','workshop'=>'Jakarta Selatan, Ciputro Atelier','tipe'=>'digital','tipe_label'=>'Digital CAD (32,000 Pixel)','metode'=>'Rp 120.000','metode_sub'=>'Nomor VA','status'=>'selesai','status_label'=>'Selesai (Terkirim)'],
    ['no'=>'FORD-20260925-044','customer'=>'Koperasi Maju Jaya','workshop'=>'Solo Surakarta','tipe'=>'fisik','tipe_label'=>'Cetak Fisik Kraft 100gsm (33 Pola Bayi Anak)','metode'=>'Rp 1.060.000','metode_sub'=>'Transfer Bank · Verifikasi','status'=>'dikirim','status_label'=>'Siap Kirim JNE Tracking'],
];
@endphp

{{-- ── Welcome Banner ── --}}
<div class="flex items-center justify-between mb-6 flex-wrap gap-3">
    <div>
        <div class="flex items-center gap-2 mb-1">
            <div style="width:6px; height:6px; border-radius:50%; background:#16a34a;"></div>
            <span class="text-xs" style="color:#16a34a; font-weight:600; letter-spacing:0.06em;">ONLINE · ATELIER PARTNER</span>
        </div>
        <p class="text-sm" style="color:#6b7280;">
            Selamat datang, <strong style="color:#1a1a1a;">{{ Auth::user()->name ?? 'Admin' }}</strong>.
            Hari ini ada <span style="color:#1a1a1a; font-weight:600;">{{ collect($pesananTerbaru)->count() }}</span> pesanan masuk yang perlu diproses.
        </p>
    </div>
    <div class="flex items-center gap-2">
        <a href="{{ route('admin.pesanan') }}" class="btn-admin-primary gap-2">
            <i class="fas fa-receipt" style="font-size:11px;"></i>
            Kelola Pesanan
        </a>
        <a href="{{ route('admin.produk') }}" class="btn-admin-outline gap-2">
            <i class="fas fa-plus" style="font-size:10px;"></i>
            Produk Baru
        </a>
    </div>
</div>

{{-- ── 4 Stat Cards ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-6">
    @foreach($stats as $s)
    <div class="stat-card">
        <div class="flex items-start justify-between">
            <div class="stat-icon" style="background:{{ $s['bg'] }}; border:1px solid {{ $s['border'] }};">
                <i class="fas {{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i>
            </div>
            <span class="text-xs" style="color:#9ca3af; letter-spacing:0.05em; text-transform:uppercase;">
                {{ now()->format('d/m') }}
            </span>
        </div>

        <div class="stat-value">{{ $s['value'] }}
            @if($s['sub'])<span class="text-sm font-normal" style="color:#6b7280; margin-left:4px;">{{ $s['sub'] }}</span>@endif
        </div>
        <div class="stat-label">{{ $s['title'] }}</div>

        <div class="flex items-center justify-between mt-2">
            <span class="stat-trend trend-{{ $s['trend_type'] }}">
                <i class="fas {{ $s['trend_type'] === 'up' ? 'fa-arrow-up' : ($s['trend_type'] === 'down' ? 'fa-arrow-down' : 'fa-exclamation') }}" style="font-size:8px;"></i>
                {{ $s['trend'] }}
            </span>
        </div>
        <div class="text-xs mt-1.5 leading-relaxed" style="color:#6b7280;">{!! $s['desc'] !!}</div>
    </div>
    @endforeach
</div>

{{-- ── Chart + Side Metrics ── --}}
<div class="flex flex-col xl:flex-row gap-4 mb-6">

    {{-- Chart (kiri 70%) --}}
    <div class="chart-card" style="flex:1; min-width:0;">
        <div class="chart-card-header">
            <div>
                <h2 class="font-montserrat font-bold text-[#1a1a1a] text-base">Tren Penjualan 7 Hari Terakhir</h2>
                <p class="text-xs mt-0.5" style="color:#6b7280;">
                    <i class="fas fa-bolt mr-1" style="color:#d97706; font-size:9px;"></i>
                    CAD &amp; Plotter Real-Time
                </p>
            </div>
            <div class="flex items-center gap-2 flex-wrap">
                <div class="flex items-center gap-1.5 text-xs" style="color:#6b7280;">
                    <span style="width:20px; height:2px; background:#333333; display:inline-block;"></span> Total Penjualan
                    <span style="width:20px; height:1px; border-top:1px dashed #9ca3af; display:inline-block; margin-left:8px;"></span> Target Harian
                </div>
                <div class="page-tabs" x-data="{ tab: 'nominal' }">
                    <button class="page-tab" :class="tab === 'volume' ? 'active':''" @click="tab='volume'">Volume Pola</button>
                    <button class="page-tab active" :class="tab === 'nominal' ? 'active':''" @click="tab='nominal'">Nominal Rupiah (Aktif)</button>
                </div>
            </div>
        </div>
        <div style="padding:20px;">
            <div style="position:relative; height:260px;">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    {{-- Side Metrics (kanan 30%) --}}
    <div style="width:280px; flex-shrink:0;">
        <div class="chart-card" style="margin-bottom:10px;">
            <div style="padding:16px;">
                <div class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Data-Data Harian</div>
                <div class="font-montserrat font-bold" style="font-size:1.6rem; color:#1a1a1a;">Rp 5.920.000</div>
                <div class="stat-trend trend-up mt-1.5" style="font-size:10px;">
                    <i class="fas fa-arrow-up" style="font-size:8px;"></i> Melampaui Target (+10.2%)
                </div>
                <div class="metric-row mt-4">
                    <span style="color:#6b7280;">Pesanan Masuk</span>
                    <span class="font-semibold" style="color:#1a1a1a;">48</span>
                </div>
                <div class="metric-row">
                    <span style="color:#6b7280;">Digital Terjual</span>
                    <span style="color:#333333; font-weight:600;">32 File</span>
                </div>
                <div class="metric-row">
                    <span style="color:#6b7280;">Fisik Tercetak</span>
                    <span style="color:#7c3aed; font-weight:600;">16 Pola</span>
                </div>
                <div class="metric-row">
                    <span style="color:#6b7280;">Avg. Order</span>
                    <span style="color:#6b7280; font-weight:600;">Rp 142.500</span>
                </div>
            </div>
        </div>

        <div class="chart-card">
            <div style="padding:16px;">
                <div class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Pola Terlaris Menderu Di:</div>
                <div class="flex items-start gap-3 mb-3">
                    <div style="width:36px; height:36px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                        <i class="fas fa-file-pdf" style="color:#333333; font-size:14px;"></i>
                    </div>
                    <div>
                        <div class="text-sm font-semibold text-[#1a1a1a] leading-snug">Blazer Pria Slim-Fit Notch Lapel</div>
                        <div class="text-xs mt-0.5" style="color:#6b7280;">142 unduhan Atelire— CAD</div>
                    </div>
                </div>
                <div class="metric-row">
                    <span style="color:#6b7280;">Kapasitas Mesin Plotter</span>
                </div>
                <div class="flex items-center gap-2 mt-2">
                    <div style="flex:1; height:4px; background:#e5e7eb; border-radius:2px; overflow:hidden;">
                        <div style="width:72%; height:100%; background:#1a1a1a; border-radius:2px;"></div>
                    </div>
                    <span class="text-xs" style="color:#6b7280;">72%</span>
                </div>
                <div class="flex justify-between text-xs mt-1" style="color:#6b7280;">
                    <span>Sedang: 3/4/V</span>
                    <span>Queue: 3/4 Rol</span>
                </div>
            </div>
        </div>
    </div>

</div>

{{-- ── Tabel Pesanan Terbaru ── --}}
<div class="chart-card">
    <div style="padding:16px 20px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:10px; background:#faf8f5;"
         x-data="{ tab: 'semua' }">
        <div class="flex items-center gap-4 flex-wrap">
            <h2 class="font-montserrat font-bold text-[#1a1a1a] text-sm">Pesanan Terbaru</h2>
            <span class="text-xs px-2 py-1 rounded-md" style="background:rgba(22,163,74,0.08); border:1px solid rgba(22,163,74,0.2); color:#15803d;">Antrian Real-time</span>
            <div class="page-tabs">
                <button class="page-tab active" @click="tab='semua'">Semua</button>
                <button class="page-tab" @click="tab='menunggu'">Menunggu Potter</button>
                <button class="page-tab" @click="tab='digital'">Digital Selesai</button>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <button class="btn-admin-outline gap-1.5" style="font-size:11px; padding:6px 12px;">
                <i class="fas fa-download" style="font-size:10px;"></i> Ekspor Data (CSV/Excel)
            </button>
            <a href="{{ route('admin.pesanan') }}" class="btn-admin-primary gap-1.5" style="font-size:11px; padding:6px 12px;">
                <i class="fas fa-list" style="font-size:10px;"></i> Lihat Semua
            </a>
        </div>
    </div>

    <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>NO. ORDER</th>
                    <th>CUSTOMER &amp; WORKSHOP</th>
                    <th>TIPE PRODUK</th>
                    <th>METODE &amp; TOTAL</th>
                    <th>STATUS PESANAN</th>
                    <th>AKSI CEPAT</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pesananTerbaru as $p)
                <tr>
                    <td>
                        <div class="font-montserrat font-bold text-[#1a1a1a]" style="font-size:11px; letter-spacing:0.04em;">{{ $p['no'] }}</div>
                    </td>
                    <td>
                        <div class="font-semibold text-[#1a1a1a] text-xs">{{ $p['customer'] }}</div>
                        <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $p['workshop'] }}</div>
                    </td>
                    <td>
                        <span class="badge {{ $p['tipe'] === 'digital' ? 'badge-digital' : ($p['tipe'] === 'combo' ? 'badge-combo' : 'badge-fisik') }}">
                            <i class="fas {{ $p['tipe'] === 'digital' ? 'fa-file-pdf' : ($p['tipe'] === 'combo' ? 'fa-layer-group' : 'fa-print') }}" style="font-size:8px; margin-right:3px;"></i>
                            {{ $p['tipe_label'] }}
                        </span>
                    </td>
                    <td>
                        <div class="font-montserrat font-bold" style="color:#1a1a1a; font-size:13px;">{{ $p['metode'] }}</div>
                        <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $p['metode_sub'] }}</div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $p['status'] }}">{{ $p['status_label'] }}</span>
                    </td>
                    <td>
                        <div class="flex items-center gap-1.5">
                            @if($p['status'] === 'diproses')
                            <button class="tbl-btn tbl-btn-update">
                                <i class="fas fa-edit" style="font-size:9px;"></i> Update Resi JNE
                            </button>
                            @elseif($p['status'] === 'dikirim')
                            <button class="tbl-btn tbl-btn-update">
                                <i class="fas fa-truck" style="font-size:9px;"></i> Lacak Resi
                            </button>
                            @endif
                            <a href="{{ route('admin.pesanan') }}" class="tbl-btn tbl-btn-outline">
                                <i class="fas fa-eye" style="font-size:9px;"></i> Detail
                            </a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="padding:12px 20px; border-top:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; background:#faf8f5;">
        <span class="text-xs" style="color:#6b7280;">Menampilkan 5 dari 48 pesanan hari ini.</span>
        <div class="flex items-center gap-1">
            <button class="tbl-btn tbl-btn-outline" style="padding:4px 10px;">
                <i class="fas fa-chevron-left" style="font-size:9px;"></i>
            </button>
            @foreach([1,2,3] as $pg)
            <button class="tbl-btn {{ $pg === 1 ? 'tbl-btn-update' : 'tbl-btn-outline' }}" style="padding:4px 9px;">{{ $pg }}</button>
            @endforeach
            <button class="tbl-btn tbl-btn-outline" style="padding:4px 10px;">
                <i class="fas fa-chevron-right" style="font-size:9px;"></i>
            </button>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const ctx = document.getElementById('salesChart');
    if (!ctx) return;

    const labels  = @json($chartDays);
    const sales   = @json($chartSales);
    const targets = @json($chartTarget);

    const gradient = ctx.getContext('2d').createLinearGradient(0, 0, 0, 260);
    gradient.addColorStop(0,   'rgba(26,26,26,0.12)');
    gradient.addColorStop(0.6, 'rgba(26,26,26,0.04)');
    gradient.addColorStop(1,   'rgba(26,26,26,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [
                {
                    label: 'Total Penjualan',
                    data: sales,
                    borderColor: '#1a1a1a',
                    borderWidth: 2,
                    pointBackgroundColor: '#1a1a1a',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 7,
                    fill: true,
                    backgroundColor: gradient,
                    tension: 0.4,
                },
                {
                    label: 'Target Harian',
                    data: targets,
                    borderColor: '#d1d5db',
                    borderWidth: 1.5,
                    borderDash: [6, 4],
                    pointRadius: 0,
                    fill: false,
                    tension: 0,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: { mode: 'index', intersect: false },
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    titleColor: '#1a1a1a',
                    bodyColor: '#6b7280',
                    padding: 10,
                    callbacks: {
                        label: ctx => {
                            const v = ctx.parsed.y;
                            return ' Rp ' + v.toLocaleString('id-ID');
                        }
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f0f0f0', drawBorder: false },
                    ticks: { color: '#6b7280', font: { size: 10, family: 'Inter' } }
                },
                y: {
                    grid: { color: '#f0f0f0', drawBorder: false },
                    ticks: {
                        color: '#6b7280',
                        font: { size: 10, family: 'Inter' },
                        callback: v => 'Rp ' + (v/1000000).toFixed(1) + 'M'
                    }
                }
            }
        }
    });
});
</script>
@endsection
