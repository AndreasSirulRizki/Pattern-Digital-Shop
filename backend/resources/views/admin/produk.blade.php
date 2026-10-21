@extends('layouts.admin')

@section('title', 'Kelola Produk - Admin')
@section('header-title', 'Kelola Produk')

@section('styles')
<style>
    /* ── Kelola Produk ── */

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
    select.filter-input option { background: #ffffff; }

    .prod-table { width: 100%; border-collapse: collapse; }
    .prod-table th {
        text-align: left;
        padding: 10px 14px;
        font-size: 10px; font-weight: 700;
        color: #6b7280;
        letter-spacing: 0.08em; text-transform: uppercase;
        border-bottom: 1px solid #e5e7eb;
        background: #f5f5f5;
        white-space: nowrap;
    }
    .prod-table td {
        padding: 11px 14px;
        font-size: 12px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .prod-table tr:last-child td { border-bottom: none; }
    .prod-table tbody tr:hover td { background: #f5f5f5; }

    .tbl-check {
        width: 15px; height: 15px;
        accent-color: #333333;
        cursor: pointer;
    }

    .prod-thumb-sm {
        width: 48px; height: 48px;
        border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        overflow: hidden;
        flex-shrink: 0;
    }
    .prod-thumb-sm img { width: 100%; height: 100%; object-fit: cover; }

    .badge {
        display: inline-flex; align-items: center; gap: 3px;
        padding: 3px 8px; border-radius: 10px;
        font-size: 10px; font-weight: 700;
        letter-spacing: 0.03em; white-space: nowrap;
    }
    .badge-fisik    { background: rgba(168,85,247,0.1);  border:1px solid rgba(168,85,247,0.25); color: #7c3aed; }
    .badge-digital  { background: rgba(51,51,51,0.07);   border:1px solid rgba(51,51,51,0.15);  color: #333333; }
    .badge-aktif    { background: rgba(34,197,94,0.1);   border:1px solid rgba(34,197,94,0.25);  color: #15803d; }
    .badge-nonaktif { background: rgba(239,68,68,0.1);   border:1px solid rgba(239,68,68,0.25);  color: #dc2626; }

    .stok-low { color: #ef4444; font-weight: 700; }
    .stok-ok  { color: #6b7280; }

    .tbl-btn {
        display: inline-flex; align-items: center; gap: 4px;
        padding: 5px 10px; border-radius: 6px;
        font-size: 11px; font-weight: 500;
        cursor: pointer; transition: all 0.2s;
        text-decoration: none; white-space: nowrap;
        font-family: 'Inter', sans-serif;
    }
    .tbl-btn-edit {
        background: #ffffff;
        border: 1px solid #333333;
        color: #333333;
    }
    .tbl-btn-edit:hover { background: #f5f5f5; border-color: #1a1a1a; color: #1a1a1a; }
    .tbl-btn-del {
        background: rgba(239,68,68,0.06);
        border: 1px solid rgba(239,68,68,0.2);
        color: #ef4444;
    }
    .tbl-btn-del:hover { background: rgba(239,68,68,0.14); border-color: #ef4444; }

    .bulk-bar {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 16px; border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        margin-bottom: 12px;
        flex-wrap: wrap;
    }

    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0,0,0,0.5);
        backdrop-filter: blur(4px);
        z-index: 200;
        display: flex; align-items: flex-start; justify-content: center;
        padding: 24px 16px;
        overflow-y: auto;
    }
    .modal-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        width: 100%; max-width: 680px;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12);
        overflow: hidden;
        flex-shrink: 0;
    }
    .modal-header {
        display: flex; align-items: center; justify-content: space-between;
        padding: 18px 22px;
        border-bottom: 1px solid #e5e7eb;
        background: #faf8f5;
    }
    .modal-body { padding: 22px; }
    .modal-footer {
        padding: 16px 22px;
        border-top: 1px solid #e5e7eb;
        display: flex; justify-content: flex-end; gap: 10px;
        background: #faf8f5;
    }

    .form-group { margin-bottom: 16px; }
    .form-label {
        display: block; font-size: 11px; font-weight: 600;
        color: #6b7280; margin-bottom: 6px;
        letter-spacing: 0.04em; text-transform: uppercase;
    }
    .form-label span { color: #ef4444; }

    .form-input {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a; font-size: 13px;
        font-family: 'Inter', sans-serif;
        padding: 9px 13px;
        outline: none; transition: border-color 0.2s;
    }
    .form-input:focus { border-color: #333; box-shadow: 0 0 0 2px rgba(51,51,51,0.06); }
    .form-input::placeholder { color: #9ca3af; }
    select.form-input { cursor: pointer; }
    select.form-input option { background: #ffffff; }
    textarea.form-input { resize: vertical; min-height: 80px; }
    .form-input.is-invalid { border-color: #ef4444; }

    .radio-card {
        border: 1px solid #e5e7eb; border-radius: 8px;
        padding: 10px 14px; cursor: pointer;
        transition: all 0.2s; background: #ffffff;
        display: flex; align-items: center; gap: 10px;
        flex: 1;
    }
    .radio-card:hover { border-color: #333333; }
    .radio-card.selected {
        border-color: #333333;
        background: #f5f5f5;
        box-shadow: 0 0 0 2px rgba(51,51,51,0.06);
    }
    .radio-card input[type="radio"] { display: none; }

    .upload-area {
        border: 1px dashed #d1d5db;
        border-radius: 8px;
        padding: 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.2s;
        background: #faf8f5;
    }
    .upload-area:hover { border-color: #333333; background: #f5f5f5; }

    .page-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 30px; height: 30px;
        border-radius: 6px; font-size: 11px; font-weight: 600;
        cursor: pointer; transition: all 0.15s;
        border: 1px solid #e5e7eb; color: #6b7280;
        background: #ffffff; font-family: 'Inter', sans-serif;
    }
    .page-btn:hover { border-color: #333; color: #1a1a1a; }
    .page-btn.active {
        background: #1a1a1a;
        border-color: #1a1a1a; color: #ffffff;
    }

    .table-wrap { overflow-x: auto; }
    .table-wrap::-webkit-scrollbar { height: 3px; }
    .table-wrap::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }

    /* Flash message */
    .flash-success {
        display: flex; align-items: center; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: rgba(22,163,74,0.08);
        border: 1px solid rgba(22,163,74,0.2);
        color: #15803d;
        font-size: 13px; font-weight: 500;
        margin-bottom: 20px;
    }
    .flash-error {
        display: flex; align-items: flex-start; gap: 10px;
        padding: 12px 16px; border-radius: 10px;
        background: rgba(239,68,68,0.08);
        border: 1px solid rgba(239,68,68,0.2);
        color: #dc2626;
        font-size: 13px;
        margin-bottom: 20px;
    }

    /* Pagination override */
    .pagination { display: flex; gap: 4px; align-items: center; flex-wrap: wrap; }
    .pagination .page-item .page-link {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 30px; height: 30px; padding: 0 8px;
        border-radius: 6px; font-size: 11px; font-weight: 600;
        border: 1px solid #e5e7eb; color: #6b7280;
        background: #ffffff; text-decoration: none;
        transition: all 0.15s;
    }
    .pagination .page-item.active .page-link {
        background: #1a1a1a; border-color: #1a1a1a; color: #ffffff;
    }
    .pagination .page-item.disabled .page-link { opacity: 0.4; cursor: not-allowed; }
    .pagination .page-item .page-link:hover:not(.disabled) { border-color: #333; color: #1a1a1a; }
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
        <div class="font-semibold mb-1">Terjadi kesalahan validasi:</div>
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
    modalMode: 'tambah',
    editId: null,
    tipe: 'fisik',
    statusProduk: 'aktif',

    openTambah() {
        this.modalMode = 'tambah';
        this.tipe = 'fisik';
        this.statusProduk = 'aktif';
        this.editId = null;
        this.showModal = true;
        this.$nextTick(() => {
            document.getElementById('formTambah').reset();
        });
    },
    openEdit(id, nama, kategoriId, tipe, harga, stok, status, deskripsi) {
        this.modalMode = 'edit';
        this.editId = id;
        this.tipe = tipe;
        this.statusProduk = status;
        this.showModal = true;
        this.$nextTick(() => {
            document.getElementById('edit_nama_produk').value = nama;
            document.getElementById('edit_kategori_id').value = kategoriId;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_stok').value = stok;
            document.getElementById('edit_deskripsi').value = deskripsi;
            document.getElementById('edit_status').value = status;
            document.getElementById('formEditAction').action = '/admin/produk/' + id;
        });
    },
    closeModal() { this.showModal = false; },
}">

    {{-- ── Header ── --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
        <div>
            <h2 class="font-montserrat font-bold text-[#1a1a1a] text-xl">Kelola Produk</h2>
            <p class="text-xs mt-1" style="color:#6b7280;">
                Total <span style="color:#1a1a1a; font-weight:600;">{{ $totalProduk }}</span> produk terdaftar
                &nbsp;·&nbsp;
                <span style="color:#22c55e;">{{ $aktifCount }} aktif</span>
                &nbsp;·&nbsp;
                <span style="color:#ef4444;">{{ $totalProduk - $aktifCount }} nonaktif</span>
            </p>
        </div>
        <button class="btn-admin-primary gap-2" @click="openTambah()">
            <i class="fas fa-plus" style="font-size:11px;"></i>
            Tambah Produk
        </button>
    </div>

    {{-- ── Filter & Search ── --}}
    <form method="GET" action="{{ route('admin.produk') }}" class="flex flex-wrap gap-3 mb-4 p-4 rounded-xl" style="background:#f5f5f5; border:1px solid #e5e7eb;">
        {{-- Search --}}
        <div class="relative flex-1" style="min-width:200px;">
            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color:#9ca3af; font-size:11px;"></i>
            <input type="text" name="search" placeholder="Cari nama produk, SKU..."
                   value="{{ request('search') }}"
                   class="filter-input w-full" style="padding-left:34px;">
        </div>
        {{-- Kategori --}}
        <select name="kategori_id" class="filter-input" style="min-width:150px;">
            <option value="">Semua Kategori</option>
            @foreach($kategori as $k)
            <option value="{{ $k->id }}" {{ request('kategori_id') == $k->id ? 'selected' : '' }}>
                {{ $k->nama_kategori }}
            </option>
            @endforeach
        </select>
        {{-- Tipe --}}
        <select name="tipe" class="filter-input" style="min-width:120px;">
            <option value="">Semua Tipe</option>
            <option value="fisik"   {{ request('tipe') === 'fisik'   ? 'selected' : '' }}>Fisik</option>
            <option value="digital" {{ request('tipe') === 'digital' ? 'selected' : '' }}>Digital</option>
        </select>
        {{-- Status --}}
        <select name="status" class="filter-input" style="min-width:120px;">
            <option value="">Semua Status</option>
            <option value="aktif"    {{ request('status') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
            <option value="nonaktif" {{ request('status') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
        </select>
        {{-- Apply --}}
        <button type="submit" class="btn-admin-outline gap-1.5" style="padding:8px 14px;">
            <i class="fas fa-filter" style="font-size:10px;"></i> Terapkan
        </button>
        <a href="{{ route('admin.produk') }}" class="btn-admin-outline gap-1.5" style="padding:8px 12px;">
            <i class="fas fa-times" style="font-size:10px;"></i>
        </a>
    </form>

    {{-- ── Tabel Produk ── --}}
    <div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden;">

        {{-- Table stats bar --}}
        <div style="padding:12px 16px; border-bottom:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px;">
            <span class="text-xs" style="color:#6b7280;">
                Menampilkan {{ $produk->firstItem() ?? 0 }}–{{ $produk->lastItem() ?? 0 }}
                dari {{ $produk->total() }} produk
            </span>
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.produk') }}" class="btn-admin-outline gap-1.5" style="padding:6px 12px; font-size:11px;">
                    <i class="fas fa-sync-alt" style="font-size:10px;"></i> Refresh
                </a>
            </div>
        </div>

        <div class="table-wrap">
            <table class="prod-table">
                <thead>
                    <tr>
                        <th style="width:60px;">Foto</th>
                        <th>Nama Produk</th>
                        <th>Kategori</th>
                        <th>Tipe</th>
                        <th>Harga</th>
                        <th>Stok</th>
                        <th>Status</th>
                        <th style="width:130px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($produk as $p)
                    <tr>
                        {{-- Foto --}}
                        <td>
                            <div class="prod-thumb-sm">
                                @if($p->gambar)
                                    <img src="{{ asset('storage/' . $p->gambar) }}"
                                         alt="{{ $p->nama_produk }}"
                                         onerror="this.src='https://placehold.co/48x48/f5f5f5/9ca3af?text={{ urlencode(substr($p->nama_produk,0,1)) }}'">
                                @else
                                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;color:#9ca3af;font-size:16px;">
                                        <i class="fas fa-image"></i>
                                    </div>
                                @endif
                            </div>
                        </td>

                        {{-- Nama --}}
                        <td>
                            <div class="font-semibold text-[#1a1a1a] text-xs leading-snug" style="max-width:220px;">
                                {{ $p->nama_produk }}
                            </div>
                            <div class="text-xs mt-0.5 font-mono" style="color:#9ca3af;">{{ $p->slug }}</div>
                        </td>

                        {{-- Kategori --}}
                        <td>
                            <span class="text-xs" style="color:#6b7280;">
                                {{ $p->kategori?->nama_kategori ?? '—' }}
                            </span>
                        </td>

                        {{-- Tipe --}}
                        <td>
                            <span class="badge {{ $p->tipe === 'digital' ? 'badge-digital' : 'badge-fisik' }}">
                                <i class="fas {{ $p->tipe === 'digital' ? 'fa-file-pdf' : 'fa-box' }}" style="font-size:8px;"></i>
                                {{ ucfirst($p->tipe) }}
                            </span>
                        </td>

                        {{-- Harga --}}
                        <td>
                            <span class="font-montserrat font-bold" style="color:#1a1a1a; font-size:12px;">
                                Rp {{ number_format($p->harga, 0, ',', '.') }}
                            </span>
                        </td>

                        {{-- Stok --}}
                        <td>
                            @if($p->tipe === 'digital')
                                <span style="color:#6b7280; font-size:11px;">∞</span>
                            @elseif($p->stok === 0)
                                <span class="text-xs font-bold" style="color:#ef4444;">Habis</span>
                            @elseif($p->stok < 5)
                                <span class="text-xs font-bold stok-low">{{ $p->stok }} <span style="font-weight:400; color:#7f1d1d;">⚠</span></span>
                            @else
                                <span class="text-xs stok-ok">{{ $p->stok }}</span>
                            @endif
                        </td>

                        {{-- Status --}}
                        <td>
                            <span class="badge {{ $p->status === 'aktif' ? 'badge-aktif' : 'badge-nonaktif' }}">
                                <i class="fas {{ $p->status === 'aktif' ? 'fa-check-circle' : 'fa-times-circle' }}" style="font-size:8px;"></i>
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>

                        {{-- Aksi --}}
                        <td>
                            <div class="flex items-center gap-1.5">
                                {{-- Tombol Edit --}}
                                <button class="tbl-btn tbl-btn-edit"
                                    @click="openEdit(
                                        {{ $p->id }},
                                        {{ json_encode($p->nama_produk) }},
                                        {{ $p->kategori_id }},
                                        {{ json_encode($p->tipe) }},
                                        {{ $p->harga }},
                                        {{ $p->stok }},
                                        {{ json_encode($p->status) }},
                                        {{ json_encode($p->deskripsi ?? '') }}
                                    )">
                                    <i class="fas fa-pen" style="font-size:9px;"></i> Edit
                                </button>

                                {{-- Tombol Hapus --}}
                                <form method="POST"
                                      action="{{ route('admin.produk.destroy', $p->id) }}"
                                      onsubmit="return confirm('Hapus produk {{ addslashes($p->nama_produk) }}? Tindakan ini tidak bisa dibatalkan.')">
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
                        <td colspan="8" style="text-align:center; padding:40px; color:#9ca3af;">
                            <i class="fas fa-box-open" style="font-size:24px; margin-bottom:8px; display:block;"></i>
                            Belum ada produk.
                            @if(request()->hasAny(['search','kategori_id','tipe','status']))
                                <br><a href="{{ route('admin.produk') }}" style="color:#333; text-decoration:underline;">Reset filter</a>
                            @endif
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if($produk->hasPages())
        <div style="padding:12px 16px; border-top:1px solid #e5e7eb; display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:8px; background:#faf8f5;">
            <span class="text-xs" style="color:#6b7280;">
                Halaman {{ $produk->currentPage() }} dari {{ $produk->lastPage() }}
            </span>
            {{ $produk->links() }}
        </div>
        @endif
    </div>


    {{-- ════════════════════════════════════════════════════ --}}
    {{-- MODAL TAMBAH PRODUK                                  --}}
    {{-- ════════════════════════════════════════════════════ --}}
    <div class="modal-overlay"
         x-show="showModal && modalMode === 'tambah'"
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
                <div class="flex items-center gap-3">
                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-plus" style="font-size:12px; color:#333333;"></i>
                    </div>
                    <div>
                        <h3 class="font-montserrat font-bold text-[#1a1a1a] text-sm">Tambah Produk Baru</h3>
                        <p class="text-xs mt-0.5" style="color:#6b7280;">Isi data produk dengan lengkap</p>
                    </div>
                </div>
                <button @click="closeModal()"
                        style="width:28px; height:28px; border-radius:6px; background:transparent; border:1px solid #e5e7eb; color:#6b7280; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;"
                        onmouseover="this.style.borderColor='#333'; this.style.color='#1a1a1a';"
                        onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#6b7280';">
                    <i class="fas fa-times" style="font-size:11px;"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <form id="formTambah" method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5">

                        {{-- Nama Produk --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Nama Produk <span>*</span></label>
                            <input type="text" name="nama_produk" class="form-input {{ $errors->has('nama_produk') ? 'is-invalid' : '' }}"
                                   placeholder="Contoh: Pola Kemeja Pria Slim Fit"
                                   value="{{ old('nama_produk') }}">
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <select name="kategori_id" class="form-input {{ $errors->has('kategori_id') ? 'is-invalid' : '' }}">
                                <option value="">Pilih kategori...</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}" {{ old('kategori_id') == $k->id ? 'selected' : '' }}>
                                    {{ $k->nama_kategori }}
                                </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="form-group">
                            <label class="form-label">Harga (Rp) <span>*</span></label>
                            <div class="relative">
                                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#6b7280; font-size:12px;">Rp</span>
                                <input type="number" name="harga" class="form-input {{ $errors->has('harga') ? 'is-invalid' : '' }}"
                                       placeholder="75000" min="0"
                                       style="padding-left:36px;"
                                       value="{{ old('harga') }}">
                            </div>
                        </div>

                        {{-- Tipe Produk --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Tipe Produk <span>*</span></label>
                            <div class="flex gap-3">
                                <label class="radio-card" :class="tipe === 'fisik' ? 'selected' : ''"
                                       @click="tipe = 'fisik'">
                                    <input type="radio" name="tipe" value="fisik" x-model="tipe">
                                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas fa-box" style="color:#7c3aed; font-size:13px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1a1a1a]">Fisik</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Dikirim via kurir</div>
                                    </div>
                                </label>
                                <label class="radio-card" :class="tipe === 'digital' ? 'selected' : ''"
                                       @click="tipe = 'digital'">
                                    <input type="radio" name="tipe" value="digital" x-model="tipe">
                                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas fa-file-pdf" style="color:#333333; font-size:13px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1a1a1a]">Digital PDF</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Download otomatis</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Stok (hanya fisik) --}}
                        <div class="form-group" x-show="tipe === 'fisik'">
                            <label class="form-label">Stok <span>*</span></label>
                            <input type="number" name="stok" class="form-input"
                                   placeholder="0" min="0"
                                   value="{{ old('stok', 0) }}">
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea name="deskripsi" class="form-input"
                                      placeholder="Deskripsi detail produk pola jahit...">{{ old('deskripsi') }}</textarea>
                        </div>

                        {{-- Upload Gambar --}}
                        <div class="form-group" :class="tipe === 'digital' ? '' : 'sm:col-span-2'">
                            <label class="form-label">Upload Gambar Produk</label>
                            <div class="upload-area" onclick="document.getElementById('uploadGambar').click()">
                                <i class="fas fa-image" style="color:#9ca3af; font-size:24px; margin-bottom:8px; display:block;"></i>
                                <p class="text-xs" style="color:#6b7280;">Drag & drop atau <span style="color:#333333; cursor:pointer;">klik untuk upload</span></p>
                                <p class="text-xs mt-1" style="color:#9ca3af;">PNG, JPG, WEBP — Maks. 2MB</p>
                                <input type="file" id="uploadGambar" name="gambar" accept="image/*" style="display:none;"
                                       onchange="document.getElementById('namaGambar').textContent = this.files[0]?.name || ''">
                            </div>
                            <p id="namaGambar" class="text-xs mt-1" style="color:#6b7280;"></p>
                        </div>

                        {{-- Upload PDF (hanya digital) --}}
                        <div class="form-group" x-show="tipe === 'digital'">
                            <label class="form-label">Upload File PDF <span>*</span></label>
                            <div class="upload-area" onclick="document.getElementById('uploadPDF').click()">
                                <i class="fas fa-file-pdf" style="color:#9ca3af; font-size:24px; margin-bottom:8px; display:block;"></i>
                                <p class="text-xs" style="color:#6b7280;">Drag & drop atau <span style="color:#333333; cursor:pointer;">klik untuk upload</span></p>
                                <p class="text-xs mt-1" style="color:#9ca3af;">PDF saja — Maks. 50MB</p>
                                <input type="file" id="uploadPDF" name="file_pdf" accept=".pdf" style="display:none;"
                                       onchange="document.getElementById('namaPDF').textContent = this.files[0]?.name || ''">
                            </div>
                            <p id="namaPDF" class="text-xs mt-1" style="color:#6b7280;"></p>
                        </div>

                        {{-- Status --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Status Produk <span>*</span></label>
                            <select name="status" class="form-input">
                                <option value="aktif"    {{ old('status','aktif') === 'aktif'    ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ old('status','aktif') === 'nonaktif' ? 'selected' : '' }}>Nonaktif</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" @click="closeModal()" class="btn-admin-outline gap-2">
                        <i class="fas fa-times" style="font-size:10px;"></i> Batal
                    </button>
                    <button type="submit" class="btn-admin-primary gap-2">
                        <i class="fas fa-save" style="font-size:11px;"></i> Simpan Produk
                    </button>
                </div>
            </form>

        </div>
    </div>{{-- end modal tambah --}}


    {{-- ════════════════════════════════════════════════════ --}}
    {{-- MODAL EDIT PRODUK                                    --}}
    {{-- ════════════════════════════════════════════════════ --}}
    <div class="modal-overlay"
         x-show="showModal && modalMode === 'edit'"
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
                <div class="flex items-center gap-3">
                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center;">
                        <i class="fas fa-pen" style="font-size:12px; color:#333333;"></i>
                    </div>
                    <div>
                        <h3 class="font-montserrat font-bold text-[#1a1a1a] text-sm">Edit Produk</h3>
                        <p class="text-xs mt-0.5" style="color:#6b7280;">Update data produk</p>
                    </div>
                </div>
                <button @click="closeModal()"
                        style="width:28px; height:28px; border-radius:6px; background:transparent; border:1px solid #e5e7eb; color:#6b7280; display:flex; align-items:center; justify-content:center; cursor:pointer; transition:all 0.2s;"
                        onmouseover="this.style.borderColor='#333'; this.style.color='#1a1a1a';"
                        onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#6b7280';">
                    <i class="fas fa-times" style="font-size:11px;"></i>
                </button>
            </div>

            {{-- Modal Body --}}
            <form id="formEditAction" method="POST" action="" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body" style="max-height:70vh; overflow-y:auto;">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-5">

                        {{-- Nama Produk --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Nama Produk <span>*</span></label>
                            <input type="text" id="edit_nama_produk" name="nama_produk" class="form-input"
                                   placeholder="Nama produk">
                        </div>

                        {{-- Kategori --}}
                        <div class="form-group">
                            <label class="form-label">Kategori <span>*</span></label>
                            <select id="edit_kategori_id" name="kategori_id" class="form-input">
                                <option value="">Pilih kategori...</option>
                                @foreach($kategori as $k)
                                <option value="{{ $k->id }}">{{ $k->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Harga --}}
                        <div class="form-group">
                            <label class="form-label">Harga (Rp) <span>*</span></label>
                            <div class="relative">
                                <span style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#6b7280; font-size:12px;">Rp</span>
                                <input type="number" id="edit_harga" name="harga" class="form-input"
                                       placeholder="75000" min="0"
                                       style="padding-left:36px;">
                            </div>
                        </div>

                        {{-- Tipe --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Tipe Produk <span>*</span></label>
                            <div class="flex gap-3">
                                <label class="radio-card" :class="tipe === 'fisik' ? 'selected' : ''"
                                       @click="tipe = 'fisik'">
                                    <input type="radio" name="tipe" value="fisik" x-model="tipe">
                                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas fa-box" style="color:#7c3aed; font-size:13px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1a1a1a]">Fisik</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Dikirim via kurir</div>
                                    </div>
                                </label>
                                <label class="radio-card" :class="tipe === 'digital' ? 'selected' : ''"
                                       @click="tipe = 'digital'">
                                    <input type="radio" name="tipe" value="digital" x-model="tipe">
                                    <div style="width:32px; height:32px; border-radius:8px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                        <i class="fas fa-file-pdf" style="color:#333333; font-size:13px;"></i>
                                    </div>
                                    <div>
                                        <div class="text-sm font-semibold text-[#1a1a1a]">Digital PDF</div>
                                        <div class="text-xs mt-0.5" style="color:#6b7280;">Download otomatis</div>
                                    </div>
                                </label>
                            </div>
                        </div>

                        {{-- Stok (hanya fisik) --}}
                        <div class="form-group" x-show="tipe === 'fisik'">
                            <label class="form-label">Stok</label>
                            <input type="number" id="edit_stok" name="stok" class="form-input"
                                   placeholder="0" min="0">
                        </div>

                        {{-- Deskripsi --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Deskripsi Produk</label>
                            <textarea id="edit_deskripsi" name="deskripsi" class="form-input"
                                      placeholder="Deskripsi produk..."></textarea>
                        </div>

                        {{-- Upload Gambar Baru --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Ganti Gambar <span style="color:#6b7280; font-weight:400;">(opsional)</span></label>
                            <div class="upload-area" onclick="document.getElementById('editUploadGambar').click()">
                                <i class="fas fa-image" style="color:#9ca3af; font-size:24px; margin-bottom:8px; display:block;"></i>
                                <p class="text-xs" style="color:#6b7280;">Biarkan kosong jika tidak ingin mengubah gambar</p>
                                <input type="file" id="editUploadGambar" name="gambar" accept="image/*" style="display:none;"
                                       onchange="document.getElementById('editNamaGambar').textContent = this.files[0]?.name || ''">
                            </div>
                            <p id="editNamaGambar" class="text-xs mt-1" style="color:#6b7280;"></p>
                        </div>

                        {{-- Upload PDF Baru (digital) --}}
                        <div class="form-group sm:col-span-2" x-show="tipe === 'digital'">
                            <label class="form-label">Ganti File PDF <span style="color:#6b7280; font-weight:400;">(opsional)</span></label>
                            <div class="upload-area" onclick="document.getElementById('editUploadPDF').click()">
                                <i class="fas fa-file-pdf" style="color:#9ca3af; font-size:24px; margin-bottom:8px; display:block;"></i>
                                <p class="text-xs" style="color:#6b7280;">Biarkan kosong jika tidak ingin mengubah file PDF</p>
                                <input type="file" id="editUploadPDF" name="file_pdf" accept=".pdf" style="display:none;"
                                       onchange="document.getElementById('editNamaPDF').textContent = this.files[0]?.name || ''">
                            </div>
                            <p id="editNamaPDF" class="text-xs mt-1" style="color:#6b7280;"></p>
                        </div>

                        {{-- Status --}}
                        <div class="form-group sm:col-span-2">
                            <label class="form-label">Status Produk <span>*</span></label>
                            <select id="edit_status" name="status" class="form-input">
                                <option value="aktif">Aktif</option>
                                <option value="nonaktif">Nonaktif</option>
                            </select>
                        </div>

                    </div>
                </div>

                {{-- Modal Footer --}}
                <div class="modal-footer">
                    <button type="button" @click="closeModal()" class="btn-admin-outline gap-2">
                        <i class="fas fa-times" style="font-size:10px;"></i> Batal
                    </button>
                    <button type="submit" class="btn-admin-primary gap-2">
                        <i class="fas fa-save" style="font-size:11px;"></i> Update Produk
                    </button>
                </div>
            </form>

        </div>
    </div>{{-- end modal edit --}}

</div>{{-- end x-data --}}
@endsection
