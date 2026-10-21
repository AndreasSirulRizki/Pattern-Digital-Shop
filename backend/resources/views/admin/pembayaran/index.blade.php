@extends('layouts.admin')

@section('title', 'Verifikasi Pembayaran - Admin')
@section('header-title', 'Verifikasi Pembayaran')

@section('styles')
<style>
    /* ── Filter ── */
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

    /* ── Stat mini cards ── */
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
        font-size: 14px; flex-shrink: 0;
    }

    /* ── Table ── */
    .pay-table { width: 100%; border-collapse: collapse; }
    .pay-table th {
        text-align: left;
        padding: 10px 14px;
        font-size: 10px; font-weight: 700;
        text-transform: uppercase; letter-spacing: 0.08em;
        color: #9ca3af;
        background: #f9fafb;
        border-bottom: 1px solid #e5e7eb;
    }
    .pay-table td {
        padding: 12px 14px;
        font-size: 13px;
        color: #1a1a1a;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .pay-table tr:last-child td { border-bottom: none; }
    .pay-table tr:hover td { background: #fafafa; }

    /* ── Status badges ── */
    .badge {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 3px 9px; border-radius: 20px;
        font-size: 11px; font-weight: 600; white-space: nowrap;
    }
    .badge::before { content:''; width:5px; height:5px; border-radius:50%; display:inline-block; }
    .badge-pending  { background:rgba(234,179,8,0.1);  border:1px solid rgba(234,179,8,0.3);  color:#d97706; }
    .badge-pending::before  { background:#d97706; }
    .badge-berhasil { background:rgba(22,163,74,0.1);  border:1px solid rgba(22,163,74,0.25); color:#16a34a; }
    .badge-berhasil::before { background:#16a34a; }
    .badge-gagal    { background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2);  color:#dc2626; }
    .badge-gagal::before    { background:#dc2626; }

    /* ── Metode badges ── */
    .badge-qris     { background:rgba(59,130,246,0.08); border:1px solid rgba(59,130,246,0.2); color:#1d4ed8; font-size:10px; font-weight:700; padding:2px 7px; border-radius:5px; }
    .badge-transfer { background:rgba(168,85,247,0.08); border:1px solid rgba(168,85,247,0.2); color:#7c3aed; font-size:10px; font-weight:700; padding:2px 7px; border-radius:5px; }
    .badge-cod      { background:rgba(234,179,8,0.08);  border:1px solid rgba(234,179,8,0.2);  color:#d97706; font-size:10px; font-weight:700; padding:2px 7px; border-radius:5px; }

    /* ── Aksi buttons ── */
    .btn-verif {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 6px 12px; border-radius: 7px;
        font-size: 11px; font-weight: 600;
        cursor: pointer; border: none;
        transition: all 0.2s; text-decoration: none;
    }
    .btn-verif-ok {
        background: rgba(22,163,74,0.1); color: #16a34a;
        border: 1px solid rgba(22,163,74,0.25);
    }
    .btn-verif-ok:hover  { background: #16a34a; color: #ffffff; }
    .btn-verif-batal {
        background: rgba(239,68,68,0.08); color: #dc2626;
        border: 1px solid rgba(239,68,68,0.2);
    }
    .btn-verif-batal:hover { background: #dc2626; color: #ffffff; }

    /* ── Bukti image preview ── */
    .bukti-thumb {
        width: 44px; height: 44px;
        border-radius: 6px;
        object-fit: cover;
        border: 1px solid #e5e7eb;
        cursor: pointer;
        transition: all 0.2s;
    }
    .bukti-thumb:hover { border-color: #9ca3af; transform: scale(1.05); }

    /* ── Lightbox overlay ── */
    .lightbox {
        position: fixed; inset: 0; z-index: 9999;
        background: rgba(0,0,0,0.85);
        display: flex; align-items: center; justify-content: center;
        padding: 20px;
    }
    .lightbox img {
        max-width: 90vw; max-height: 85vh;
        border-radius: 10px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.4);
    }
    .lightbox-close {
        position: absolute; top: 16px; right: 20px;
        color: #ffffff; font-size: 22px;
        cursor: pointer; background: rgba(255,255,255,0.1);
        width: 36px; height: 36px; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        transition: background 0.2s;
    }
    .lightbox-close:hover { background: rgba(255,255,255,0.2); }

    /* ── Table container ── */
    .table-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 1px 4px rgba(0,0,0,0.04);
    }

    /* ── Empty state ── */
    .empty-state {
        padding: 60px 24px;
        text-align: center;
        color: #9ca3af;
    }
</style>
@endsection

@section('content')
<div x-data="{ lightboxSrc: '', showLightbox: false }">

    {{-- ── Flash ── --}}
    @if(session('success'))
    <div class="mb-5 flex items-center gap-3 p-3 rounded-lg text-sm"
         style="background:rgba(22,163,74,0.08); border:1px solid rgba(22,163,74,0.2); color:#16a34a;">
        <i class="fas fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    {{-- ── Stats ── --}}
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mb-6">
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fef9c3;">
                <i class="fas fa-clock" style="color:#d97706;"></i>
            </div>
            <div>
                <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $stats['pending'] }}</div>
                <div class="text-xs mt-0.5" style="color:#6b7280;">Menunggu</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#dcfce7;">
                <i class="fas fa-check-circle" style="color:#16a34a;"></i>
            </div>
            <div>
                <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $stats['berhasil'] }}</div>
                <div class="text-xs mt-0.5" style="color:#6b7280;">Terverifikasi</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#fee2e2;">
                <i class="fas fa-times-circle" style="color:#dc2626;"></i>
            </div>
            <div>
                <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $stats['gagal'] }}</div>
                <div class="text-xs mt-0.5" style="color:#6b7280;">Ditolak</div>
            </div>
        </div>
        <div class="stat-mini">
            <div class="stat-mini-icon" style="background:#f5f5f5;">
                <i class="fas fa-list" style="color:#6b7280;"></i>
            </div>
            <div>
                <div class="font-montserrat font-bold text-[#1a1a1a] text-lg leading-none">{{ $stats['total'] }}</div>
                <div class="text-xs mt-0.5" style="color:#6b7280;">Total</div>
            </div>
        </div>
    </div>

    {{-- ── Filter Bar ── --}}
    <div class="flex flex-wrap gap-3 items-center justify-between mb-4">
        <form method="GET" action="{{ route('admin.pembayaran') }}" class="flex gap-2 flex-wrap">
            <select name="status" class="filter-input" onchange="this.form.submit()">
                <option value="">Semua Status</option>
                <option value="pending"  {{ request('status') === 'pending'  ? 'selected' : '' }}>Menunggu</option>
                <option value="berhasil" {{ request('status') === 'berhasil' ? 'selected' : '' }}>Terverifikasi</option>
                <option value="gagal"    {{ request('status') === 'gagal'    ? 'selected' : '' }}>Ditolak</option>
            </select>
            <select name="metode" class="filter-input" onchange="this.form.submit()">
                <option value="">Semua Metode</option>
                <option value="qris"     {{ request('metode') === 'qris'     ? 'selected' : '' }}>QRIS</option>
                <option value="transfer" {{ request('metode') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                <option value="cod"      {{ request('metode') === 'cod'      ? 'selected' : '' }}>COD</option>
            </select>
            @if(request()->hasAny(['status','metode']))
            <a href="{{ route('admin.pembayaran') }}"
               class="flex items-center gap-1.5 px-3 py-2 rounded-lg text-xs"
               style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280;">
                <i class="fas fa-times" style="font-size:9px;"></i> Reset
            </a>
            @endif
        </form>

        <div class="text-xs" style="color:#9ca3af;">
            Menampilkan {{ $pembayaran->count() }} dari {{ $pembayaran->total() }} data
        </div>
    </div>

    {{-- ── Table ── --}}
    <div class="table-card">
        <div style="overflow-x:auto;">
            <table class="pay-table">
                <thead>
                    <tr>
                        <th>No. Order</th>
                        <th>Customer</th>
                        <th>Metode</th>
                        <th>Total</th>
                        <th>Bukti</th>
                        <th>Status</th>
                        <th>Tgl. Masuk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pembayaran as $item)
                    <tr>
                        {{-- No. Order --}}
                        <td>
                            <span class="font-mono font-semibold text-xs" style="color:#1a1a1a;">
                                {{ $item->pesanan->no_order ?? '-' }}
                            </span>
                        </td>

                        {{-- Customer --}}
                        <td>
                            <div class="font-medium text-sm" style="color:#1a1a1a;">
                                {{ $item->pesanan->user->name ?? '-' }}
                            </div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">
                                {{ $item->pesanan->user->email ?? '' }}
                            </div>
                        </td>

                        {{-- Metode --}}
                        <td>
                            @if($item->metode === 'qris')
                                <span class="badge-qris"><i class="fas fa-qrcode mr-1"></i>QRIS</span>
                            @elseif($item->metode === 'transfer')
                                <span class="badge-transfer"><i class="fas fa-university mr-1"></i>Transfer</span>
                            @else
                                <span class="badge-cod"><i class="fas fa-money-bill-wave mr-1"></i>COD</span>
                            @endif
                        </td>

                        {{-- Total --}}
                        <td>
                            <span class="font-montserrat font-semibold text-sm">
                                Rp {{ number_format($item->pesanan->total ?? 0, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Bukti --}}
                        <td>
                            @if($item->bukti)
                                <img src="{{ asset('storage/' . $item->bukti) }}"
                                     alt="Bukti Pembayaran"
                                     class="bukti-thumb"
                                     @click="lightboxSrc='{{ asset('storage/' . $item->bukti) }}'; showLightbox=true"
                                     onerror="this.style.display='none'">
                            @elseif($item->metode === 'cod')
                                <span class="text-xs" style="color:#9ca3af;">
                                    <i class="fas fa-truck mr-1"></i>COD
                                </span>
                            @else
                                <span class="text-xs" style="color:#ef4444;">
                                    <i class="fas fa-exclamation-circle mr-1"></i>Belum upload
                                </span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge badge-{{ $item->status }}">
                                @if($item->status === 'pending') Menunggu
                                @elseif($item->status === 'berhasil') Terverifikasi
                                @else Ditolak
                                @endif
                            </span>
                        </td>

                        {{-- Tgl Masuk --}}
                        <td>
                            <div class="text-xs" style="color:#6b7280;">
                                {{ $item->created_at->locale('id')->diffForHumans() }}
                            </div>
                            <div class="text-xs mt-0.5" style="color:#9ca3af;">
                                {{ $item->created_at->format('d M Y, H:i') }}
                            </div>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            @if($item->status === 'pending')
                            <div class="flex gap-1.5">
                                {{-- Verifikasi --}}
                                <form method="POST"
                                      action="{{ route('admin.pembayaran.verifikasi', $item->id) }}"
                                      onsubmit="return confirm('Verifikasi pembayaran {{ $item->pesanan->no_order ?? '' }}?')">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="berhasil">
                                    <button type="submit" class="btn-verif btn-verif-ok" title="Verifikasi">
                                        <i class="fas fa-check" style="font-size:10px;"></i> Verifikasi
                                    </button>
                                </form>

                                {{-- Tolak --}}
                                <form method="POST"
                                      action="{{ route('admin.pembayaran.verifikasi', $item->id) }}"
                                      onsubmit="return confirm('Tolak pembayaran ini? Pesanan akan dibatalkan.')">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" value="gagal">
                                    <button type="submit" class="btn-verif btn-verif-batal" title="Tolak">
                                        <i class="fas fa-times" style="font-size:10px;"></i> Tolak
                                    </button>
                                </form>
                            </div>
                            @else
                            <span class="text-xs" style="color:#9ca3af;">
                                <i class="fas fa-check mr-1"></i>Selesai
                            </span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8">
                            <div class="empty-state">
                                <i class="fas fa-receipt text-4xl mb-3 block" style="color:#e5e7eb;"></i>
                                <p class="font-montserrat font-medium" style="color:#6b7280;">Belum ada data pembayaran</p>
                                <p class="text-xs mt-1" style="color:#9ca3af;">
                                    @if(request()->hasAny(['status','metode']))
                                        Coba ubah filter di atas
                                    @else
                                        Pembayaran dari customer akan muncul di sini
                                    @endif
                                </p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($pembayaran->hasPages())
        <div class="px-4 py-3" style="border-top:1px solid #f0f0f0;">
            {{ $pembayaran->links() }}
        </div>
        @endif
    </div>

    {{-- ── Lightbox Bukti ── --}}
    <div class="lightbox" x-show="showLightbox" @click="showLightbox=false" style="display:none;">
        <div class="lightbox-close" @click="showLightbox=false">
            <i class="fas fa-times"></i>
        </div>
        <img :src="lightboxSrc" alt="Bukti Pembayaran" @click.stop>
    </div>

</div>
@endsection
