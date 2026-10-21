@extends('layouts.admin')

@section('title', 'Laporan & Analitik - Admin')
@section('header-title', 'Laporan & Analitik')

@section('styles')
<style>
    /* ── Stat Cards ── */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.2s;
    }
    .stat-card::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 1px;
        background: linear-gradient(90deg, transparent, rgba(0,0,0,0.04), transparent);
    }
    .stat-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        transform: translateY(-1px);
    }
    .stat-num {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        line-height: 1.1;
    }
    .trend-up {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 10px; font-weight: 600;
        color: #22c55e;
        background: rgba(34,197,94,0.08);
        border: 1px solid rgba(34,197,94,0.15);
        padding: 2px 7px; border-radius: 10px;
    }
    .trend-down {
        display: inline-flex; align-items: center; gap: 3px;
        font-size: 10px; font-weight: 600;
        color: #ef4444;
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.15);
        padding: 2px 7px; border-radius: 10px;
    }

    /* ── Filter bar ── */
    .filter-select {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        padding: 8px 28px 8px 12px;
        outline: none;
        transition: border-color 0.2s;
        cursor: pointer;
        appearance: none;
        -webkit-appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M0 0l5 6 5-6z' fill='%236b7280'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
    }
    .filter-select:focus { border-color: #333; color: #1a1a1a; }

    .filter-date-input {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        padding: 8px 12px;
        outline: none;
        transition: border-color 0.2s;
        colorscheme: light;
    }
    .filter-date-input:focus { border-color: #333; color: #1a1a1a; }

    /* ── Section card ── */
    .section-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }
    .section-card-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        background: #faf8f5;
    }
    .section-card-body { padding: 20px; }
    .section-card-title {
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 13px;
        color: #1a1a1a;
    }

    /* ── Table ── */
    .report-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .report-table thead tr { background: #f5f5f5; border-bottom: 1px solid #e5e7eb; }
    .report-table th {
        padding: 10px 14px;
        text-align: left;
        font-size: 10px; font-weight: 700;
        color: #6b7280; letter-spacing: 0.08em; text-transform: uppercase;
        white-space: nowrap;
    }
    .report-table th:first-child { padding-left: 16px; }
    .report-table th:last-child  { padding-right: 16px; }
    .report-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.15s;
    }
    .report-table tbody tr:last-child { border-bottom: none; }
    .report-table tbody tr:hover { background: #f5f5f5; }
    .report-table td {
        padding: 10px 14px;
        color: #1a1a1a;
        vertical-align: middle;
    }
    .report-table td:first-child { padding-left: 16px; }
    .report-table td:last-child  { padding-right: 16px; }

    /* Rank badge */
    .rank-badge {
        display: inline-flex; align-items: center; justify-content: center;
        width: 24px; height: 24px; border-radius: 7px;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 11px;
    }

    /* Progress bar */
    .prog-bar-wrap {
        height: 4px; border-radius: 2px;
        background: #e5e7eb;
        overflow: hidden;
        margin-top: 4px;
    }
    .prog-bar-fill {
        height: 100%; border-radius: 2px;
        transition: width 0.6s ease;
    }

    /* Status badge */
    .badge { display: inline-flex; align-items: center; gap: 4px; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; white-space: nowrap; }
    .badge-selesai  { background: rgba(34,197,94,0.08);  border: 1px solid rgba(34,197,94,0.2);  color: #22c55e; }
    .badge-proses   { background: rgba(234,179,8,0.08);  border: 1px solid rgba(234,179,8,0.2);  color: #eab308; }
    .badge-dikirim  { background: rgba(59,130,246,0.08); border: 1px solid rgba(59,130,246,0.2); color: #3b82f6; }
    .badge-batal    { background: rgba(239,68,68,0.08);  border: 1px solid rgba(239,68,68,0.2);  color: #ef4444; }
    .badge-digital  { background: rgba(51,51,51,0.07);border: 1px solid rgba(51,51,51,0.15);color: #333333;}
    .badge-fisik    { background: rgba(168,85,247,0.08); border: 1px solid rgba(168,85,247,0.2); color: #a855f7; }

    /* Chart container */
    .chart-container { position: relative; }

    /* Donut legend */
    .donut-legend-item {
        display: flex; align-items: center; gap: 8px;
        padding: 6px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 12px;
    }
    .donut-legend-item:last-child { border-bottom: none; }
    .donut-legend-dot {
        width: 10px; height: 10px; border-radius: 3px; flex-shrink: 0;
    }
</style>
@endsection

@section('content')

{{-- ════════════════════════════════════════ --}}
{{-- HEADER                                   --}}
{{-- ════════════════════════════════════════ --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
    <div>
        <h1 class="font-montserrat font-bold text-[#1a1a1a] text-2xl leading-tight">Laporan &amp; Analitik</h1>
        <p class="text-xs mt-1" style="color:#6b7280;">
            <i class="fas fa-chart-line mr-1"></i>
            Ringkasan performa penjualan toko — data diperbarui otomatis
        </p>
    </div>
    <div class="flex items-center gap-2">
        <button class="btn-admin-primary" onclick="alert('Fitur export PDF akan segera tersedia.')">
            <i class="fas fa-file-pdf" style="font-size:10px;"></i>
            Export PDF
        </button>
        <button class="btn-admin-outline" onclick="alert('Fitur export CSV akan segera tersedia.')">
            <i class="fas fa-file-csv" style="font-size:10px;"></i>
            Export CSV
        </button>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- FILTER PERIODE                           --}}
{{-- ════════════════════════════════════════ --}}
<div x-data="{ showCustom: false }"
     style="background:#f5f5f5;border:1px solid #e5e7eb;border-radius:12px;padding:14px 18px;margin-bottom:20px;">
    <div class="flex flex-wrap gap-3 items-end">

        <div>
            <label style="display:block;font-size:10px;font-weight:700;color:#6b7280;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;">Periode</label>
            <select class="filter-select" style="min-width:170px;"
                    @change="showCustom = ($event.target.value === 'custom')">
                <option value="7">7 Hari Terakhir</option>
                <option value="30" selected>30 Hari Terakhir</option>
                <option value="bulan">Bulan Ini</option>
                <option value="tahun">Tahun Ini</option>
                <option value="hari">Hari Ini</option>
                <option value="custom">Custom Range</option>
            </select>
        </div>

        <div x-show="showCustom" x-transition class="flex gap-2 items-end flex-wrap">
            <div>
                <label style="display:block;font-size:10px;font-weight:700;color:#6b7280;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;">Dari</label>
                <input type="date" class="filter-date-input">
            </div>
            <div>
                <label style="display:block;font-size:10px;font-weight:700;color:#6b7280;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;">Sampai</label>
                <input type="date" class="filter-date-input">
            </div>
        </div>

        <button class="btn-admin-outline" style="height:34px;padding:0 16px;white-space:nowrap;">
            <i class="fas fa-filter" style="font-size:10px;"></i>
            Terapkan
        </button>

        {{-- Active filter tag --}}
        <div style="margin-left:auto;display:flex;align-items:center;gap:6px;">
            <span style="font-size:11px;color:#6b7280;">Menampilkan:</span>
            <span style="font-size:11px;font-weight:600;color:#333333;background:rgba(51,51,51,0.06);border:1px solid rgba(51,51,51,0.1);padding:3px 10px;border-radius:10px;">
                <i class="fas fa-calendar-alt mr-1" style="font-size:9px;"></i>
                30 Hari Terakhir
            </span>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- STATISTIK UTAMA (4 CARD)                 --}}
{{-- ════════════════════════════════════════ --}}
<div class="grid grid-cols-2 xl:grid-cols-4 gap-4 mb-6">

    {{-- Total Pendapatan --}}
    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-money-bill-wave" style="color:#22c55e;font-size:14px;"></i>
            </div>
            <span class="trend-up"><i class="fas fa-arrow-up" style="font-size:8px;"></i>+18.4%</span>
        </div>
        <div class="stat-num text-[#1a1a1a]" style="font-size:1.3rem;">Rp 125,4 Jt</div>
        <div style="font-size:11px;color:#555;margin-top:4px;">Total Pendapatan</div>
        <div style="font-size:10px;color:#333;margin-top:2px;">vs Rp 105,9 Jt bulan lalu</div>
        <!-- Mini sparkline bar -->
        <div class="flex items-end gap-0.5 mt-3" style="height:20px;">
            @foreach([40,55,45,60,50,70,65,80,75,90,85,100] as $h)
            <div style="flex:1;background:rgba(34,197,94,0.3);border-radius:1px;height:{{ $h }}%;"></div>
            @endforeach
        </div>
    </div>

    {{-- Total Pesanan --}}
    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-shopping-bag" style="color:#3b82f6;font-size:14px;"></i>
            </div>
            <span class="trend-up"><i class="fas fa-arrow-up" style="font-size:8px;"></i>+12.5%</span>
        </div>
        <div class="stat-num text-[#1a1a1a]" style="font-size:1.6rem;">1.245</div>
        <div style="font-size:11px;color:#555;margin-top:4px;">Total Pesanan</div>
        <div style="font-size:10px;color:#333;margin-top:2px;">vs 1.107 bulan lalu</div>
        <div class="flex items-end gap-0.5 mt-3" style="height:20px;">
            @foreach([50,60,55,70,65,75,60,80,70,85,80,95] as $h)
            <div style="flex:1;background:rgba(59,130,246,0.3);border-radius:1px;height:{{ $h }}%;"></div>
            @endforeach
        </div>
    </div>

    {{-- Total Produk Terjual --}}
    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(192,192,192,0.08);border:1px solid rgba(192,192,192,0.15);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-box" style="color:#6b7280;font-size:14px;"></i>
            </div>
            <span class="trend-up"><i class="fas fa-arrow-up" style="font-size:8px;"></i>+8.2%</span>
        </div>
        <div class="stat-num text-[#1a1a1a]" style="font-size:1.6rem;">3.542</div>
        <div style="font-size:11px;color:#555;margin-top:4px;">Produk Terjual</div>
        <div style="font-size:10px;color:#333;margin-top:2px;">vs 3.273 bulan lalu</div>
        <div class="flex items-end gap-0.5 mt-3" style="height:20px;">
            @foreach([60,55,65,60,75,70,80,75,85,80,90,100] as $h)
            <div style="flex:1;background:rgba(192,192,192,0.2);border-radius:1px;height:{{ $h }}%;"></div>
            @endforeach
        </div>
    </div>

    {{-- Rata-rata Order --}}
    <div class="stat-card">
        <div class="flex items-start justify-between mb-4">
            <div style="width:38px;height:38px;border-radius:10px;background:rgba(234,179,8,0.1);border:1px solid rgba(234,179,8,0.2);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-chart-bar" style="color:#eab308;font-size:14px;"></i>
            </div>
            <span class="trend-up"><i class="fas fa-arrow-up" style="font-size:8px;"></i>+5.1%</span>
        </div>
        <div class="stat-num text-[#1a1a1a]" style="font-size:1.3rem;">Rp 100,7 Rb</div>
        <div style="font-size:11px;color:#555;margin-top:4px;">Rata-rata Order</div>
        <div style="font-size:10px;color:#333;margin-top:2px;">vs Rp 95.800 bulan lalu</div>
        <div class="flex items-end gap-0.5 mt-3" style="height:20px;">
            @foreach([65,70,68,72,70,75,73,78,76,80,82,88] as $h)
            <div style="flex:1;background:rgba(234,179,8,0.25);border-radius:1px;height:{{ $h }}%;"></div>
            @endforeach
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════ --}}
{{-- GRAFIK 1 — TREN PENJUALAN (LINE)         --}}
{{-- ════════════════════════════════════════ --}}
<div class="section-card mb-6">
    <div class="section-card-header">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-chart-line" style="color:#6b7280;font-size:11px;"></i>
            </div>
            <div>
                <div class="section-card-title" style="color:#1a1a1a;">Tren Penjualan</div>
                <div style="font-size:10px;color:#9ca3af;margin-top:1px;">30 hari terakhir · dalam Rupiah</div>
            </div>
        </div>
        <div class="flex items-center gap-2">
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;">
                <span style="width:20px;height:2px;background:#1a1a1a;border-radius:1px;display:inline-block;"></span>
                Pendapatan
            </span>
        </div>
    </div>
    <div class="section-card-body">
        <div class="chart-container" style="height:220px;">
            <canvas id="chartTren"></canvas>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- GRAFIK 2 — KATEGORI + TOP PRODUK (2 kol) --}}
{{-- ════════════════════════════════════════ --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-5 mb-6">

    {{-- Donut: Penjualan per Kategori --}}
    <div class="section-card">
        <div class="section-card-header">
            <div class="flex items-center gap-2">
                <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-chart-pie" style="color:#6b7280;font-size:11px;"></i>
                </div>
                <div class="section-card-title">Penjualan per Kategori</div>
            </div>
        </div>
        <div class="section-card-body">
            <div class="flex flex-col sm:flex-row gap-6 items-center">
                {{-- Chart --}}
                <div style="width:160px;height:160px;flex-shrink:0;">
                    <canvas id="chartKategori"></canvas>
                </div>
                {{-- Legend --}}
                <div style="flex:1;width:100%;">
                    @foreach([
                        ['label'=>'Kemeja Pria',    'pct'=>35, 'color'=>'#c0c0c0'],
                        ['label'=>'Kemeja Wanita',  'pct'=>25, 'color'=>'#3b82f6'],
                        ['label'=>'Gaun & Dress',   'pct'=>20, 'color'=>'#a855f7'],
                        ['label'=>'Celana & Rok',   'pct'=>12, 'color'=>'#22c55e'],
                        ['label'=>'Aksesoris',      'pct'=>8,  'color'=>'#eab308'],
                    ] as $k)
                    <div class="donut-legend-item">
                        <div class="donut-legend-dot" style="background:{{ $k['color'] }};"></div>
                        <span style="flex:1;font-size:12px;color:#6b7280;">{{ $k['label'] }}</span>
                        <span style="font-size:12px;font-weight:700;color:#1a1a1a;">{{ $k['pct'] }}%</span>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    {{-- Bar: Top 5 Produk Terlaris --}}
    <div class="section-card">
        <div class="section-card-header">
            <div class="flex items-center gap-2">
                <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-trophy" style="color:#6b7280;font-size:11px;"></i>
                </div>
                <div class="section-card-title">Top 5 Produk Terlaris</div>
            </div>
        </div>
        <div class="section-card-body">
            <div class="chart-container" style="height:190px;">
                <canvas id="chartTopProduk"></canvas>
            </div>
        </div>
    </div>

</div>

{{-- ════════════════════════════════════════ --}}
{{-- GRAFIK 3 — FISIK VS DIGITAL              --}}
{{-- ════════════════════════════════════════ --}}
<div class="section-card mb-6">
    <div class="section-card-header">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-balance-scale" style="color:#6b7280;font-size:11px;"></i>
            </div>
            <div>
                <div class="section-card-title">Perbandingan Fisik vs Digital</div>
                <div style="font-size:10px;color:#9ca3af;margin-top:1px;">Berdasarkan jumlah unit terjual</div>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;">
                <span style="width:10px;height:10px;border-radius:3px;background:#a855f7;display:inline-block;"></span> Fisik (65%)
            </span>
            <span style="display:inline-flex;align-items:center;gap:5px;font-size:11px;color:#6b7280;">
                <span style="width:10px;height:10px;border-radius:3px;background:#c0c0c0;display:inline-block;"></span> Digital (35%)
            </span>
        </div>
    </div>
    <div class="section-card-body">
        {{-- Summary row --}}
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div style="background:#f5f5f5;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;">
                <div style="font-size:10px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">
                    <i class="fas fa-box mr-1" style="color:#a855f7;"></i>Pola Fisik
                </div>
                <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:1.4rem;color:#a855f7;">2.302</div>
                <div style="font-size:11px;color:#6b7280;margin-top:2px;">unit terjual · 65%</div>
                <div class="prog-bar-wrap" style="margin-top:8px;">
                    <div class="prog-bar-fill" style="width:65%;background:linear-gradient(90deg,#a855f7,#7c3aed);"></div>
                </div>
            </div>
            <div style="background:#f5f5f5;border:1px solid #e5e7eb;border-radius:10px;padding:14px 16px;">
                <div style="font-size:10px;color:#6b7280;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:6px;">
                    <i class="fas fa-file-pdf mr-1" style="color:#c0c0c0;"></i>Pola Digital
                </div>
                <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:1.4rem;color:#c0c0c0;">1.240</div>
                <div style="font-size:11px;color:#6b7280;margin-top:2px;">unit terjual · 35%</div>
                <div class="prog-bar-wrap" style="margin-top:8px;">
                    <div class="prog-bar-fill" style="width:35%;background:linear-gradient(90deg,#c0c0c0,#888);"></div>
                </div>
            </div>
        </div>
        <div class="chart-container" style="height:200px;">
            <canvas id="chartFisikDigital"></canvas>
        </div>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- TABEL — TOP 10 PRODUK TERLARIS          --}}
{{-- ════════════════════════════════════════ --}}
<div class="section-card mb-6">
    <div class="section-card-header">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-medal" style="color:#6b7280;font-size:11px;"></i>
            </div>
            <div class="section-card-title">Top 10 Produk Terlaris</div>
        </div>
        <button class="btn-admin-outline" style="font-size:10px;padding:5px 12px;">
            <i class="fas fa-external-link-alt" style="font-size:9px;"></i>
            Lihat Semua
        </button>
    </div>
    <div style="overflow-x:auto;">
    <table class="report-table">
        <thead>
            <tr>
                <th style="width:50px;text-align:center;">Rank</th>
                <th>Nama Produk</th>
                <th class="hidden md:table-cell">Kategori</th>
                <th class="hidden sm:table-cell">Tipe</th>
                <th style="text-align:center;">Terjual</th>
                <th style="text-align:right;">Pendapatan</th>
            </tr>
        </thead>
        <tbody>
            @php
            $top_produk = [
                ['rank'=>1, 'nama'=>'Pola Kemeja Batik Pria Lengan Panjang',   'kat'=>'Kemeja Pria',   'tipe'=>'fisik',   'terjual'=>187, 'pendapatan'=>28050000,  'rank_color'=>'#eab308', 'rank_bg'=>'rgba(234,179,8,0.1)'],
                ['rank'=>2, 'nama'=>'Pola Dress Casual Wanita V-Neck',          'kat'=>'Gaun & Dress',  'tipe'=>'digital', 'terjual'=>154, 'pendapatan'=>18480000,  'rank_color'=>'#c0c0c0', 'rank_bg'=>'rgba(192,192,192,0.08)'],
                ['rank'=>3, 'nama'=>'Pola Blouse Wanita Lengan Puff',           'kat'=>'Kemeja Wanita', 'tipe'=>'fisik',   'terjual'=>142, 'pendapatan'=>21300000,  'rank_color'=>'#a855f7', 'rank_bg'=>'rgba(168,85,247,0.08)'],
                ['rank'=>4, 'nama'=>'Pola Kemeja Formal Pria Slim Fit',         'kat'=>'Kemeja Pria',   'tipe'=>'fisik',   'terjual'=>128, 'pendapatan'=>19200000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>5, 'nama'=>'Pola Celana Kulot Wanita Wide Leg',        'kat'=>'Celana & Rok',  'tipe'=>'digital', 'terjual'=>116, 'pendapatan'=>11600000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>6, 'nama'=>'Pola Rok A-Line Midi',                     'kat'=>'Celana & Rok',  'tipe'=>'fisik',   'terjual'=>103, 'pendapatan'=>12360000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>7, 'nama'=>'Pola Kemeja Hawaii Pria Short Sleeve',     'kat'=>'Kemeja Pria',   'tipe'=>'digital', 'terjual'=>98,  'pendapatan'=>8820000,   'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>8, 'nama'=>'Pola Jumpsuit Casual Wanita',              'kat'=>'Gaun & Dress',  'tipe'=>'fisik',   'terjual'=>91,  'pendapatan'=>13650000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>9, 'nama'=>'Pola Blazer Wanita Single Button',         'kat'=>'Kemeja Wanita', 'tipe'=>'digital', 'terjual'=>85,  'pendapatan'=>12750000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
                ['rank'=>10,'nama'=>'Pola Kemeja Koko Pria Lengan Pendek',      'kat'=>'Kemeja Pria',   'tipe'=>'fisik',   'terjual'=>79,  'pendapatan'=>11850000,  'rank_color'=>'#555',    'rank_bg'=>'rgba(255,255,255,0.03)'],
            ];
            $max_terjual = 187;
            @endphp

            @foreach($top_produk as $p)
            <tr>
                <td style="text-align:center;">
                    <div class="rank-badge" style="background:{{ $p['rank_bg'] }};color:{{ $p['rank_color'] }};margin:0 auto;">
                        {{ $p['rank'] }}
                    </div>
                </td>
                <td>
                    <div style="font-size:12px;font-weight:600;color:#1a1a1a;max-width:220px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $p['nama'] }}</div>
                    <div class="prog-bar-wrap" style="max-width:200px;margin-top:5px;">
                        <div class="prog-bar-fill" style="width:{{ round($p['terjual']/$max_terjual*100) }}%;background:linear-gradient(90deg,{{ $p['rank_color'] }},{{ $p['rank_color'] }}88);"></div>
                    </div>
                </td>
                <td class="hidden md:table-cell">
                    <span style="font-size:11px;color:#6b7280;">{{ $p['kat'] }}</span>
                </td>
                <td class="hidden sm:table-cell">
                    @if($p['tipe'] === 'digital')
                    <span class="badge badge-digital">Digital</span>
                    @else
                    <span class="badge badge-fisik">Fisik</span>
                    @endif
                </td>
                <td style="text-align:center;">
                    <span style="font-size:13px;font-weight:700;color:#1a1a1a;">{{ $p['terjual'] }}</span>
                </td>
                <td style="text-align:right;">
                    <span style="font-size:11px;font-weight:600;color:#6b7280;">Rp {{ number_format($p['pendapatan'],0,',','.') }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

{{-- ════════════════════════════════════════ --}}
{{-- TABEL — PESANAN TERBARU                  --}}
{{-- ════════════════════════════════════════ --}}
<div class="section-card">
    <div class="section-card-header">
        <div class="flex items-center gap-2">
            <div style="width:28px;height:28px;border-radius:7px;background:rgba(192,192,192,0.06);border:1px solid rgba(192,192,192,0.1);display:flex;align-items:center;justify-content:center;">
                <i class="fas fa-receipt" style="color:#6b7280;font-size:11px;"></i>
            </div>
            <div class="section-card-title">Pesanan Terbaru</div>
        </div>
        <a href="{{ route('admin.pesanan') }}" class="btn-admin-outline" style="font-size:10px;padding:5px 12px;">
            <i class="fas fa-arrow-right" style="font-size:9px;"></i>
            Lihat Semua
        </a>
    </div>
    <div style="overflow-x:auto;">
    <table class="report-table">
        <thead>
            <tr>
                <th>No. Order</th>
                <th>Customer</th>
                <th class="hidden md:table-cell">Produk</th>
                <th style="text-align:right;">Total</th>
                <th>Status</th>
                <th class="hidden sm:table-cell">Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach([
                ['no'=>'ORD-2024-1245','cust'=>'Ratna Sari',     'produk'=>'Pola Dress Casual V-Neck',    'total'=>450000,  'status'=>'diproses', 'tgl'=>'22 Nov 2024'],
                ['no'=>'ORD-2024-1244','cust'=>'Eko Prasetyo',   'produk'=>'Pola Kemeja Batik Lengan Pjg','total'=>350000,  'status'=>'dikirim',  'tgl'=>'21 Nov 2024'],
                ['no'=>'ORD-2024-1243','cust'=>'Hendra Wijaya',  'produk'=>'Pola Blouse Wanita Puff',     'total'=>230000,  'status'=>'selesai',  'tgl'=>'19 Nov 2024'],
                ['no'=>'ORD-2024-1242','cust'=>'Dewi Anggraini', 'produk'=>'Pola Celana Kulot Wide Leg',  'total'=>175000,  'status'=>'selesai',  'tgl'=>'18 Nov 2024'],
                ['no'=>'ORD-2024-1241','cust'=>'Siti Rahayu',    'produk'=>'Pola Kemeja Formal Slim Fit', 'total'=>285000,  'status'=>'selesai',  'tgl'=>'18 Nov 2024'],
            ] as $o)
            <tr>
                <td>
                    <span style="font-size:11px;font-weight:600;color:#6b7280;font-family:'Montserrat',sans-serif;">{{ $o['no'] }}</span>
                </td>
                <td>
                    <span style="font-size:12px;color:#1a1a1a;font-weight:500;">{{ $o['cust'] }}</span>
                </td>
                <td class="hidden md:table-cell">
                    <span style="font-size:11px;color:#555;max-width:180px;display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ $o['produk'] }}</span>
                </td>
                <td style="text-align:right;">
                    <span style="font-size:12px;font-weight:600;color:#1a1a1a;">Rp {{ number_format($o['total'],0,',','.') }}</span>
                </td>
                <td>
                    @if($o['status'] === 'selesai')
                        <span class="badge badge-selesai"><i class="fas fa-check" style="font-size:7px;"></i>Selesai</span>
                    @elseif($o['status'] === 'diproses')
                        <span class="badge badge-proses"><i class="fas fa-clock" style="font-size:7px;"></i>Diproses</span>
                    @elseif($o['status'] === 'dikirim')
                        <span class="badge badge-dikirim"><i class="fas fa-truck" style="font-size:7px;"></i>Dikirim</span>
                    @else
                        <span class="badge badge-batal"><i class="fas fa-times" style="font-size:7px;"></i>Batal</span>
                    @endif
                </td>
                <td class="hidden sm:table-cell">
                    <span style="font-size:11px;color:#6b7280;">{{ $o['tgl'] }}</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
// ── Shared chart defaults ──
Chart.defaults.color = '#6b7280';
Chart.defaults.borderColor = '#f0f0f0';
Chart.defaults.font.family = "'Inter', sans-serif";
Chart.defaults.font.size = 11;

// ─────────────────────────────────────────
// GRAFIK 1 — Line Chart: Tren Penjualan
// ─────────────────────────────────────────
(function() {
    const labels = [];
    const data   = [];
    const base   = new Date('2024-10-24');
    const vals   = [
        3200000, 4100000, 2800000, 5200000, 3900000, 6100000, 4500000,
        5800000, 3700000, 6900000, 5100000, 7200000, 4800000, 6500000,
        5300000, 7800000, 5600000, 8100000, 6200000, 7500000, 5900000,
        8800000, 6700000, 9200000, 7100000, 8500000, 7800000, 9800000,
        8200000, 10500000
    ];
    for (let i = 0; i < 30; i++) {
        const d = new Date(base);
        d.setDate(base.getDate() + i);
        labels.push(d.toLocaleDateString('id-ID', {day:'2-digit', month:'short'}));
        data.push(vals[i]);
    }

    const ctx = document.getElementById('chartTren').getContext('2d');
    const grad = ctx.createLinearGradient(0, 0, 0, 220);
    grad.addColorStop(0, 'rgba(192,192,192,0.15)');
    grad.addColorStop(1, 'rgba(192,192,192,0)');

    new Chart(ctx, {
        type: 'line',
        data: {
            labels,
            datasets: [{
                label: 'Pendapatan',
                data,
                borderColor: '#c0c0c0',
                borderWidth: 2,
                backgroundColor: grad,
                fill: true,
                tension: 0.4,
                pointRadius: 0,
                pointHoverRadius: 4,
                pointHoverBackgroundColor: '#c0c0c0',
                pointHoverBorderColor: '#ffffff',
                pointHoverBorderWidth: 2,
            }]
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
                    padding: 10,
                    titleColor: '#1a1a1a',
                    bodyColor: '#6b7280',
                    callbacks: {
                        label: ctx => ' Rp ' + new Intl.NumberFormat('id-ID').format(ctx.parsed.y)
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f0f0f0' },
                    ticks: { color: '#6b7280', maxTicksLimit: 8, maxRotation: 0 },
                    border: { color: '#e5e7eb' }
                },
                y: {
                    grid: { color: '#f0f0f0' },
                    ticks: {
                        color: '#2a2a2a',
                        callback: v => 'Rp ' + (v >= 1000000 ? (v/1000000).toFixed(1)+'Jt' : (v/1000)+'Rb')
                    },
                    border: { color: 'transparent' }
                }
            }
        }
    });
})();

// ─────────────────────────────────────────
// GRAFIK 2a — Donut: Penjualan per Kategori
// ─────────────────────────────────────────
(function() {
    const ctx = document.getElementById('chartKategori').getContext('2d');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Kemeja Pria', 'Kemeja Wanita', 'Gaun & Dress', 'Celana & Rok', 'Aksesoris'],
            datasets: [{
                data: [35, 25, 20, 12, 8],
                backgroundColor: ['#c0c0c0', '#3b82f6', '#a855f7', '#22c55e', '#eab308'],
                borderColor: '#ffffff',
                borderWidth: 3,
                hoverOffset: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            cutout: '68%',
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + '%'
                    }
                }
            }
        }
    });
})();

// ─────────────────────────────────────────
// GRAFIK 2b — Horizontal Bar: Top 5 Produk
// ─────────────────────────────────────────
(function() {
    const ctx = document.getElementById('chartTopProduk').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Kemeja Batik', 'Dress Casual', 'Blouse Puff', 'Kemeja Formal', 'Celana Kulot'],
            datasets: [{
                label: 'Terjual',
                data: [187, 154, 142, 128, 116],
                backgroundColor: [
                    'rgba(192,192,192,0.7)',
                    'rgba(192,192,192,0.55)',
                    'rgba(192,192,192,0.45)',
                    'rgba(192,192,192,0.35)',
                    'rgba(192,192,192,0.25)',
                ],
                borderColor: [
                    'rgba(192,192,192,0.9)',
                    'rgba(192,192,192,0.7)',
                    'rgba(192,192,192,0.6)',
                    'rgba(192,192,192,0.5)',
                    'rgba(192,192,192,0.4)',
                ],
                borderWidth: 1,
                borderRadius: 4,
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.parsed.x + ' unit terjual'
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f0f0f0' },
                    ticks: { color: '#6b7280' },
                    border: { color: '#e5e7eb' }
                },
                y: {
                    grid: { display: false },
                    ticks: { color: '#6b7280' },
                    border: { color: 'transparent' }
                }
            }
        }
    });
})();

// ─────────────────────────────────────────
// GRAFIK 3 — Bar: Fisik vs Digital per bulan
// ─────────────────────────────────────────
(function() {
    const ctx = document.getElementById('chartFisikDigital').getContext('2d');
    const months = ['Jun','Jul','Agu','Sep','Okt','Nov'];
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: months,
            datasets: [
                {
                    label: 'Fisik',
                    data: [320, 380, 350, 410, 390, 452],
                    backgroundColor: 'rgba(168,85,247,0.6)',
                    borderColor: 'rgba(168,85,247,0.9)',
                    borderWidth: 1,
                    borderRadius: 4,
                },
                {
                    label: 'Digital',
                    data: [180, 210, 195, 230, 215, 244],
                    backgroundColor: 'rgba(192,192,192,0.35)',
                    borderColor: 'rgba(192,192,192,0.6)',
                    borderWidth: 1,
                    borderRadius: 4,
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    backgroundColor: '#ffffff',
                    borderColor: '#e5e7eb',
                    borderWidth: 1,
                    padding: 10,
                    callbacks: {
                        label: ctx => ' ' + ctx.dataset.label + ': ' + ctx.parsed.y + ' unit'
                    }
                }
            },
            scales: {
                x: {
                    grid: { color: '#f0f0f0' },
                    ticks: { color: '#6b7280' },
                    border: { color: '#e5e7eb' }
                },
                y: {
                    grid: { color: '#f0f0f0' },
                    ticks: { color: '#6b7280' },
                    border: { color: 'transparent' }
                }
            }
        }
    });
})();
</script>
@endsection
