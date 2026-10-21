@extends('layouts.app')

@section('title', 'Katalog - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Sidebar Filter ── */
    .filter-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
    }

    /* ── Custom checkbox ── */
    .filter-checkbox {
        accent-color: #333333;
        width: 14px; height: 14px;
        cursor: pointer;
    }

    /* ── Search / Input katalog ── */
    .katalog-input {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        color: #1a1a1a;
        transition: all 0.2s ease;
        border-radius: 8px;
    }
    .katalog-input:focus {
        outline: none;
        border-color: #333333;
        box-shadow: 0 0 0 2px rgba(51,51,51,0.08);
    }
    .katalog-input::placeholder { color: #6b7280; }

    /* ── Select dropdown ── */
    .katalog-select {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        color: #6b7280;
        transition: border-color 0.2s;
        border-radius: 8px;
        cursor: pointer;
    }
    .katalog-select:focus {
        outline: none;
        border-color: #333333;
    }
    .katalog-select option {
        background: #ffffff;
        color: #1a1a1a;
    }

    /* ── Product Card ── */
    .produk-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
        display: flex;
        flex-direction: column;
        box-shadow: 0 1px 3px rgba(0,0,0,0.06);
    }
    .produk-card:hover {
        border-color: #333333;
        box-shadow: 0 8px 32px rgba(0,0,0,0.12), 0 0 20px rgba(51,51,51,0.06);
        transform: translateY(-4px);
    }

    /* Gambar produk */
    .produk-img-wrap {
        background: #f5f5f5;
        position: relative;
        overflow: hidden;
        aspect-ratio: 4/3;
    }
    .produk-img-wrap img {
        width: 100%; height: 100%;
        object-fit: cover;
        display: block;
        transition: transform 0.4s ease;
    }
    .produk-card:hover .produk-img-wrap img {
        transform: scale(1.04);
    }

    /* Badge tipe */
    .badge-fisik {
        background: rgba(51,51,51,0.08);
        border: 1px solid rgba(51,51,51,0.2);
        color: #333333;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 2px 8px;
        border-radius: 20px;
        text-transform: uppercase;
    }
    .badge-digital {
        background: rgba(26,26,26,0.07);
        border: 1px solid rgba(26,26,26,0.15);
        color: #1a1a1a;
        font-size: 10px;
        font-weight: 600;
        letter-spacing: 0.05em;
        padding: 2px 8px;
        border-radius: 20px;
        text-transform: uppercase;
    }

    /* Bintang rating */
    .star-filled { color: #fbbf24; }
    .star-empty  { color: #d1d5db; }

    /* Harga */
    .harga-text {
        color: #1a1a1a;
        font-family: 'Montserrat', sans-serif;
        font-weight: 700;
        font-size: 1rem;
        letter-spacing: 0.02em;
    }

    /* ── Pagination ── */
    .page-btn {
        display: inline-flex; align-items: center; justify-content: center;
        width: 36px; height: 36px;
        border-radius: 8px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #6b7280;
        font-size: 13px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }
    .page-btn:hover {
        border-color: #333333;
        color: #1a1a1a;
        box-shadow: 0 0 10px rgba(51,51,51,0.1);
    }
    .page-btn.active {
        background: #1a1a1a;
        border-color: #1a1a1a;
        color: #ffffff;
        box-shadow: 0 0 12px rgba(51,51,51,0.15);
    }
    .page-btn.disabled {
        opacity: 0.35;
        cursor: not-allowed;
        pointer-events: none;
    }

    /* ── Range slider ── */
    input[type="range"] {
        -webkit-appearance: none;
        appearance: none;
        background: #e5e7eb;
        height: 4px;
        border-radius: 2px;
        width: 100%;
        cursor: pointer;
    }
    input[type="range"]::-webkit-slider-thumb {
        -webkit-appearance: none;
        appearance: none;
        width: 16px; height: 16px;
        border-radius: 50%;
        background: #333333;
        border: 2px solid #ffffff;
        cursor: pointer;
        box-shadow: 0 0 6px rgba(51,51,51,0.3);
    }

    /* ── Glossy divider ── */
    .glossy-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 16px 0;
    }

    /* ── Empty state ── */
    .empty-state {
        background: #ffffff;
        border: 1px dashed #e5e7eb;
        border-radius: 12px;
    }
</style>
@endsection

@section('content')
{{-- ════════════════════════════════════════════
     HALAMAN KATALOG
════════════════════════════════════════════ --}}
<section class="min-h-screen py-10" style="background:#faf8f5;" x-data="katalogApp()">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ── HEADER ── --}}
        <div class="mb-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm mb-3">
                <a href="{{ route('home') }}" class="transition-colors hover:text-[#1a1a1a]" style="color:#6b7280;">
                    <i class="fas fa-home mr-1" style="font-size:11px;"></i>Beranda
                </a>
                <i class="fas fa-chevron-right" style="color:#e5e7eb; font-size:9px;"></i>
                <span style="color:#333333;">Katalog</span>
            </nav>

            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
                <div>
                    <h1 class="text-3xl font-bold text-[#1a1a1a] font-montserrat tracking-tight">
                        Katalog Pola Jahit
                    </h1>
                    <p class="mt-1 text-sm" style="color:#6b7280;">
                        Menampilkan
                        <span class="font-semibold" style="color:#1a1a1a;">{{ $produk->firstItem() ?? 0 }}–{{ $produk->lastItem() ?? 0 }}</span>
                        dari
                        <span class="font-semibold" style="color:#1a1a1a;">{{ $produk->total() }}</span>
                        produk
                    </p>
                </div>
                <div class="flex items-center gap-2 text-sm" style="color:#6b7280;">
                    <i class="fas fa-layer-group" style="font-size:11px;"></i>
                    <span>{{ $kategori->count() }} kategori tersedia</span>
                </div>
            </div>
        </div>
        {{-- ── END HEADER ── --}}

        {{-- ── LAYOUT 2 KOLOM ── --}}
        <div class="flex flex-col lg:flex-row gap-6">

            {{-- ══════════════════════════════
                 SIDEBAR FILTER (25%)
            ══════════════════════════════ --}}
            <aside class="w-full lg:w-64 xl:w-72 shrink-0">
                <div class="filter-card p-5 sticky top-20">

                    {{-- Judul Filter --}}
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="font-semibold text-[#1a1a1a] font-montserrat tracking-wide text-sm uppercase flex items-center gap-2">
                            <i class="fas fa-sliders-h" style="color:#333333; font-size:12px;"></i>
                            Filter
                        </h3>
                        <span class="text-xs px-2 py-0.5 rounded" style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280;">
                            <span x-text="activeFiltersCount()"></span> aktif
                        </span>
                    </div>

                    <form method="GET" action="{{ route('katalog') }}" x-ref="filterForm">

                        {{-- ── Filter Kategori ── --}}
                        <div class="mb-5">
                            <h4 class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Kategori</h4>
                            <div class="space-y-2">
                                @foreach($kategori as $kat)
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="checkbox"
                                           name="kategori[]"
                                           value="{{ $kat->id }}"
                                           class="filter-checkbox"
                                           {{ in_array($kat->id, request()->input('kategori', [])) ? 'checked' : '' }}>
                                    <span class="text-sm transition-colors group-hover:text-[#1a1a1a]" style="color:#6b7280;">
                                        {{ $kat->nama_kategori }}
                                    </span>
                                    <span class="ml-auto text-xs rounded px-1.5 py-0.5" style="background:#f5f5f5; color:#6b7280; border:1px solid #e5e7eb;">
                                        {{ $kat->produks_count ?? $kat->produks()->count() }}
                                    </span>
                                </label>
                                @endforeach

                                @if($kategori->isEmpty())
                                    <p class="text-xs" style="color:#6b7280;">Belum ada kategori.</p>
                                @endif
                            </div>
                        </div>

                        <div class="glossy-divider"></div>

                        {{-- ── Filter Tipe ── --}}
                        <div class="mb-5">
                            <h4 class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Tipe Produk</h4>
                            <div class="space-y-2">
                                @foreach([''=>'Semua Tipe', 'fisik'=>'Fisik (Cetak)', 'digital'=>'Digital (PDF)'] as $val => $label)
                                <label class="flex items-center gap-2.5 cursor-pointer group">
                                    <input type="radio"
                                           name="tipe"
                                           value="{{ $val }}"
                                           class="filter-checkbox"
                                           {{ request('tipe', '') === $val ? 'checked' : '' }}>
                                    <span class="text-sm transition-colors group-hover:text-[#1a1a1a]" style="color:#6b7280;">
                                        {{ $label }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="glossy-divider"></div>

                        {{-- ── Filter Harga ── --}}
                        <div class="mb-5">
                            <h4 class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Rentang Harga</h4>

                            {{-- Input min-max --}}
                            <div class="flex items-center gap-2 mb-3">
                                <div class="flex-1">
                                    <input type="number"
                                           name="harga_min"
                                           placeholder="Min"
                                           value="{{ request('harga_min') }}"
                                           class="katalog-input w-full px-3 py-1.5 text-sm"
                                           min="0" step="5000">
                                </div>
                                <span style="color:#6b7280; font-size:12px;">—</span>
                                <div class="flex-1">
                                    <input type="number"
                                           name="harga_max"
                                           placeholder="Max"
                                           value="{{ request('harga_max') }}"
                                           class="katalog-input w-full px-3 py-1.5 text-sm"
                                           min="0" step="5000">
                                </div>
                            </div>

                            {{-- Slider harga (visual helper) --}}
                            <div>
                                <input type="range" min="0" max="500000" step="5000"
                                       x-model="hargaMax"
                                       @input="updateHargaMax($event.target.value)"
                                       class="w-full">
                                <div class="flex justify-between text-xs mt-1.5" style="color:#6b7280;">
                                    <span>Rp 0</span>
                                    <span x-text="'Rp ' + hargaMax.toLocaleString('id-ID')"></span>
                                </div>
                            </div>
                        </div>

                        <div class="glossy-divider"></div>

                        {{-- ── Tombol Filter ── --}}
                        <div class="space-y-2">
                            <button type="submit"
                                    class="btn-primary w-full px-4 py-2.5 text-sm font-semibold gap-2">
                                <i class="fas fa-filter" style="font-size:11px;"></i>
                                Terapkan Filter
                            </button>
                            <a href="{{ route('katalog') }}"
                               class="btn-outline w-full px-4 py-2.5 text-sm font-semibold text-center gap-2">
                                <i class="fas fa-times" style="font-size:11px;"></i>
                                Reset Filter
                            </a>
                        </div>

                    </form>

                </div>
            </aside>
            {{-- ══ END SIDEBAR ══ --}}


            {{-- ══════════════════════════════
                 GRID PRODUK (75%)
            ══════════════════════════════ --}}
            <div class="flex-1 min-w-0">

                {{-- ── Toolbar: Search + Sort ── --}}
                <div class="flex flex-col sm:flex-row gap-3 mb-6">

                    {{-- Search --}}
                    <form method="GET" action="{{ route('katalog') }}" class="flex-1 flex gap-2">
                        {{-- Carry over filters --}}
                        @foreach(request()->except(['q','page']) as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach

                        <div class="relative flex-1">
                            <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color:#6b7280; font-size:12px;"></i>
                            <input type="text"
                                   name="q"
                                   value="{{ request('q') }}"
                                   placeholder="Cari nama produk atau kategori..."
                                   class="katalog-input w-full pl-10 pr-4 py-2.5 text-sm">
                        </div>
                        <button type="submit" class="btn-primary px-4 py-2.5 text-sm whitespace-nowrap gap-2">
                            <i class="fas fa-search" style="font-size:11px;"></i>
                            Cari
                        </button>
                    </form>

                    {{-- Sort --}}
                    <form method="GET" action="{{ route('katalog') }}" id="sortForm" class="shrink-0">
                        @foreach(request()->except(['sort','page']) as $key => $val)
                            @if(is_array($val))
                                @foreach($val as $v)
                                    <input type="hidden" name="{{ $key }}[]" value="{{ $v }}">
                                @endforeach
                            @else
                                <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                            @endif
                        @endforeach
                        <select name="sort"
                                class="katalog-select px-3 py-2.5 text-sm"
                                onchange="document.getElementById('sortForm').submit()">
                            <option value="terbaru"  {{ request('sort','terbaru') === 'terbaru'  ? 'selected' : '' }}>Terbaru</option>
                            <option value="termurah" {{ request('sort') === 'termurah' ? 'selected' : '' }}>Termurah</option>
                            <option value="termahal" {{ request('sort') === 'termahal' ? 'selected' : '' }}>Termahal</option>
                            <option value="populer"  {{ request('sort') === 'populer'  ? 'selected' : '' }}>Populer</option>
                        </select>
                    </form>

                </div>
                {{-- ── END TOOLBAR ── --}}


                {{-- ── GRID PRODUK ── --}}
                @if($produk->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                    @foreach($produk as $item)
                    <article class="produk-card group">

                        {{-- Gambar --}}
                        <div class="produk-img-wrap">
                            <img src="{{ $item->gambar ? asset('storage/'.$item->gambar) : 'https://via.placeholder.com/400x400/f5f5f5/333333?text='.urlencode($item->nama_produk) }}"
                                 alt="{{ $item->nama_produk }}"
                                 loading="lazy"
                                 onerror="this.onerror=null;this.src='https://via.placeholder.com/400x400/f5f5f5/333333?text='+encodeURIComponent('{{ addslashes($item->nama_produk) }}')">

                            {{-- Badge tipe di pojok --}}
                            <div class="absolute top-2.5 left-2.5">
                                @if($item->tipe === 'digital')
                                    <span class="badge-digital flex items-center gap-1">
                                        <i class="fas fa-download" style="font-size:9px;"></i> Digital
                                    </span>
                                @else
                                    <span class="badge-fisik flex items-center gap-1">
                                        <i class="fas fa-box" style="font-size:9px;"></i> Fisik
                                    </span>
                                @endif
                            </div>

                            {{-- Overlay hover: quick action --}}
                            <div class="absolute inset-0 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity duration-300"
                                 style="background: rgba(0,0,0,0.18);">
                                <a href="{{ route('produk.detail', $item->slug) }}"
                                   class="px-4 py-2 rounded-lg text-sm font-semibold text-white"
                                   style="background: rgba(26,26,26,0.85); border: 1px solid rgba(255,255,255,0.25); backdrop-filter: blur(4px);">
                                    <i class="fas fa-eye mr-1.5" style="font-size:11px;"></i>Lihat Detail
                                </a>
                            </div>
                        </div>

                        {{-- Konten Kartu --}}
                        <div class="p-4 flex flex-col flex-1">

                            {{-- Rating --}}
                            <div class="flex items-center gap-1 mb-2">
                                @for($s = 1; $s <= 5; $s++)
                                    <i class="fas fa-star" style="font-size:10px; color: {{ $s <= 4 ? '#fbbf24' : '#d1d5db' }};"></i>
                                @endfor
                                <span class="ml-1 text-xs" style="color:#6b7280;">4.8</span>
                            </div>

                            {{-- Nama & Kategori --}}
                            <h3 class="font-semibold text-[#1a1a1a] text-sm leading-snug mb-1 font-montserrat line-clamp-2"
                                title="{{ $item->nama_produk }}">
                                {{ $item->nama_produk }}
                            </h3>
                            <p class="text-xs mb-3" style="color:#6b7280;">
                                <i class="fas fa-tag mr-1" style="font-size:9px;"></i>
                                {{ $item->kategori->nama_kategori ?? '—' }}
                            </p>

                            {{-- Stok / Download info --}}
                            <div class="mb-3">
                                @if($item->tipe === 'digital')
                                    <span class="flex items-center gap-1.5 text-xs" style="color:#6b7280;">
                                        <i class="fas fa-file-pdf" style="color:#333333; font-size:11px;"></i>
                                        Digital · Langsung Download
                                    </span>
                                @else
                                    <span class="flex items-center gap-1.5 text-xs" style="color: {{ $item->stok > 0 ? '#6b7280' : '#1a1a1a' }};">
                                        <i class="fas fa-{{ $item->stok > 0 ? 'check-circle' : 'times-circle' }}"
                                           style="font-size:11px; color: {{ $item->stok > 0 ? '#6b7280' : '#333333' }};"></i>
                                        @if($item->stok > 0)
                                            Stok tersedia ({{ $item->stok }} pcs)
                                        @else
                                            Stok habis
                                        @endif
                                    </span>
                                @endif
                            </div>

                            {{-- Spacer --}}
                            <div class="mt-auto">
                                <div class="glossy-divider" style="margin: 10px 0;"></div>

                                {{-- Harga + Tombol --}}
                                <div class="flex items-center justify-between gap-2">
                                    <div>
                                        <span class="harga-text">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </span>
                                    </div>
                                    <a href="{{ route('produk.detail', $item->slug) }}"
                                       class="btn-primary px-3.5 py-2 text-xs whitespace-nowrap gap-1.5">
                                        <i class="fas fa-eye" style="font-size:10px;"></i>
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                        </div>
                    </article>
                    @endforeach
                </div>

                @else
                {{-- ── EMPTY STATE ── --}}
                <div class="empty-state p-16 text-center">
                    <div class="w-16 h-16 mx-auto mb-5 rounded-full flex items-center justify-center"
                         style="background: #f5f5f5; border: 1px solid #e5e7eb;">
                        <i class="fas fa-search" style="color:#6b7280; font-size:22px;"></i>
                    </div>
                    <h3 class="font-semibold text-[#1a1a1a] font-montserrat mb-2">Produk Tidak Ditemukan</h3>
                    <p class="text-sm mb-6" style="color:#6b7280;">
                        @if(request('q'))
                            Tidak ada produk dengan kata kunci "<span class="text-[#1a1a1a]">{{ request('q') }}</span>".
                        @else
                            Belum ada produk yang sesuai dengan filter yang dipilih.
                        @endif
                    </p>
                    <a href="{{ route('katalog') }}" class="btn-outline px-5 py-2.5 text-sm gap-2">
                        <i class="fas fa-times" style="font-size:11px;"></i>
                        Hapus Semua Filter
                    </a>
                </div>
                @endif

                {{-- ── PAGINATION ── --}}
                @if($produk->hasPages())
                <div class="mt-10 flex items-center justify-between">
                    <p class="text-sm" style="color:#6b7280;">
                        Halaman {{ $produk->currentPage() }} dari {{ $produk->lastPage() }}
                    </p>
                    <div class="flex items-center gap-1.5">

                        {{-- Prev --}}
                        @if($produk->onFirstPage())
                            <span class="page-btn disabled">
                                <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                            </span>
                        @else
                            <a href="{{ $produk->previousPageUrl() }}" class="page-btn">
                                <i class="fas fa-chevron-left" style="font-size:10px;"></i>
                            </a>
                        @endif

                        {{-- Nomor halaman --}}
                        @foreach($produk->getUrlRange(max(1, $produk->currentPage()-2), min($produk->lastPage(), $produk->currentPage()+2)) as $page => $url)
                            @if($page == $produk->currentPage())
                                <span class="page-btn active">{{ $page }}</span>
                            @else
                                <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
                            @endif
                        @endforeach

                        {{-- Next --}}
                        @if($produk->hasMorePages())
                            <a href="{{ $produk->nextPageUrl() }}" class="page-btn">
                                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                            </a>
                        @else
                            <span class="page-btn disabled">
                                <i class="fas fa-chevron-right" style="font-size:10px;"></i>
                            </span>
                        @endif

                    </div>
                </div>
                @endif
                {{-- ── END PAGINATION ── --}}

            </div>
            {{-- ══ END GRID PRODUK ══ --}}

        </div>
        {{-- ── END LAYOUT 2 KOLOM ── --}}

    </div>
</section>
@endsection

@section('scripts')
<script>
function katalogApp() {
    return {
        hargaMax: {{ request('harga_max', 500000) }},

        updateHargaMax(val) {
            this.hargaMax = parseInt(val);
            // Sync ke input number
            const input = document.querySelector('input[name="harga_max"]');
            if (input) input.value = val;
        },

        activeFiltersCount() {
            let count = 0;
            if ({{ request('q') ? 1 : 0 }}) count++;
            if ({{ count(request()->input('kategori', [])) > 0 ? 1 : 0 }}) count++;
            if ('{{ request('tipe', '') }}' !== '') count++;
            if ({{ request('harga_min') ? 1 : 0 }} || {{ request('harga_max') ? 1 : 0 }}) count++;
            return count;
        }
    }
}
</script>
@endsection
