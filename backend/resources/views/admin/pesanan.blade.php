@extends('layouts.admin')

@section('title', 'Kelola Pesanan - Admin')
@section('header-title', 'Kelola Pesanan')

@section('styles')
<style>
    /* ── Kelola Pesanan ── */

    .filter-input {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a;
        font-size: 12px;
        font-family: 'Inter', sans-serif;
        padding: 8px 12px;
        outline: none;
        transition: border-color 0.2s;
    }
    .filter-input:focus { border-color: #333; }
    .filter-input::placeholder { color: #9ca3af; }
    select.filter-input { cursor: pointer; }

    /* Stat mini cards */
    .stat-mini {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 14px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        transition: all 0.2s;
    }
    .stat-mini:hover { border-color: #d1d5db; box-shadow: 0 2px 8px rgba(0,0,0,0.06); }
    .stat-mini-icon {
        width: 36px; height: 36px;
        border-radius: 9px;
        display: flex; align-items: center; justify-content: center;
        font-size: 14px;
        flex-shrink: 0;
    }

    /* Table */
    .ord-table { width: 100%; border-collapse: collapse; }
    .ord-table th {
        text-align: left;
        padding: 10px 14px;
        font-size: 10px; font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.08em; text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        background: #f5f5f5;
        white-space: nowrap;
    }
    .ord-table td {
        padding: 12px 14px;
        font-size: 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .ord-table tr:last-child td { border-bottom: none; }
    .ord-table tbody tr:hover td { background: #faf8f5; }

    /* Status badges */
    .badge {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 3px 9px; border-radius: 12px;
        font-size: 10px; font-weight: 700;
        letter-spacing: 0.03em; white-space: nowrap;
    }
    .badge::before { content:''; width:5px; height:5px; border-radius:50%; flex-shrink:0; }

    .badge-pending    { background:rgba(234,179,8,0.1);  border:1px solid rgba(234,179,8,0.3);  color:#b45309; }
    .badge-pending::before    { background:#eab308; }
    .badge-diproses   { background:rgba(59,130,246,0.1); border:1px solid rgba(59,130,246,0.3); color:#1d4ed8; }
    .badge-diproses::before   { background:#3b82f6; }
    .badge-dikirim    { background:rgba(139,92,246,0.1); border:1px solid rgba(139,92,246,0.3); color:#6d28d9; }
    .badge-dikirim::before    { background:#8b5cf6; }
    .badge-selesai    { background:rgba(34,197,94,0.1);  border:1px solid rgba(34,197,94,0.3);  color:#15803d; }
    .badge-selesai::before    { background:#22c55e; }
    .badge-dibatalkan { background:rgba(239,68,68,0.1);  border:1px solid rgba(239,68,68,0.3);  color:#dc2626; }
    .badge-dibatalkan::before { background:#ef4444; }

    .badge-fisik    { background:rgba(168,85,247,0.08); border:1px solid rgba(168,85,247,0.2); color:#7c3aed; font-size:9px; }
    .badge-digital  { background:rgba(51,51,51,0.07);   border:1px solid rgba(51,51,51,0.15);  color:#333333; font-size:9px; }

    /* Action buttons */
    .tbl-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; border-radius: 6px;
        font-size: 11px; font-weight: 500;
        cursor: pointer; transition: all 0.2s;
        text-decoration: none; white-space: nowrap;
        font-family: 'Inter', sans-serif; border: none;
    }
    .tbl-btn-detail {
        background: #ffffff;
        border: 1px solid #333333 !important;
        color: #333333;
    }
    .tbl-btn-detail:hover { background: #f5f5f5; }
    .tbl-btn-del {
        background: rgba(239,68,68,0.06);
        border: 1px solid rgba(239,68,68,0.2) !important;
        color: #ef4444;
    }
    .tbl-btn-del:hover { background: rgba(239,68,68,0.14); }

    /* Pagination */
    .page-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px; border-radius: 6px;
        font-size: 11px; font-weight: 600;
        cursor: pointer; transition: all 0.15s;
        border: 1px solid #e5e7eb; color: #6b7280;
        background: #ffffff; font-family: 'Inter', sans-serif;
    }
    .page-btn:hover { border-color: #333; color: #1a1a1a; }
    .page-btn.active { background:#1a1a1a; border-color:#1a1a1a; color:#ffffff; }

    /* Modal */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(5px);
        z-index: 200;
        display: flex; align-items: flex-start; justify-content: center;
        padding: 20px 16px;
        overflow-y: auto;
    }
    .modal-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        width: 100%; max-width: 760px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        overflow: hidden; flex-shrink: 0;
    }
    .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        background: #faf8f5;
        flex-wrap: wrap; gap: 10px;
    }
    .modal-body { padding: 22px; }
    .modal-footer {
        padding: 14px 22px;
        border-top: 1px solid #e5e7eb;
        display: flex; justify-content: flex-end; gap: 10px;
        background: #faf8f5;
    }

    /* Modal section */
    .modal-section {
        margin-bottom: 16px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        overflow: hidden;
    }
    .modal-section-header {
        padding: 10px 16px;
        border-bottom: 1px solid #e5e7eb;
        background: #faf8f5;
        display: flex; align-items: center; gap: 8px;
    }
    .modal-section-body { padding: 16px; background: #ffffff; }

    /* Info row */
    .info-row {
        display: flex; justify-content: space-between; align-items: flex-start;
        padding: 7px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 12px; gap: 12px;
    }
    .info-row:last-child { border-bottom: none; }

    /* Produk row modal */
    .prod-row-modal {
        display: flex; align-items: center; gap: 12px;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
    }
    .prod-row-modal:last-child { border-bottom: none; }

    /* Form input modal */
    .modal-input {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 7px;
        color: #1a1a1a; font-size: 12px;
        font-family: 'Inter', sans-serif;
        padding: 8px 12px;
        outline: none; transition: border-color 0.2s;
    }
    .modal-input:focus { border-color: #333; }
    select.modal-input { cursor: pointer; }

    /* Timeline */
    .timeline-item {
        display: flex; gap: 12px;
        padding-bottom: 16px; position: relative;
    }
    .timeline-item:last-child { padding-bottom: 0; }
    .timeline-item:not(:last-child)::before {
        content: ''; position: absolute;
        left: 11px; top: 24px; bottom: 0; width: 1px;
        background: linear-gradient(to bottom, #e5e7eb, transparent);
    }
    .tl-dot {
        width: 24px; height: 24px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0; border: 1px solid #e5e7eb;
        background: #f5f5f5; position: relative; z-index: 1;
    }
    .tl-dot.done { background:#e5e7eb; border-color:#9ca3af; }
    .tl-dot.active { background:#1a1a1a; border-color:#1a1a1a; box-shadow:0 2px 6px rgba(0,0,0,0.2); }
    .tl-dot.active i { color: #ffffff !important; }

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

    /* Pagination override */
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
        <div class="font-semibold mb-1">Terjadi kesalahan:</div>
        <ul style="margin:0; padding-left:16px;">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>
@endif

<div x-data="{
    showModal: false,
    order: {},
    newStatus: '',
    newResi: '',

    openDetail(data) {
        this.order = data;
        this.newStatus = data.status;
        this.newResi = data.no_resi || '';
        this.showModal = true;
        this.$nextTick(() => {
            const form = document.getElementById('formUpdateStatus');
            if (form) form.action = '/admin/pesanan/' + data.id + '/status';
            const sel = document.getElementById('selectStatus');
            if (sel) sel.value = data.status;
            const resi = document.getElementById('inputResi');
            if (resi) resi.value = data.no_resi || '';
        });
    },
    closeModal() { this.showModal = false; },
    statusColor(s) {
        const c = { pending:'#b45309', diproses:'#1d4ed8', dikirim:'#6d28d9', selesai:'#15803d', dibatalkan:'#dc2626' };
        return c[s] || '#6b7280';
    },
    statusBg(s) {
        const c = { pending:'rgba(234,179,8,0.1)', diproses:'rgba(59,130,246,0.1)', dikirim:'rgba(139,92,246,0.1)', selesai:'rgba(34,197,94,0.1)', dibatalkan:'rgba(239,68,68,0.1)' };
        return c[s] || 'rgba(107,114,128,0.1)';
    }
}">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="font-montserrat font-bold text-[#1a1a1a] text-xl">Kelola Pesanan</h2>
            <p class="text-xs mt-1" style="color:#6b7280;">
                Total <span style="color:#1a1a1a; font-weight:600;">{{ $stats['total'] }}</span> pesanan
                &nbsp;·&nbsp; <span style="color:#15803d;">{{ $stats['selesai'] }} selesai</span>
                &nbsp;·&nbsp; <span style="color:#b45309;">{{ $stats['pending'] }} menunggu</span>
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.pesanan') }}" class="btn-admin-outline gap-2" style="padding:8px 14px;">
                <i class="fas fa-sync-alt" style="font-size:10px;"></i> Refresh
            </a>
        </div>
    </div>

    {{-- ── Stats Mini ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-3 mb-5">
        @foreach([
            ['label'=>'Pending',    'key'=>'pending',    'color'=>'#b45309','bg'=>'rgba(234,179,8,0.1)',   'border'=>'rgba(234,179,8,0.3)',   'icon'=>'fa-clock'],
            ['label'=>'Diproses',   'key'=>'diproses',   'color'=>'#1d4ed8','bg'=>'rgba(59,130,246,0.1)',  'border'=>'rgba(59,130,246,0.3)',  'icon'=>'fa-cog'],
            ['label'=>'Dikirim',    'key'=>'dikirim',    'color'=>'#6d28d9','bg'=>'rgba(139,92,246,0.1)',  'border'=>'rgba(139,92,246,0.3)',  'icon'=>'fa-truck'],
            ['label'=>'Selesai',    'key'=>'selesai',    'color'=>'#15803d','bg'=>'rgba(34,197,94,0.1)',   'border'=>'rgba(34,197,94,0.3)',   'icon'=>'fa-check-circle'],
            ['label'=>'Dibatalkan', 'key'=>'dibatalkan', 'color'=>'#dc2626','bg'=>'rgba(239,68,68,0.1)',   'border'=>'rgba(239,68,68,0.3)',   'icon'=>'fa-times-circle'],
        ] as $s)
        <a href="{{ route('admin.pesanan', ['status' => $s['key']]) }}"
           class="stat-mini {{ request('status') === $s['key'] ? 'ring-2 ring-offset-1' : '' }}"
           style="border-color:{{ $s['border'] }}; text-decoration:none;">
            <div class="stat-mini-icon" style="background:{{ $s['bg'] }}; border:1px solid {{ $s['border'] }};">
                <i class="fas {{ $s['icon'] }}" style="color:{{ $s['color'] }};"></i>
            </div>
            <div>
                <div class="font-montserrat font-bold text-[#1a1a1a] text-xl leading-none">{{ $stats[$s['key']] }}</div>
                <div class="text-xs mt-1" style="color:#6b7280;">{{ $s['label'] }}</div>
            </div>
        </a>
        @endforeach
    </div>

    {{-- ── Filter & Search ── --}}
    <form method="GET" action="{{ route('admin.pesanan') }}"
          class="flex flex-wrap gap-3 mb-4 p-4 rounded-xl" style="background:#f5f5f5; border:1px solid #e5e7eb;">
        <div class="relative flex-1" style="min-width:200px;">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color:#9ca3af; font-size:11px;"></i>
            <input type="text" name="search" placeholder="Cari no. order, nama customer..."
                   value="{{ request('search') }}"
                   class="filter-input w-full" style="padding-left:34px;">
        </div>
        <select name="status" class="filter-input" style="min-width:140px;">
            <option value="">Semua Status</option>
            @foreach(['pending','diproses','dikirim','selesai','dibatalkan'] as $st)
            <option value="{{ $st }}" {{ request('status') === $st ? 'selected' : '' }}>{{ ucfirst($st) }}</option>
            @endforeach
        </select>
        <select name="tipe" class="filter-input" style="min-width:120px;">
            <option value="">Semua Tipe</option>
            <option value="fisik"   {{ request('tipe') === 'fisik'   ? 'selected' : '' }}>Fisik</option>
            <option value="digital" {{ request('tipe') === 'digital' ? 'selected' : '' }}>Digital</option>
        </select>
        <button type="submit" class="btn-admin-outline gap-1.5" style="padding:8px 14px;">
            <i class="fas fa-filter" style="font-size:10px;"></i> Terapkan
        </button>
        <a href="{{ route('admin.pesanan') }}" class="btn-admin-outline gap-1" style="padding:8px 11px;">
            <i class="fas fa-times" style="font-size:11px;"></i>
        </a>
    </form>

    {{-- ── Tabel Pesanan ── --}}
    <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">

        {{-- Topbar --}}
        <div style="padding:12px 16px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <span class="text-xs" style="color:#6b7280;">
                {{ $pesanan->total() }} pesanan ditemukan
                &nbsp;·&nbsp; Total:
                <strong style="color:#1a1a1a;">Rp {{ number_format($pesanan->sum('total'), 0, ',', '.') }}</strong>
            </span>
            <div class="flex items-center gap-2 text-xs" style="color:#6b7280;">
                <i class="fas fa-sort-amount-down" style="font-size:10px;"></i> Terbaru
            </div>
        </div>

        <div style="overflow-x:auto;">
            <table class="ord-table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Customer</th>
                        <th>Tipe</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th style="width:150px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pesanan as $p)
                    <tr>
                        {{-- No Order --}}
                        <td>
                            <div class="font-montserrat font-bold" style="color:#1a1a1a; font-size:11px; letter-spacing:0.03em;">
                                #{{ $p->no_order }}
                            </div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">#{{ $p->id }}</div>
                        </td>

                        {{-- Customer --}}
                        <td>
                            <div class="font-semibold text-[#1a1a1a] text-xs">{{ $p->user?->name ?? '—' }}</div>
                            <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $p->user?->email ?? '' }}</div>
                        </td>

                        {{-- Tipe --}}
                        <td>
                            <span class="badge {{ $p->tipe_pesanan === 'digital' ? 'badge-digital' : 'badge-fisik' }}">
                                <i class="fas {{ $p->tipe_pesanan === 'digital' ? 'fa-file-pdf' : 'fa-box' }}" style="font-size:8px; margin-right:2px;"></i>
                                {{ ucfirst($p->tipe_pesanan) }}
                            </span>
                        </td>

                        {{-- Total --}}
                        <td>
                            <span class="font-montserrat font-bold" style="color:#1a1a1a; font-size:12px;">
                                Rp {{ number_format($p->total, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge badge-{{ $p->status }}">
                                @switch($p->status)
                                    @case('pending')    <i class="fas fa-clock" style="font-size:8px;"></i> Pending    @break
                                    @case('diproses')   <i class="fas fa-cog" style="font-size:8px;"></i> Diproses   @break
                                    @case('dikirim')    <i class="fas fa-truck" style="font-size:8px;"></i> Dikirim    @break
                                    @case('selesai')    <i class="fas fa-check-circle" style="font-size:8px;"></i> Selesai    @break
                                    @case('dibatalkan') <i class="fas fa-times-circle" style="font-size:8px;"></i> Dibatalkan @break
                                @endswitch
                            </span>
                            @if($p->no_resi)
                            <div class="text-xs mt-1" style="color:#6b7280;">
                                <i class="fas fa-receipt" style="font-size:9px;"></i> {{ $p->no_resi }}
                            </div>
                            @endif
                        </td>

                        {{-- Tanggal --}}
                        <td>
                            <span class="text-xs" style="color:#6b7280;">
                                {{ $p->tgl_order ? $p->tgl_order->format('d M Y · H:i') : $p->created_at->format('d M Y · H:i') }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="flex items-center gap-1.5">
                                {{-- Tombol Detail/Update Status --}}
                                <button class="tbl-btn tbl-btn-detail"
                                    @click="openDetail({{ json_encode([
                                        'id'          => $p->id,
                                        'no_order'    => $p->no_order,
                                        'status'      => $p->status,
                                        'tipe_pesanan'=> $p->tipe_pesanan,
                                        'total'       => $p->total,
                                        'no_resi'     => $p->no_resi,
                                        'kurir'       => $p->kurir,
                                        'alamat'      => $p->alamat,
                                        'customer'    => $p->user?->name,
                                        'email'       => $p->user?->email,
                                        'tanggal'     => $p->tgl_order ? $p->tgl_order->format('d M Y H:i') : $p->created_at->format('d M Y H:i'),
                                        'items'       => $p->detailPesanans->map(fn($d) => [
                                            'nama'    => $d->produk?->nama_produk ?? 'Produk dihapus',
                                            'jumlah'  => $d->jumlah,
                                            'harga'   => $d->harga,
                                            'subtotal'=> $d->subtotal,
                                        ])->toArray(),
                                    ]) }})">
                                    <i class="fas fa-eye" style="font-size:9px;"></i> Detail
                                </button>

                                {{-- Tombol Hapus --}}
                                <form method="POST"
                                      action="{{ route('admin.pesanan.destroy', $p->id) }}"
                                      onsubmit="return confirm('Hapus pesanan #{{ $p->no_order }}? Tindakan ini tidak bisa dibatalkan.')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="tbl-btn tbl-btn-del">
                                        <i class="fas fa-trash" style="font-size:9px;"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" style="text-align:center; padding:40px; color:#9ca3af;">
                            <i class="fas fa-inbox" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                            Belum ada pesanan.
                            @if(request()->hasAny(['search','status','tipe']))
                                <br><a href="{{ route('admin.pesanan') }}" style="color:#333; text-decoration:underline;">Reset filter</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pesanan->hasPages())
        <div style="padding:12px 16px; border-top:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; background:#faf8f5;">
            <span class="text-xs" style="color:#6b7280;">
                Halaman {{ $pesanan->currentPage() }} dari {{ $pesanan->lastPage() }}
            </span>
            {{ $pesanan->links() }}
        </div>
        @endif
    </div>


    {{-- ════════════════════════════════════════════════════ --}}
    {{-- MODAL DETAIL + UPDATE STATUS PESANAN                 --}}
    {{-- ════════════════════════════════════════════════════ --}}
    <div class="modal-overlay"
         x-show="showModal"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @click.self="closeModal()">

        <div class="modal-card"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0 scale-95"
             x-transition:enter-end="opacity-100 scale-100"
             @click.stop>

            {{-- Modal Header --}}
            <div class="modal-header">
                <div>
                    <div class="flex items-center gap-3 flex-wrap">
                        <span class="font-montserrat font-bold text-[#1a1a1a] text-sm"
                              x-text="'#' + (order.no_order || '')"></span>
                        <span class="badge"
                              :class="'badge-' + order.status"
                              x-text="order.status ? order.status.charAt(0).toUpperCase() + order.status.slice(1) : ''">
                        </span>
                        <span class="badge"
                              :class="order.tipe_pesanan === 'digital' ? 'badge-digital' : 'badge-fisik'"
                              x-text="order.tipe_pesanan ? order.tipe_pesanan.charAt(0).toUpperCase() + order.tipe_pesanan.slice(1) : ''">
                        </span>
                    </div>
                    <div class="text-xs mt-1" style="color:#6b7280;" x-text="order.tanggal || ''"></div>
                </div>
                <button @click="closeModal()"
                        style="width:28px; height:28px; border-radius:6px; background:transparent; border:1px solid #e5e7eb; color:#6b7280; display:flex; align-items:center; justify-content:center; cursor:pointer;">
                    <i class="fas fa-times" style="font-size:11px;"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <div class="modal-body" style="max-height:72vh; overflow-y:auto;">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    {{-- KIRI: Produk + Info Customer --}}
                    <div>
                        {{-- Produk Dipesan --}}
                        <div class="modal-section">
                            <div class="modal-section-header">
                                <i class="fas fa-box" style="color:#6b7280; font-size:11px;"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Produk Dipesan</span>
                            </div>
                            <div class="modal-section-body" style="padding:10px 16px;">
                                <template x-for="(item, i) in (order.items || [])" :key="i">
                                    <div class="prod-row-modal">
                                        <div style="width:36px; height:36px; border-radius:7px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                            <i class="fas fa-file-alt" style="color:#9ca3af; font-size:13px;"></i>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="text-xs font-semibold text-[#1a1a1a] truncate" x-text="item.nama"></div>
                                            <div class="text-xs mt-0.5" style="color:#6b7280;">
                                                Qty: <span x-text="item.jumlah"></span>
                                                &nbsp;×&nbsp;
                                                <span x-text="'Rp ' + parseInt(item.harga).toLocaleString('id-ID')"></span>
                                            </div>
                                        </div>
                                        <div class="text-right shrink-0">
                                            <div class="font-montserrat font-bold text-xs" style="color:#1a1a1a;"
                                                 x-text="'Rp ' + parseInt(item.subtotal).toLocaleString('id-ID')"></div>
                                        </div>
                                    </div>
                                </template>
                                {{-- Total --}}
                                <div style="border-top:1px solid #e5e7eb; margin-top:8px; padding-top:10px; display:flex; justify-content:space-between;">
                                    <span class="font-semibold text-sm text-[#1a1a1a]">Total</span>
                                    <span class="font-montserrat font-bold" style="color:#1a1a1a; font-size:1.1rem;"
                                          x-text="'Rp ' + parseInt(order.total || 0).toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                        {{-- Info Customer --}}
                        <div class="modal-section">
                            <div class="modal-section-header">
                                <i class="fas fa-user" style="color:#6b7280; font-size:11px;"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Info Customer</span>
                            </div>
                            <div class="modal-section-body">
                                <div class="info-row">
                                    <span style="color:#6b7280;">Nama</span>
                                    <span class="font-semibold text-[#1a1a1a] text-xs" x-text="order.customer || '—'"></span>
                                </div>
                                <div class="info-row">
                                    <span style="color:#6b7280;">Email</span>
                                    <span class="text-xs" style="color:#6b7280;" x-text="order.email || '—'"></span>
                                </div>
                                <div class="info-row" x-show="order.tipe_pesanan === 'fisik'">
                                    <span style="color:#6b7280;">Alamat</span>
                                    <span class="text-xs" style="color:#6b7280; max-width:180px; text-align:right;" x-text="order.alamat || 'Tidak ada'"></span>
                                </div>
                                <div class="info-row" x-show="order.tipe_pesanan === 'fisik'">
                                    <span style="color:#6b7280;">Kurir</span>
                                    <span class="text-xs font-semibold text-[#1a1a1a]" x-text="order.kurir || 'Belum dipilih'"></span>
                                </div>
                                <div class="info-row" x-show="order.no_resi">
                                    <span style="color:#6b7280;">No. Resi</span>
                                    <span class="text-xs font-semibold" style="color:#1d4ed8;" x-text="order.no_resi"></span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- KANAN: Update Status --}}
                    <div>
                        {{-- Form Update Status --}}
                        <div class="modal-section">
                            <div class="modal-section-header">
                                <i class="fas fa-exchange-alt" style="color:#6b7280; font-size:11px;"></i>
                                <span class="text-xs font-semibold uppercase tracking-wide" style="color:#6b7280;">Update Status Pesanan</span>
                            </div>
                            <div class="modal-section-body">
                                <form id="formUpdateStatus" method="POST" action="">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="text-xs font-semibold uppercase tracking-wide mb-2 block" style="color:#6b7280;">Status Baru</label>
                                        <select id="selectStatus" name="status" class="modal-input" x-model="newStatus">
                                            <option value="pending">Pending</option>
                                            <option value="diproses">Diproses</option>
                                            <option value="dikirim">Dikirim</option>
                                            <option value="selesai">Selesai</option>
                                            <option value="dibatalkan">Dibatalkan</option>
                                        </select>
                                    </div>

                                    {{-- Input Resi (muncul kalau fisik & status dikirim) --}}
                                    <div x-show="order.tipe_pesanan === 'fisik' && newStatus === 'dikirim'" class="mb-3">
                                        <label class="text-xs font-semibold uppercase tracking-wide mb-2 block" style="color:#6b7280;">
                                            No. Resi Pengiriman <span style="color:#ef4444;">*</span>
                                        </label>
                                        <input type="text" id="inputResi" name="no_resi" class="modal-input"
                                               placeholder="Contoh: JNE123456789"
                                               x-model="newResi">
                                    </div>

                                    {{-- Timeline --}}
                                    <div class="mt-4">
                                        <div class="text-xs font-semibold uppercase tracking-wide mb-3" style="color:#6b7280;">Timeline Status</div>
                                        @php
                                        $timeline = [
                                            ['label' => 'Pesanan Dibuat',          'status' => 'pending'],
                                            ['label' => 'Diproses / Dikonfirmasi', 'status' => 'diproses'],
                                            ['label' => 'Dikirim',                 'status' => 'dikirim'],
                                            ['label' => 'Selesai',                 'status' => 'selesai'],
                                        ];
                                        $statusOrder = ['pending'=>0,'diproses'=>1,'dikirim'=>2,'selesai'=>3,'dibatalkan'=>4];
                                        @endphp
                                        @foreach($timeline as $tl)
                                        <div class="timeline-item">
                                            <div class="tl-dot"
                                                 :class="{
                                                     'active': order.status === '{{ $tl['status'] }}',
                                                     'done': ['pending','diproses','dikirim','selesai'].indexOf(order.status) > ['pending','diproses','dikirim','selesai'].indexOf('{{ $tl['status'] }}')
                                                 }">
                                                <i class="fas fa-check" style="font-size:7px; color:#9ca3af;"></i>
                                            </div>
                                            <div class="flex-1 pt-0.5">
                                                <span class="text-xs font-semibold"
                                                      :style="{
                                                          color: order.status === '{{ $tl['status'] }}' ? '#1a1a1a' : '#9ca3af'
                                                      }">
                                                    {{ $tl['label'] }}
                                                </span>
                                            </div>
                                        </div>
                                        @endforeach
                                        {{-- Dibatalkan --}}
                                        <div class="timeline-item" x-show="order.status === 'dibatalkan'">
                                            <div class="tl-dot active" style="background:#ef4444; border-color:#ef4444;">
                                                <i class="fas fa-times" style="font-size:7px; color:#ffffff;"></i>
                                            </div>
                                            <div class="flex-1 pt-0.5">
                                                <span class="text-xs font-semibold" style="color:#dc2626;">Dibatalkan</span>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Tombol Submit --}}
                                    <div class="mt-4 flex gap-2">
                                        <button type="submit" class="btn-admin-primary gap-2" style="flex:1; justify-content:center;">
                                            <i class="fas fa-save" style="font-size:11px;"></i> Simpan Status
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            {{-- Modal Footer --}}
            <div class="modal-footer">
                <button @click="closeModal()" class="btn-admin-outline gap-2">
                    <i class="fas fa-times" style="font-size:10px;"></i> Tutup
                </button>
            </div>

        </div>
    </div>{{-- end modal --}}

</div>{{-- end x-data --}}
@endsection
