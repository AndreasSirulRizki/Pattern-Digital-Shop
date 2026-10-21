@extends('layouts.admin')

@section('title', 'Kelola Kategori')
@section('header-title', 'Kelola Kategori')

@section('styles')
<style>
    /* ── Modal Overlay ── */
    .modal-overlay {
        position: fixed; inset: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 50;
        display: flex; align-items: center; justify-content: center;
        opacity: 0; visibility: hidden;
        transition: opacity 0.2s ease, visibility 0.2s ease;
    }
    .modal-overlay.show {
        opacity: 1; visibility: visible;
    }
    .modal-box {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        width: 100%; max-width: 440px;
        padding: 28px;
        box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        transform: translateY(12px) scale(0.98);
        transition: transform 0.2s ease;
    }
    .modal-overlay.show .modal-box {
        transform: translateY(0) scale(1);
    }

    /* ── Table ── */
    .kategori-table { width: 100%; border-collapse: collapse; }
    .kategori-table th {
        background: #f9f8f6;
        border-bottom: 1px solid #e5e7eb;
        padding: 10px 14px;
        text-align: left;
        font-size: 11px;
        font-weight: 700;
        color: #9ca3af;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        white-space: nowrap;
    }
    .kategori-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #f3f4f6;
        font-size: 13px;
        color: #374151;
        vertical-align: middle;
    }
    .kategori-table tr:last-child td { border-bottom: none; }
    .kategori-table tbody tr:hover td { background: #fafaf9; }

    /* ── Input ── */
    .form-input {
        width: 100%;
        background: #f9f8f6;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 9px 12px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #1a1a1a;
        outline: none;
        transition: border-color 0.2s, background 0.2s;
    }
    .form-input:focus {
        border-color: #1a1a1a;
        background: #ffffff;
        box-shadow: 0 0 0 3px rgba(26,26,26,0.06);
    }
    .form-input::placeholder { color: #9ca3af; }

    /* ── Badge ── */
    .badge-count {
        display: inline-flex; align-items: center; justify-content: center;
        min-width: 22px; height: 22px;
        border-radius: 6px;
        font-size: 11px; font-weight: 700;
        padding: 0 6px;
    }
    .badge-count-zero { background: #f3f4f6; color: #9ca3af; }
    .badge-count-has  { background: rgba(26,26,26,0.08); color: #1a1a1a; }

    /* ── Aksi buttons ── */
    .btn-edit {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px;
        background: #f9f8f6;
        border: 1px solid #e5e7eb;
        border-radius: 6px;
        font-size: 11px; font-weight: 500;
        color: #374151;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: 'Inter', sans-serif;
    }
    .btn-edit:hover { border-color: #9ca3af; background: #f3f4f6; color: #1a1a1a; }

    .btn-hapus {
        display: inline-flex; align-items: center; gap: 5px;
        padding: 5px 11px;
        background: rgba(239,68,68,0.06);
        border: 1px solid rgba(239,68,68,0.2);
        border-radius: 6px;
        font-size: 11px; font-weight: 500;
        color: #dc2626;
        cursor: pointer;
        transition: all 0.15s ease;
        font-family: 'Inter', sans-serif;
    }
    .btn-hapus:hover { background: rgba(239,68,68,0.12); border-color: rgba(239,68,68,0.35); }

    /* ── Search input ── */
    .search-input {
        background: #f9f8f6;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 8px 12px 8px 34px;
        font-size: 13px;
        font-family: 'Inter', sans-serif;
        color: #1a1a1a;
        outline: none;
        width: 260px;
        transition: border-color 0.2s;
    }
    .search-input:focus { border-color: #9ca3af; background: #ffffff; }
    .search-input::placeholder { color: #9ca3af; }

    /* ── Empty state ── */
    .empty-state {
        text-align: center;
        padding: 52px 24px;
        color: #9ca3af;
    }
    .empty-state i { font-size: 36px; margin-bottom: 12px; opacity: 0.4; }
    .empty-state p { font-size: 13px; margin-top: 6px; }
</style>
@endsection

@section('content')

{{-- ══════════════════════════════════════ --}}
{{-- HEADER BAR                            --}}
{{-- ══════════════════════════════════════ --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-xl font-bold text-[#1a1a1a]" style="font-family:'Montserrat',sans-serif;">Kelola Kategori</h1>
        <p class="text-xs mt-0.5" style="color:#9ca3af;">
            Total {{ $kategori->total() }} kategori terdaftar
        </p>
    </div>
    <button onclick="bukaModalTambah()"
            class="btn-admin-primary">
        <i class="fas fa-plus" style="font-size:11px;"></i>
        Tambah Kategori
    </button>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- FLASH MESSAGES                        --}}
{{-- ══════════════════════════════════════ --}}
@if(session('success'))
<div id="flash-success"
     style="background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.25); border-radius:10px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
    <i class="fas fa-check-circle" style="color:#16a34a; font-size:14px; flex-shrink:0;"></i>
    <span style="font-size:13px; color:#15803d; font-weight:500;">{{ session('success') }}</span>
    <button onclick="this.parentElement.remove()" style="margin-left:auto; color:#9ca3af; background:none; border:none; cursor:pointer; font-size:14px;">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

@if(session('error'))
<div id="flash-error"
     style="background:rgba(239,68,68,0.07); border:1px solid rgba(239,68,68,0.22); border-radius:10px; padding:12px 16px; margin-bottom:20px; display:flex; align-items:center; gap:10px;">
    <i class="fas fa-exclamation-circle" style="color:#dc2626; font-size:14px; flex-shrink:0;"></i>
    <span style="font-size:13px; color:#dc2626; font-weight:500;">{{ session('error') }}</span>
    <button onclick="this.parentElement.remove()" style="margin-left:auto; color:#9ca3af; background:none; border:none; cursor:pointer; font-size:14px;">
        <i class="fas fa-times"></i>
    </button>
</div>
@endif

{{-- ══════════════════════════════════════ --}}
{{-- CARD UTAMA                            --}}
{{-- ══════════════════════════════════════ --}}
<div style="background:#ffffff; border:1px solid #e5e7eb; border-radius:12px; overflow:hidden; box-shadow:0 1px 6px rgba(0,0,0,0.04);">

    {{-- Toolbar: Search --}}
    <div style="padding:14px 16px; border-bottom:1px solid #f3f4f6; display:flex; align-items:center; justify-content:space-between; gap:12px; flex-wrap:wrap;">
        <form method="GET" action="{{ route('admin.kategori') }}" style="position:relative; display:flex; align-items:center;">
            <i class="fas fa-search" style="position:absolute; left:11px; color:#9ca3af; font-size:11px;"></i>
            <input type="text"
                   name="search"
                   value="{{ request('search') }}"
                   placeholder="Cari nama kategori..."
                   class="search-input">
        </form>

        @if(request('search'))
        <a href="{{ route('admin.kategori') }}"
           style="font-size:12px; color:#6b7280; text-decoration:none; display:flex; align-items:center; gap:5px;">
            <i class="fas fa-times-circle"></i> Reset
        </a>
        @endif

        <div style="color:#9ca3af; font-size:12px; margin-left:auto;">
            Menampilkan {{ $kategori->firstItem() ?? 0 }}–{{ $kategori->lastItem() ?? 0 }}
            dari {{ $kategori->total() }} kategori
        </div>
    </div>

    {{-- Tabel --}}
    <div style="overflow-x:auto;">
        <table class="kategori-table">
            <thead>
                <tr>
                    <th style="width:48px;">No</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th style="text-align:center;">Jumlah Produk</th>
                    <th style="text-align:center; width:140px;">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kategori as $item)
                <tr>
                    <td style="color:#9ca3af; font-size:12px;">
                        {{ ($kategori->currentPage() - 1) * $kategori->perPage() + $loop->iteration }}
                    </td>
                    <td>
                        <div style="font-weight:600; color:#1a1a1a; font-size:13px;">{{ $item->nama_kategori }}</div>
                    </td>
                    <td>
                        <code style="font-size:11px; background:#f3f4f6; border:1px solid #e5e7eb; border-radius:4px; padding:2px 7px; color:#6b7280;">
                            {{ $item->slug }}
                        </code>
                    </td>
                    <td style="text-align:center;">
                        <span class="badge-count {{ $item->produks_count > 0 ? 'badge-count-has' : 'badge-count-zero' }}">
                            {{ $item->produks_count }}
                        </span>
                    </td>
                    <td style="text-align:center;">
                        <div style="display:flex; align-items:center; justify-content:center; gap:6px;">
                            {{-- Tombol Edit --}}
                            <button type="button"
                                    class="btn-edit"
                                    onclick="bukaModalEdit({{ $item->id }}, '{{ addslashes($item->nama_kategori) }}')">
                                <i class="fas fa-pencil-alt" style="font-size:10px;"></i> Edit
                            </button>

                            {{-- Tombol Hapus --}}
                            @if($item->produks_count === 0)
                            <button type="button"
                                    class="btn-hapus"
                                    onclick="konfirmasiHapus({{ $item->id }}, '{{ addslashes($item->nama_kategori) }}')">
                                <i class="fas fa-trash" style="font-size:10px;"></i> Hapus
                            </button>
                            @else
                            <span style="font-size:11px; color:#d1d5db; display:inline-flex; align-items:center; gap:4px;">
                                <i class="fas fa-lock" style="font-size:10px;"></i> Dipakai
                            </span>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5">
                        <div class="empty-state">
                            <i class="fas fa-tags"></i>
                            <div style="font-size:14px; font-weight:600; color:#374151;">Belum ada kategori</div>
                            <p>Klik "Tambah Kategori" untuk membuat kategori pertama.</p>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    @if($kategori->hasPages())
    <div style="padding:14px 16px; border-top:1px solid #f3f4f6;">
        {{ $kategori->appends(request()->query())->links() }}
    </div>
    @endif
</div>

{{-- ══════════════════════════════════════ --}}
{{-- MODAL TAMBAH KATEGORI                 --}}
{{-- ══════════════════════════════════════ --}}
<div id="modal-tambah" class="modal-overlay" onclick="tutupModalJikaOverlay(event, 'modal-tambah')">
    <div class="modal-box">
        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h2 style="font-family:'Montserrat',sans-serif; font-size:16px; font-weight:700; color:#1a1a1a;">
                    Tambah Kategori
                </h2>
                <p style="font-size:12px; color:#9ca3af; margin-top:2px;">Isi nama kategori baru</p>
            </div>
            <button onclick="tutupModal('modal-tambah')"
                    style="width:30px; height:30px; border-radius:8px; border:1px solid #e5e7eb; background:transparent; cursor:pointer; color:#9ca3af; display:flex; align-items:center; justify-content:center; transition:all 0.15s;"
                    onmouseover="this.style.borderColor='#9ca3af';this.style.color='#1a1a1a';"
                    onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#9ca3af';">
                <i class="fas fa-times" style="font-size:12px;"></i>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" action="{{ route('admin.kategori.store') }}">
            @csrf
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:6px;">
                    Nama Kategori <span style="color:#ef4444;">*</span>
                </label>
                <input type="text"
                       name="nama_kategori"
                       id="input-tambah-nama"
                       class="form-input"
                       placeholder="Contoh: Baju Muslim"
                       maxlength="100"
                       required>
                @error('nama_kategori')
                <p style="font-size:11px; color:#dc2626; margin-top:5px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
                @enderror
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:22px;">
                <button type="button"
                        onclick="tutupModal('modal-tambah')"
                        class="btn-admin-outline">
                    Batal
                </button>
                <button type="submit" class="btn-admin-primary">
                    <i class="fas fa-plus" style="font-size:10px;"></i> Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- MODAL EDIT KATEGORI                   --}}
{{-- ══════════════════════════════════════ --}}
<div id="modal-edit" class="modal-overlay" onclick="tutupModalJikaOverlay(event, 'modal-edit')">
    <div class="modal-box">
        {{-- Header --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:20px;">
            <div>
                <h2 style="font-family:'Montserrat',sans-serif; font-size:16px; font-weight:700; color:#1a1a1a;">
                    Edit Kategori
                </h2>
                <p style="font-size:12px; color:#9ca3af; margin-top:2px;">Ubah nama kategori</p>
            </div>
            <button onclick="tutupModal('modal-edit')"
                    style="width:30px; height:30px; border-radius:8px; border:1px solid #e5e7eb; background:transparent; cursor:pointer; color:#9ca3af; display:flex; align-items:center; justify-content:center; transition:all 0.15s;"
                    onmouseover="this.style.borderColor='#9ca3af';this.style.color='#1a1a1a';"
                    onmouseout="this.style.borderColor='#e5e7eb';this.style.color='#9ca3af';">
                <i class="fas fa-times" style="font-size:12px;"></i>
            </button>
        </div>

        {{-- Form --}}
        <form method="POST" id="form-edit">
            @csrf
            @method('PUT')
            <div style="margin-bottom:18px;">
                <label style="display:block; font-size:12px; font-weight:600; color:#374151; margin-bottom:6px;">
                    Nama Kategori <span style="color:#ef4444;">*</span>
                </label>
                <input type="text"
                       name="nama_kategori"
                       id="input-edit-nama"
                       class="form-input"
                       placeholder="Nama kategori"
                       maxlength="100"
                       required>
                @error('nama_kategori')
                <p style="font-size:11px; color:#dc2626; margin-top:5px;">
                    <i class="fas fa-exclamation-circle"></i> {{ $message }}
                </p>
                @enderror
            </div>

            <div style="display:flex; gap:10px; justify-content:flex-end; margin-top:22px;">
                <button type="button"
                        onclick="tutupModal('modal-edit')"
                        class="btn-admin-outline">
                    Batal
                </button>
                <button type="submit" class="btn-admin-primary">
                    <i class="fas fa-save" style="font-size:10px;"></i> Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- ══════════════════════════════════════ --}}
{{-- MODAL KONFIRMASI HAPUS                --}}
{{-- ══════════════════════════════════════ --}}
<div id="modal-hapus" class="modal-overlay" onclick="tutupModalJikaOverlay(event, 'modal-hapus')">
    <div class="modal-box" style="max-width:380px;">
        <div style="text-align:center; padding:8px 0 4px;">
            <div style="width:52px; height:52px; border-radius:14px; background:rgba(239,68,68,0.08); border:1px solid rgba(239,68,68,0.2); display:flex; align-items:center; justify-content:center; margin:0 auto 16px;">
                <i class="fas fa-trash" style="font-size:18px; color:#dc2626;"></i>
            </div>
            <h2 style="font-family:'Montserrat',sans-serif; font-size:16px; font-weight:700; color:#1a1a1a; margin-bottom:8px;">
                Hapus Kategori?
            </h2>
            <p style="font-size:13px; color:#6b7280; line-height:1.5;">
                Kategori <strong id="nama-hapus" style="color:#1a1a1a;"></strong> akan dihapus permanen.<br>
                Tindakan ini tidak bisa dibatalkan.
            </p>
        </div>

        <form method="POST" id="form-hapus" style="margin-top:24px;">
            @csrf
            @method('DELETE')
            <div style="display:flex; gap:10px;">
                <button type="button"
                        onclick="tutupModal('modal-hapus')"
                        class="btn-admin-outline"
                        style="flex:1; justify-content:center;">
                    Batal
                </button>
                <button type="submit"
                        style="flex:1; display:inline-flex; align-items:center; justify-content:center; gap:6px; padding:8px 16px; background:linear-gradient(135deg,#dc2626,#b91c1c); border:1px solid #dc2626; border-radius:8px; color:#ffffff; font-family:'Inter',sans-serif; font-weight:500; font-size:12px; cursor:pointer; transition:all 0.2s;">
                    <i class="fas fa-trash" style="font-size:10px;"></i> Ya, Hapus
                </button>
            </div>
        </form>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // ── Modal Helpers ──────────────────────────────
    function bukaModal(id) {
        document.getElementById(id).classList.add('show');
        document.body.style.overflow = 'hidden';
    }

    function tutupModal(id) {
        document.getElementById(id).classList.remove('show');
        document.body.style.overflow = '';
    }

    function tutupModalJikaOverlay(event, id) {
        // Tutup hanya jika klik langsung di overlay (bukan di modal-box)
        if (event.target === document.getElementById(id)) {
            tutupModal(id);
        }
    }

    // ── ESC Key ────────────────────────────────────
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            ['modal-tambah', 'modal-edit', 'modal-hapus'].forEach(tutupModal);
        }
    });

    // ── Modal Tambah ───────────────────────────────
    function bukaModalTambah() {
        document.getElementById('input-tambah-nama').value = '';
        bukaModal('modal-tambah');
        setTimeout(() => document.getElementById('input-tambah-nama').focus(), 150);
    }

    // ── Modal Edit ─────────────────────────────────
    function bukaModalEdit(id, namaKategori) {
        var url = '{{ route("admin.kategori.update", ":id") }}'.replace(':id', id);
        document.getElementById('form-edit').action = url;
        document.getElementById('input-edit-nama').value = namaKategori;
        bukaModal('modal-edit');
        setTimeout(() => document.getElementById('input-edit-nama').focus(), 150);
    }

    // ── Modal Hapus ────────────────────────────────
    function konfirmasiHapus(id, namaKategori) {
        var url = '{{ route("admin.kategori.destroy", ":id") }}'.replace(':id', id);
        document.getElementById('form-hapus').action = url;
        document.getElementById('nama-hapus').textContent = '"' + namaKategori + '"';
        bukaModal('modal-hapus');
    }

    // ── Auto-open modal jika ada validation error ──
    @if($errors->any())
        @php
            // Cek apakah error dari modal tambah atau edit
            // Jika request sebelumnya adalah POST/PUT, buka modal yang sesuai
        @endphp
        // Buka modal tambah jika ada error (default saat form di-submit)
        bukaModal('modal-tambah');
    @endif

    // ── Auto-dismiss flash message ─────────────────
    setTimeout(function () {
        ['flash-success', 'flash-error'].forEach(function (id) {
            var el = document.getElementById(id);
            if (el) {
                el.style.transition = 'opacity 0.4s ease';
                el.style.opacity = '0';
                setTimeout(() => el.remove(), 400);
            }
        });
    }, 4000);
</script>
@endsection
