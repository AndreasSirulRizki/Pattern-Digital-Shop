@extends('layouts.admin')

@section('title', 'Kelola Customer - Admin')
@section('header-title', 'Kelola Customer')

@section('styles')
<style>
    /* ── Stat Cards ── */
    .stat-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 18px 20px;
        position: relative;
        overflow: hidden;
        transition: all 0.2s;
    }
    .stat-card:hover {
        border-color: #d1d5db;
        box-shadow: 0 4px 20px rgba(0,0,0,0.06);
        transform: translateY(-1px);
    }
    .stat-num {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800;
        font-size: 1.6rem;
        line-height: 1;
    }

    /* ── Filter bar ── */
    .filter-input {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-family: 'Inter', sans-serif;
        font-size: 12px;
        padding: 8px 12px 8px 34px;
        outline: none;
        transition: border-color 0.2s;
        width: 100%;
    }
    .filter-input:focus { border-color: #333; }
    .filter-input::placeholder { color: #9ca3af; }

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
    .filter-select:focus { border-color: #333; }

    /* ── Table ── */
    .admin-table-wrap {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
    }
    .admin-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .admin-table thead tr {
        background: #f5f5f5;
        border-bottom: 1px solid #e5e7eb;
    }
    .admin-table th {
        padding: 11px 14px;
        text-align: left;
        font-size: 10px; font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.08em; text-transform: uppercase;
        white-space: nowrap;
    }
    .admin-table th:first-child { padding-left: 16px; }
    .admin-table th:last-child  { padding-right: 16px; text-align: center; }
    .admin-table tbody tr {
        border-bottom: 1px solid #f0f0f0;
        transition: background 0.15s;
    }
    .admin-table tbody tr:last-child { border-bottom: none; }
    .admin-table tbody tr:hover { background: #faf8f5; }
    .admin-table td {
        padding: 11px 14px;
        color: #6b7280;
        vertical-align: middle;
    }
    .admin-table td:first-child { padding-left: 16px; }
    .admin-table td:last-child  { padding-right: 16px; }

    /* Avatar inisial */
    .cust-avatar {
        width: 34px; height: 34px;
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700; font-size: 12px;
        flex-shrink: 0;
        border: 1px solid rgba(0,0,0,0.08);
    }

    /* Status badge */
    .badge-aktif {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px;
        background: rgba(34,197,94,0.08);
        border: 1px solid rgba(34,197,94,0.2);
        border-radius: 20px;
        font-size: 10px; font-weight: 600;
        color: #15803d; white-space: nowrap;
    }
    .badge-nonaktif {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 8px;
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        border-radius: 20px;
        font-size: 10px; font-weight: 600;
        color: #dc2626; white-space: nowrap;
    }

    /* Action buttons */
    .btn-tbl {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 10px; border-radius: 6px;
        font-size: 11px; font-weight: 500;
        cursor: pointer; transition: all 0.15s;
        white-space: nowrap; text-decoration: none;
        background: transparent; font-family: 'Inter', sans-serif;
    }
    .btn-tbl-primary { border: 1px solid #e5e7eb; color: #6b7280; }
    .btn-tbl-primary:hover { border-color: #333333; color: #1a1a1a; background: #f5f5f5; }
    .btn-tbl-danger  { border: 1px solid transparent; color: #9ca3af; }
    .btn-tbl-danger:hover { border-color: rgba(239,68,68,0.3); color: #ef4444; background: rgba(239,68,68,0.05); }

    /* Pagination */
    .pagination { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
    .pagination .page-item .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 30px; height: 30px; padding: 0 8px;
        border-radius: 6px; font-size: 11px; font-weight: 600;
        border: 1px solid #e5e7eb; color: #6b7280;
        background: #ffffff; text-decoration: none; transition: all 0.15s;
    }
    .pagination .page-item.active .page-link { background: #1a1a1a; border-color: #1a1a1a; color: #ffffff; }
    .pagination .page-item.disabled .page-link { opacity: 0.4; cursor: not-allowed; }
    .pagination .page-item .page-link:hover { border-color: #333; color: #1a1a1a; }

    /* ── MODAL ── */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 1000;
        display: flex; align-items: center; justify-content: center;
        padding: 16px;
    }
    .modal-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        width: 100%; max-width: 640px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
    }
    .modal-header {
        padding: 20px 24px 16px;
        border-bottom: 1px solid #e5e7eb;
        display: flex; align-items: center; justify-content: space-between;
        position: sticky; top: 0;
        background: #ffffff;
        z-index: 2;
    }
    .modal-body { padding: 20px 24px; }
    .modal-section-title {
        font-size: 10px; font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 12px;
        display: flex; align-items: center; gap: 8px;
    }
    .modal-section-title::after {
        content: ''; flex: 1; height: 1px; background: #e5e7eb;
    }
    .modal-info-row {
        display: flex; gap: 10px;
        padding: 9px 12px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 8px;
        align-items: flex-start;
    }
    .modal-info-icon {
        width: 28px; height: 28px;
        border-radius: 7px;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
    }
    .modal-stat-card {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 12px 14px;
        text-align: center;
    }
    .mini-order-row {
        display: flex; align-items: center; gap: 10px;
        padding: 8px 12px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        margin-bottom: 6px;
        font-size: 11px;
    }
    .mini-order-row:last-child { margin-bottom: 0; }
    .modal-card::-webkit-scrollbar { width: 4px; }
    .modal-card::-webkit-scrollbar-track { background: transparent; }
    .modal-card::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

    /* Flash message */
    .flash-success {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: rgba(22,163,74,0.08);
        border: 1px solid rgba(22,163,74,0.2);
        color: #15803d; font-size: 13px; font-weight: 500;
        margin-bottom: 20px;
    }
    .flash-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        color: #dc2626; font-size: 13px;
        margin-bottom: 20px;
    }
</style>
@endsection

@section('content')

{{-- ── Flash Messages ── --}}
@if(session('success'))
<div class="flash-success">
    <i class="fas fa-check-circle" style="font-size:15px; flex-shrink:0;"></i>
    {{ session('success') }}
</div>
@endif

@if($errors->any())
<div class="flash-error">
    <i class="fas fa-exclamation-circle" style="font-size:15px; flex-shrink:0; margin-top:1px;"></i>
    <div>
        @foreach($errors->all() as $error)
            <div>{{ $error }}</div>
        @endforeach
    </div>
</div>
@endif

<div x-data="{
    modalOpen: false,
    selected: null,
    loading: false,
    openModal(id) {
        this.loading = true;
        this.modalOpen = true;
        fetch('/admin/customer/' + id, {
            headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(r => r.json())
        .then(data => { this.selected = data; this.loading = false; })
        .catch(() => { this.loading = false; });
    },
    closeModal() { this.modalOpen = false; this.selected = null; }
}">

    {{-- ════════════════════════════════════════ --}}
    {{-- HEADER                                   --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h1 class="font-montserrat font-bold text-[#1a1a1a] text-2xl leading-tight">Kelola Customer</h1>
            <p class="text-xs mt-1" style="color:#6b7280;">
                <i class="fas fa-users mr-1"></i>
                Total <span style="color:#1a1a1a; font-weight:600;">{{ $stats['total'] }}</span> customer terdaftar
                &nbsp;·&nbsp; <span style="color:#15803d;">{{ $stats['aktif'] }} aktif</span>
                &nbsp;·&nbsp; <span style="color:#dc2626;">{{ $stats['nonaktif'] }} nonaktif</span>
            </p>
        </div>
        <a href="{{ route('admin.customer') }}" class="btn-admin-outline gap-2">
            <i class="fas fa-sync-alt" style="font-size:10px;"></i> Refresh
        </a>
    </div>

    {{-- ════════════════════════════════════════ --}}
    {{-- STATISTIK MINI (4 CARD)                  --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">

        <div class="stat-card">
            <div class="flex items-start justify-between mb-3">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(59,130,246,0.1);border:1px solid rgba(59,130,246,0.2);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-users" style="color:#3b82f6;font-size:13px;"></i>
                </div>
                <span style="font-size:9px;font-weight:700;color:#3b82f6;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.15);padding:2px 7px;border-radius:10px;">ALL TIME</span>
            </div>
            <div class="stat-num" style="color:#3b82f6;">{{ $stats['total'] }}</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Total Customer</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-3">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(34,197,94,0.1);border:1px solid rgba(34,197,94,0.2);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-plus" style="color:#22c55e;font-size:13px;"></i>
                </div>
                <span style="font-size:9px;font-weight:700;color:#22c55e;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.15);padding:2px 7px;border-radius:10px;">BULAN INI</span>
            </div>
            <div class="stat-num" style="color:#22c55e;">{{ $stats['baru_bulan'] }}</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Customer Baru</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-3">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(107,114,128,0.08);border:1px solid rgba(107,114,128,0.15);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-check" style="color:#6b7280;font-size:13px;"></i>
                </div>
                <span style="font-size:9px;font-weight:700;color:#6b7280;background:rgba(107,114,128,0.06);border:1px solid rgba(107,114,128,0.12);padding:2px 7px;border-radius:10px;">AKTIF</span>
            </div>
            <div class="stat-num" style="color:#1a1a1a;">{{ $stats['aktif'] }}</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Customer Aktif</div>
        </div>

        <div class="stat-card">
            <div class="flex items-start justify-between mb-3">
                <div style="width:34px;height:34px;border-radius:9px;background:rgba(239,68,68,0.1);border:1px solid rgba(239,68,68,0.2);display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-user-times" style="color:#ef4444;font-size:13px;"></i>
                </div>
                <span style="font-size:9px;font-weight:700;color:#ef4444;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.15);padding:2px 7px;border-radius:10px;">NONAKTIF</span>
            </div>
            <div class="stat-num" style="color:#ef4444;">{{ $stats['nonaktif'] }}</div>
            <div style="font-size:11px;color:#6b7280;margin-top:4px;">Customer Nonaktif</div>
        </div>

    </div>

    {{-- ════════════════════════════════════════ --}}
    {{-- FILTER & SEARCH                          --}}
    {{-- ════════════════════════════════════════ --}}
    <form method="GET" action="{{ route('admin.customer') }}"
          style="background:#f5f5f5;border:1px solid #e5e7eb;border-radius:12px;padding:16px 20px;margin-bottom:16px;">
        <div class="flex flex-col md:flex-row gap-3 items-end">

            <div style="flex:1; min-width:0;">
                <label style="display:block;font-size:10px;font-weight:700;color:#6b7280;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;">Cari Customer</label>
                <div class="relative">
                    <i class="fas fa-search absolute" style="left:11px;top:50%;transform:translateY(-50%);color:#9ca3af;font-size:11px;pointer-events:none;"></i>
                    <input type="text" name="search" placeholder="Cari nama, email, no HP..."
                           value="{{ request('search') }}"
                           class="filter-input">
                </div>
            </div>

            <div style="min-width:140px;">
                <label style="display:block;font-size:10px;font-weight:700;color:#6b7280;letter-spacing:0.08em;text-transform:uppercase;margin-bottom:5px;">Status</label>
                <select name="status" class="filter-select w-full">
                    <option value="">Semua Status</option>
                    <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                    <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="btn-admin-outline" style="height:34px; padding:0 16px; white-space:nowrap;">
                    <i class="fas fa-filter" style="font-size:10px;"></i> Terapkan
                </button>
                <a href="{{ route('admin.customer') }}" class="btn-admin-outline" style="height:34px; padding:0 12px;">
                    <i class="fas fa-times" style="font-size:10px;"></i>
                </a>
            </div>

        </div>
    </form>

    {{-- ════════════════════════════════════════ --}}
    {{-- TABEL CUSTOMER                           --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="admin-table-wrap">

        {{-- Table header bar --}}
        <div class="flex items-center justify-between px-4 py-3" style="border-bottom:1px solid #e5e7eb;">
            <div style="font-size:11px;color:#6b7280;">
                Menampilkan <span style="color:#1a1a1a;font-weight:600;">{{ $customer->total() }}</span> customer
            </div>
            <div class="flex items-center gap-2 text-xs" style="color:#6b7280;">
                <i class="fas fa-sort-amount-down" style="font-size:10px;"></i> Terbaru
            </div>
        </div>

        <div style="overflow-x:auto;">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Customer</th>
                    <th>Email</th>
                    <th class="hidden lg:table-cell">No. HP</th>
                    <th class="hidden md:table-cell" style="text-align:center;">Pesanan</th>
                    <th class="hidden md:table-cell" style="text-align:right;">Total Belanja</th>
                    <th>Status</th>
                    <th class="hidden lg:table-cell">Tgl. Daftar</th>
                    <th style="text-align:center;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($customer as $c)
                @php
                    $colors = ['#3b82f6','#22c55e','#a855f7','#f59e0b','#06b6d4','#ec4899','#14b8a6','#f97316'];
                    $color  = $colors[$c->id % count($colors)];
                    $inisial = strtoupper(substr($c->name, 0, 1)) . (strpos($c->name,' ') !== false ? strtoupper(substr(strrchr($c->name,' '),1,1)) : '');
                @endphp
                <tr>
                    {{-- Avatar + Nama --}}
                    <td>
                        <div class="flex items-center gap-2.5">
                            <div class="cust-avatar" style="background:{{ $color }}20; color:{{ $color }};">
                                {{ $inisial }}
                            </div>
                            <div>
                                <div style="font-size:12px;font-weight:600;color:#1a1a1a;">{{ $c->name }}</div>
                                <div style="font-size:10px;color:#9ca3af;margin-top:1px;">#{{ str_pad($c->id, 4, '0', STR_PAD_LEFT) }}</div>
                            </div>
                        </div>
                    </td>

                    <td><span style="font-size:11px;color:#6b7280;">{{ $c->email }}</span></td>

                    <td class="hidden lg:table-cell">
                        <span style="font-size:11px;color:#6b7280;">{{ $c->no_hp ?? '—' }}</span>
                    </td>

                    <td class="hidden md:table-cell" style="text-align:center;">
                        <span style="font-size:13px;font-weight:700;color:#1a1a1a;">{{ $c->pesanan_count }}</span>
                    </td>

                    <td class="hidden md:table-cell" style="text-align:right;">
                        <span style="font-size:11px;font-weight:600;color:#6b7280;">
                            Rp {{ number_format($c->pesanan_sum_total ?? 0, 0, ',', '.') }}
                        </span>
                    </td>

                    {{-- Status --}}
                    <td>
                        @if($c->status === 'aktif')
                        <span class="badge-aktif">
                            <i class="fas fa-circle" style="font-size:5px;"></i>Aktif
                        </span>
                        @else
                        <span class="badge-nonaktif">
                            <i class="fas fa-circle" style="font-size:5px;"></i>Nonaktif
                        </span>
                        @endif
                    </td>

                    <td class="hidden lg:table-cell">
                        <span style="font-size:11px;color:#6b7280;">
                            {{ $c->created_at->format('d M Y') }}
                        </span>
                    </td>

                    {{-- Aksi --}}
                    <td>
                        <div class="flex items-center gap-1.5" style="justify-content:center;">

                            {{-- Tombol Detail --}}
                            <button class="btn-tbl btn-tbl-primary"
                                    @click="openModal({{ $c->id }})">
                                <i class="fas fa-eye" style="font-size:10px;"></i>
                                <span class="hidden sm:inline">Detail</span>
                            </button>

                            {{-- Dropdown Aksi --}}
                            <div class="relative" x-data="{ open: false }">
                                <button class="btn-tbl btn-tbl-primary"
                                        @click="open = !open"
                                        @click.outside="open = false">
                                    <i class="fas fa-ellipsis-v" style="font-size:10px;"></i>
                                </button>
                                <div x-show="open"
                                     x-transition:enter="transition ease-out duration-100"
                                     x-transition:enter-start="opacity-0 scale-95"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     style="position:absolute;right:0;top:calc(100% + 4px);width:170px;background:#ffffff;border:1px solid #e5e7eb;border-radius:9px;z-index:50;overflow:hidden;box-shadow:0 8px 24px rgba(0,0,0,0.12);">
                                    <div style="padding:4px;">

                                        {{-- Toggle Status --}}
                                        <form method="POST" action="{{ route('admin.customer.toggleStatus', $c->id) }}">
                                            @csrf
                                            @method('PUT')
                                            @if($c->status === 'aktif')
                                            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-xs text-left transition-colors hover:bg-red-50"
                                                    style="color:#ef4444;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;">
                                                <i class="fas fa-user-times" style="font-size:10px;width:12px;text-align:center;"></i>
                                                Nonaktifkan
                                            </button>
                                            @else
                                            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-xs text-left transition-colors hover:bg-green-50"
                                                    style="color:#22c55e;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;">
                                                <i class="fas fa-user-check" style="font-size:10px;width:12px;text-align:center;"></i>
                                                Aktifkan
                                            </button>
                                            @endif
                                        </form>

                                        <div style="border-top:1px solid #e5e7eb;margin:3px 0;"></div>

                                        {{-- Hapus --}}
                                        <form method="POST" action="{{ route('admin.customer.destroy', $c->id) }}"
                                              onsubmit="return confirm('Hapus customer {{ addslashes($c->name) }}? Data ini tidak bisa dikembalikan.')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="flex items-center gap-2 w-full px-3 py-2 rounded-lg text-xs text-left transition-colors hover:bg-red-50"
                                                    style="color:#ef4444;background:none;border:none;cursor:pointer;font-family:'Inter',sans-serif;">
                                                <i class="fas fa-trash" style="font-size:10px;width:12px;text-align:center;"></i>
                                                Hapus Akun
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align:center; padding:40px; color:#9ca3af;">
                        <i class="fas fa-users" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                        Belum ada customer.
                        @if(request()->hasAny(['search','status']))
                            <br><a href="{{ route('admin.customer') }}" style="color:#333; text-decoration:underline;">Reset filter</a>
                        @endif
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        </div>

        {{-- Pagination --}}
        @if($customer->hasPages())
        <div class="flex flex-col sm:flex-row items-center justify-between px-4 py-3 gap-3"
             style="border-top:1px solid #e5e7eb;">
            <div style="font-size:11px;color:#6b7280;">
                Halaman <span style="color:#1a1a1a;">{{ $customer->currentPage() }}</span>
                dari <span style="color:#1a1a1a;">{{ $customer->lastPage() }}</span>
                &nbsp;·&nbsp; Total {{ $customer->total() }} customer
            </div>
            {{ $customer->links() }}
        </div>
        @endif

    </div>{{-- /admin-table-wrap --}}


    {{-- ════════════════════════════════════════ --}}
    {{-- MODAL DETAIL CUSTOMER                    --}}
    {{-- ════════════════════════════════════════ --}}
    <div class="modal-overlay" x-show="modalOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="closeModal()">

        <div class="modal-card"
             x-show="modalOpen"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95 translate-y-2"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             @click.stop>

            {{-- Loading state --}}
            <div x-show="loading" style="padding:60px; text-align:center; color:#9ca3af;">
                <i class="fas fa-spinner fa-spin" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                Memuat data...
            </div>

            {{-- Modal Header --}}
            <div class="modal-header" x-show="selected && !loading">
                <div class="flex items-center gap-3">
                    <div style="width:44px;height:44px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-family:'Montserrat',sans-serif;font-weight:700;font-size:14px;flex-shrink:0;background:#f5f5f5;border:1px solid #e5e7eb;color:#1a1a1a;">
                        <span x-text="selected ? selected.nama.charAt(0).toUpperCase() : ''"></span>
                    </div>
                    <div>
                        <div class="font-montserrat font-bold text-[#1a1a1a] text-sm" x-text="selected ? selected.nama : ''"></div>
                        <div class="flex items-center gap-2 mt-0.5">
                            <span style="font-size:11px;color:#6b7280;" x-text="selected ? selected.email : ''"></span>
                            <template x-if="selected && selected.status === 'aktif'">
                                <span class="badge-aktif" style="font-size:9px;padding:1px 6px;">
                                    <i class="fas fa-circle" style="font-size:4px;"></i>Aktif
                                </span>
                            </template>
                            <template x-if="selected && selected.status === 'nonaktif'">
                                <span class="badge-nonaktif" style="font-size:9px;padding:1px 6px;">
                                    <i class="fas fa-circle" style="font-size:4px;"></i>Nonaktif
                                </span>
                            </template>
                        </div>
                    </div>
                </div>
                <button @click="closeModal()"
                        style="width:28px;height:28px;border-radius:7px;border:1px solid #e5e7eb;background:transparent;color:#6b7280;cursor:pointer;display:flex;align-items:center;justify-content:center;transition:all 0.15s;flex-shrink:0;"
                        onmouseover="this.style.borderColor='#333';this.style.color='#1a1a1a';"
                        onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#6b7280';">
                    <i class="fas fa-times" style="font-size:11px;"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body" x-show="selected && !loading">

                {{-- Info Kontak --}}
                <div class="modal-section-title">
                    <i class="fas fa-address-card" style="color:#6b7280;font-size:10px;"></i>
                    Info Kontak
                </div>

                <div class="modal-info-row">
                    <div class="modal-info-icon" style="background:rgba(107,114,128,0.08);border:1px solid rgba(107,114,128,0.15);">
                        <i class="fas fa-envelope" style="color:#6b7280;font-size:11px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Email</div>
                        <div style="font-size:12px;color:#1a1a1a;margin-top:2px;" x-text="selected ? selected.email : ''"></div>
                    </div>
                </div>

                <div class="modal-info-row">
                    <div class="modal-info-icon" style="background:rgba(34,197,94,0.06);border:1px solid rgba(34,197,94,0.1);">
                        <i class="fas fa-phone" style="color:#22c55e;font-size:11px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">No. HP</div>
                        <div style="font-size:12px;color:#1a1a1a;margin-top:2px;" x-text="selected ? selected.no_hp : ''"></div>
                    </div>
                </div>

                <div class="modal-info-row">
                    <div class="modal-info-icon" style="background:rgba(59,130,246,0.06);border:1px solid rgba(59,130,246,0.1);">
                        <i class="fas fa-map-marker-alt" style="color:#3b82f6;font-size:11px;"></i>
                    </div>
                    <div>
                        <div style="font-size:10px;color:#9ca3af;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Alamat</div>
                        <div style="font-size:12px;color:#1a1a1a;margin-top:2px;" x-text="selected ? selected.alamat : ''"></div>
                    </div>
                </div>

                {{-- Statistik --}}
                <div class="modal-section-title" style="margin-top:20px;">
                    <i class="fas fa-chart-bar" style="color:#6b7280;font-size:10px;"></i>
                    Statistik Pembelian
                </div>

                <div class="grid grid-cols-3 gap-3 mb-4">
                    <div class="modal-stat-card">
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:1.3rem;color:#1a1a1a;" x-text="selected ? selected.pesanan_count : 0"></div>
                        <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total Pesanan</div>
                    </div>
                    <div class="modal-stat-card">
                        <div style="font-family:'Montserrat',sans-serif;font-weight:800;font-size:0.85rem;color:#15803d;line-height:1.3;"
                             x-text="selected ? 'Rp ' + new Intl.NumberFormat('id-ID').format(selected.pesanan_sum) : 'Rp 0'"></div>
                        <div style="font-size:10px;color:#6b7280;margin-top:3px;">Total Belanja</div>
                    </div>
                    <div class="modal-stat-card">
                        <div style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:0.75rem;color:#6b7280;line-height:1.4;"
                             x-text="selected ? selected.pesanan_terakhir : '—'"></div>
                        <div style="font-size:10px;color:#6b7280;margin-top:3px;">Pesanan Terakhir</div>
                    </div>
                </div>

                {{-- Riwayat Pesanan --}}
                <div class="modal-section-title" style="margin-top:20px;">
                    <i class="fas fa-receipt" style="color:#6b7280;font-size:10px;"></i>
                    Riwayat Pesanan Terakhir
                </div>

                <template x-if="selected && selected.riwayat && selected.riwayat.length > 0">
                    <div>
                        <template x-for="(order, idx) in selected.riwayat" :key="idx">
                            <div class="mini-order-row">
                                <div style="font-size:11px;font-weight:600;color:#6b7280;width:80px;flex-shrink:0;" x-text="order.no"></div>
                                <div style="font-size:11px;color:#9ca3af;flex:1;" x-text="order.tgl"></div>
                                <div style="font-size:11px;font-weight:600;color:#1a1a1a;width:90px;text-align:right;flex-shrink:0;" x-text="order.total"></div>
                                <div style="width:70px;text-align:right;flex-shrink:0;">
                                    <template x-if="order.status === 'selesai'">
                                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(34,197,94,0.08);border:1px solid rgba(34,197,94,0.2);border-radius:10px;font-size:9px;font-weight:600;color:#15803d;">
                                            <i class="fas fa-check" style="font-size:7px;"></i>Selesai
                                        </span>
                                    </template>
                                    <template x-if="order.status === 'diproses'">
                                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(59,130,246,0.08);border:1px solid rgba(59,130,246,0.2);border-radius:10px;font-size:9px;font-weight:600;color:#1d4ed8;">
                                            <i class="fas fa-cog" style="font-size:7px;"></i>Diproses
                                        </span>
                                    </template>
                                    <template x-if="order.status === 'pending'">
                                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(234,179,8,0.08);border:1px solid rgba(234,179,8,0.2);border-radius:10px;font-size:9px;font-weight:600;color:#b45309;">
                                            <i class="fas fa-clock" style="font-size:7px;"></i>Pending
                                        </span>
                                    </template>
                                    <template x-if="order.status === 'dikirim'">
                                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(139,92,246,0.08);border:1px solid rgba(139,92,246,0.2);border-radius:10px;font-size:9px;font-weight:600;color:#6d28d9;">
                                            <i class="fas fa-truck" style="font-size:7px;"></i>Dikirim
                                        </span>
                                    </template>
                                    <template x-if="order.status === 'dibatalkan'">
                                        <span style="display:inline-flex;align-items:center;gap:3px;padding:2px 7px;background:rgba(239,68,68,0.08);border:1px solid rgba(239,68,68,0.2);border-radius:10px;font-size:9px;font-weight:600;color:#dc2626;">
                                            <i class="fas fa-times" style="font-size:7px;"></i>Batal
                                        </span>
                                    </template>
                                </div>
                            </div>
                        </template>
                    </div>
                </template>

                <template x-if="selected && (!selected.riwayat || selected.riwayat.length === 0)">
                    <p style="font-size:12px;color:#9ca3af;text-align:center;padding:16px 0;">
                        Belum ada riwayat pesanan.
                    </p>
                </template>

                {{-- Tombol aksi --}}
                <div class="flex items-center gap-3 mt-5 pt-4" style="border-top:1px solid #e5e7eb;">
                    <button class="btn-admin-primary" style="flex:1; justify-content:center;" @click="closeModal()">
                        <i class="fas fa-times" style="font-size:10px;"></i>
                        Tutup
                    </button>
                </div>

            </div>{{-- /modal-body --}}
        </div>{{-- /modal-card --}}
    </div>{{-- /modal-overlay --}}

</div>{{-- /x-data --}}

@endsection
