@extends('layouts.app')

@section('title', 'Keranjang - Pattern Digital Shop')

@section('styles')
<style>
    .cart-card-silver {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.06);
    }
    .cart-item + .cart-item { border-top: 1px solid #e5e7eb; }

    .qty-btn {
        width: 30px; height: 30px;
        display: inline-flex; align-items: center; justify-content: center;
        background: #f5f5f5; border: 1px solid #e5e7eb; border-radius: 6px;
        color: #6b7280; font-size: 14px; cursor: pointer; transition: all 0.2s ease;
    }
    .qty-btn:hover { border-color: #1a1a1a; color: #1a1a1a; }
    .qty-btn:disabled { opacity: 0.35; cursor: not-allowed; }

    .qty-input {
        width: 44px; height: 30px; text-align: center;
        background: #ffffff; border: 1px solid #e5e7eb; border-radius: 6px;
        color: #1a1a1a; font-size: 14px; outline: none;
    }
    .qty-input:focus { border-color: #1a1a1a; }

    .btn-delete {
        display: inline-flex; align-items: center; justify-content: center;
        width: 32px; height: 32px;
        background: rgba(239,68,68,0.08); border: 1px solid rgba(239,68,68,0.25);
        border-radius: 6px; color: #ef4444; cursor: pointer; transition: all 0.2s ease;
        font-size: 12px;
    }
    .btn-delete:hover { background: rgba(239,68,68,0.15); border-color: #ef4444; }

    .badge-digital {
        background: rgba(51,51,51,0.07); border: 1px solid rgba(51,51,51,0.15);
        color: #333333; font-size: 10px; font-weight: 600;
        padding: 2px 7px; border-radius: 4px; text-transform: uppercase;
    }
    .badge-fisik {
        background: rgba(168,85,247,0.08); border: 1px solid rgba(168,85,247,0.2);
        color: #7c3aed; font-size: 10px; font-weight: 600;
        padding: 2px 7px; border-radius: 4px; text-transform: uppercase;
    }

    .summary-sticky { position: sticky; top: 80px; }
    .summary-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 10px 0; border-bottom: 1px solid #f0f0f0; font-size: 0.875rem;
    }
    .summary-row:last-child { border-bottom: none; }
    .total-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 14px 0 0 0;
    }

    .btn-primary-lg {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 14px 24px;
        background: #1a1a1a; border: none; border-radius: 10px;
        color: #ffffff; font-family: 'Montserrat', sans-serif;
        font-weight: 600; font-size: 0.9375rem; cursor: pointer;
        transition: all 0.25s ease; text-decoration: none; position: relative; overflow: hidden;
    }
    .btn-primary-lg::before {
        content: ''; position: absolute; top: 0; left: 0; right: 0; height: 50%;
        background: linear-gradient(180deg, rgba(255,255,255,0.07) 0%, transparent 100%);
        pointer-events: none;
    }
    .btn-primary-lg:hover { background: #333333; box-shadow: 0 4px 20px rgba(26,26,26,0.2); transform: translateY(-1px); }

    .alert-success {
        background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d;
        border-radius: 8px; padding: 10px 16px; font-size: 13px;
        display: flex; align-items: center; gap: 8px;
    }
    .alert-error {
        background: #fef2f2; border: 1px solid #fecaca; color: #dc2626;
        border-radius: 8px; padding: 10px 16px; font-size: 13px;
        display: flex; align-items: center; gap: 8px;
    }
</style>
@endsection

@section('content')
<div class="min-h-screen" style="background: #faf8f5;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Flash messages --}}
        @if(session('success'))
        <div class="alert-success mb-5">
            <i class="fas fa-check-circle"></i>
            {{ session('success') }}
        </div>
        @endif
        @if(session('error'))
        <div class="alert-error mb-5">
            <i class="fas fa-exclamation-circle"></i>
            {{ session('error') }}
        </div>
        @endif

        {{-- Header --}}
        <div class="mb-8">
            <div class="flex items-center text-xs mb-4" style="color:#6b7280;">
                <a href="{{ route('home') }}" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
                <span class="mx-2" style="color:#d1d5db;"><i class="fas fa-chevron-right" style="font-size:9px;"></i></span>
                <span style="color:#1a1a1a;">Keranjang</span>
            </div>
            <div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-2">
                <div>
                    <h1 class="font-montserrat font-bold text-[#1a1a1a] text-3xl tracking-tight">Keranjang Belanja</h1>
                    @if($keranjang->count() > 0)
                    <p class="mt-1.5 text-sm" style="color:#6b7280;">
                        <i class="fas fa-shopping-cart mr-1.5" style="color:#333333;"></i>
                        {{ $keranjang->count() }} item di keranjang
                    </p>
                    @endif
                </div>
                @if($keranjang->count() > 0)
                <a href="{{ route('katalog') }}" class="btn-outline px-4 py-2 text-sm self-start sm:self-auto gap-2">
                    <i class="fas fa-arrow-left" style="font-size:11px;"></i> Lanjut Belanja
                </a>
                @endif
            </div>
        </div>

        {{-- EMPTY STATE --}}
        @if($keranjang->isEmpty())
        <div class="flex flex-col items-center justify-center py-24 text-center">
            <div class="w-24 h-24 rounded-full flex items-center justify-center mx-auto mb-6"
                 style="background:#f5f5f5; border:1px solid #e5e7eb;">
                <i class="fas fa-shopping-cart" style="font-size:36px; color:#6b7280;"></i>
            </div>
            <h2 class="font-montserrat font-bold text-[#1a1a1a] text-2xl mb-3">Keranjang kamu kosong</h2>
            <p class="text-sm max-w-xs leading-relaxed mb-8" style="color:#6b7280;">
                Yuk, mulai belanja pola jahit berkualitas dan temukan koleksi favoritmu.
            </p>
            <a href="{{ route('katalog') }}" class="btn-primary px-8 py-3 text-sm gap-2">
                <i class="fas fa-store" style="font-size:12px;"></i> Lihat Katalog
            </a>
        </div>

        @else
        {{-- LAYOUT 2 KOLOM --}}
        <div class="flex flex-col lg:flex-row gap-7 items-start">

            {{-- KIRI (70%) — List Produk --}}
            <div class="w-full lg:w-[68%]">
                <div class="cart-card-silver overflow-hidden">

                    {{-- Header kolom --}}
                    <div class="px-6 py-4 flex items-center justify-between" style="border-bottom:1px solid #e5e7eb;">
                        <span class="font-montserrat font-semibold text-[#1a1a1a] text-sm tracking-wide uppercase">Produk</span>
                        <div class="hidden sm:grid grid-cols-3 gap-4 text-xs font-medium uppercase tracking-wide"
                             style="color:#6b7280; width:260px;">
                            <span class="text-center">Harga</span>
                            <span class="text-center">Jumlah</span>
                            <span class="text-right">Subtotal</span>
                        </div>
                    </div>

                    {{-- Item rows --}}
                    @foreach($keranjang as $item)
                    @php
                        $produk   = $item->produk;
                        $imgSrc   = $produk->gambar
                            ? asset('storage/' . $produk->gambar)
                            : 'https://via.placeholder.com/80x80/f5f5f5/6b7280?text=' . urlencode(\Illuminate\Support\Str::limit($produk->nama_produk, 12));
                        $maxStock = $produk->tipe === 'fisik' ? $produk->stok : 99;
                    @endphp
                    <div class="cart-item px-6 py-5"
                         x-data="{
                            qty: {{ $item->jumlah }},
                            harga: {{ $produk->harga }},
                            get subtotal() { return this.qty * this.harga; },
                            formatRp(n) { return 'Rp ' + n.toLocaleString('id-ID'); }
                         }">
                        <div class="flex flex-col sm:flex-row sm:items-center gap-4">

                            {{-- Foto + Info --}}
                            <div class="flex items-center gap-4 flex-1 min-w-0">
                                <a href="{{ route('produk.detail', $produk->slug) }}"
                                   class="shrink-0 rounded-lg overflow-hidden block"
                                   style="width:80px; height:80px; border:1px solid #e5e7eb; background:#f5f5f5;">
                                    <img src="{{ $imgSrc }}" alt="{{ $produk->nama_produk }}"
                                         class="w-full h-full object-cover"
                                         onerror="this.src='https://via.placeholder.com/80x80/f5f5f5/6b7280?text=?'">
                                </a>
                                <div class="min-w-0">
                                    <a href="{{ route('produk.detail', $produk->slug) }}"
                                       class="font-montserrat font-semibold text-[#1a1a1a] text-sm leading-snug hover:underline block truncate pr-2">
                                        {{ $produk->nama_produk }}
                                    </a>
                                    <p class="text-xs mt-0.5" style="color:#6b7280;">
                                        {{ $produk->kategori->nama_kategori ?? '—' }}
                                    </p>
                                    <span class="mt-1.5 inline-block {{ $produk->tipe === 'digital' ? 'badge-digital' : 'badge-fisik' }}">
                                        {{ $produk->tipe === 'digital' ? 'Digital PDF' : 'Fisik' }}
                                    </span>
                                    @if($produk->tipe === 'fisik')
                                    <p class="text-xs mt-1" style="color:#6b7280;">Stok: {{ $produk->stok }} pcs</p>
                                    @endif
                                    <p class="sm:hidden mt-2 text-sm font-semibold" style="color:#1a1a1a;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>

                            {{-- Desktop: Harga | Qty | Subtotal --}}
                            <div class="hidden sm:grid grid-cols-3 gap-4 items-center shrink-0" style="width:260px;">

                                <div class="text-center">
                                    <span class="text-sm font-semibold" style="color:#1a1a1a;">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                {{-- Update qty form --}}
                                <div class="flex items-center justify-center gap-1.5">
                                    <form action="{{ route('keranjang.update', $item->id) }}" method="POST" id="form-qty-{{ $item->id }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="flex items-center gap-1.5">
                                            <button type="button" class="qty-btn"
                                                    @click="if(qty>1){ qty--; $el.closest('form').querySelector('input[name=jumlah]').value=qty; $el.closest('form').submit(); }"
                                                    :disabled="qty <= 1">
                                                <i class="fas fa-minus" style="font-size:10px; pointer-events:none;"></i>
                                            </button>
                                            <input type="number" name="jumlah" class="qty-input"
                                                   x-model.number="qty" min="1" max="{{ $maxStock }}"
                                                   @change="$el.closest('form').submit()" readonly>
                                            <button type="button" class="qty-btn"
                                                    @click="if(qty < {{ $maxStock }}){ qty++; $el.closest('form').querySelector('input[name=jumlah]').value=qty; $el.closest('form').submit(); }">
                                                <i class="fas fa-plus" style="font-size:10px; pointer-events:none;"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>

                                {{-- Subtotal + delete --}}
                                <div class="flex items-center justify-end gap-2">
                                    <span class="text-sm font-bold" style="color:#1a1a1a;" x-text="formatRp(subtotal)"></span>
                                    <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini dari keranjang?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete" title="Hapus">
                                            <i class="fas fa-trash-alt" style="pointer-events:none;"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                            {{-- Mobile: Qty + Subtotal --}}
                            <div class="sm:hidden flex items-center justify-between">
                                <form action="{{ route('keranjang.update', $item->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex items-center gap-1.5">
                                        <button type="button" class="qty-btn"
                                                @click="if(qty>1){ qty--; $el.closest('form').querySelector('input[name=jumlah]').value=qty; $el.closest('form').submit(); }"
                                                :disabled="qty <= 1">
                                            <i class="fas fa-minus" style="font-size:10px;"></i>
                                        </button>
                                        <input type="number" name="jumlah" class="qty-input"
                                               x-model.number="qty" min="1" max="{{ $maxStock }}" readonly>
                                        <button type="button" class="qty-btn"
                                                @click="if(qty < {{ $maxStock }}){ qty++; $el.closest('form').querySelector('input[name=jumlah]').value=qty; $el.closest('form').submit(); }">
                                            <i class="fas fa-plus" style="font-size:10px;"></i>
                                        </button>
                                    </div>
                                </form>
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold" style="color:#1a1a1a;" x-text="formatRp(subtotal)"></span>
                                    <form action="{{ route('keranjang.destroy', $item->id) }}" method="POST"
                                          onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-delete">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach

                </div>

                <div class="mt-5">
                    <a href="{{ route('katalog') }}" class="btn-outline px-5 py-2.5 text-sm gap-2">
                        <i class="fas fa-arrow-left" style="font-size:11px;"></i> Lanjut Belanja
                    </a>
                </div>
            </div>

            {{-- KANAN (30%) — Ringkasan --}}
            <div class="w-full lg:w-[32%]">
                <div class="summary-sticky cart-card-silver p-6">
                    <h2 class="font-montserrat font-bold text-[#1a1a1a] text-base tracking-wide uppercase mb-5">
                        Ringkasan Pesanan
                    </h2>

                    <div style="border-top:1px solid #e5e7eb;">
                        <div class="summary-row">
                            <span style="color:#6b7280;">Subtotal ({{ $keranjang->count() }} item)</span>
                            <span class="font-medium" style="color:#1a1a1a;">
                                Rp {{ number_format($subtotal, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="summary-row">
                            <span style="color:#6b7280;">Ongkos Kirim</span>
                            @if($ongkir === 0)
                                <span style="color:#16a34a; font-weight:600; font-size:0.8125rem;">Gratis</span>
                            @else
                                <span class="font-medium" style="color:#1a1a1a;">
                                    Rp {{ number_format($ongkir, 0, ',', '.') }}
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="total-row" style="border-top:1px solid #e5e7eb; margin-top:6px;">
                        <span class="font-montserrat font-bold text-[#1a1a1a] text-base">Total</span>
                        <span class="font-montserrat font-bold" style="font-size:1.375rem; color:#1a1a1a;">
                            Rp {{ number_format($total, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="mt-6">
                        <a href="{{ route('checkout') }}" class="btn-primary-lg">
                            <i class="fas fa-lock" style="font-size:12px; opacity:0.8;"></i>
                            Lanjut ke Checkout
                            <i class="fas fa-arrow-right" style="font-size:11px; opacity:0.7;"></i>
                        </a>
                        <p class="text-center text-xs mt-2" style="color:#6b7280;">
                            @if($adaFisik)
                                <i class="fas fa-box mr-1" style="font-size:9px;"></i>Ada produk fisik — checkout dengan pengiriman
                            @else
                                <i class="fas fa-file-pdf mr-1" style="font-size:9px;"></i>Semua digital — tanpa ongkir
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 flex items-center justify-center gap-2 py-3 rounded-lg"
                         style="background:#f5f5f5; border:1px solid #e5e7eb;">
                        <i class="fas fa-shield-alt" style="color:#333333; font-size:12px;"></i>
                        <span class="text-xs" style="color:#6b7280;">Pembayaran aman via</span>
                        <span class="text-xs font-semibold" style="color:#1a1a1a;">Midtrans</span>
                    </div>

                    <div class="mt-3 flex items-center justify-center gap-2 flex-wrap">
                        @foreach(['VISA','MC','BCA','Mandiri','GoPay','OVO'] as $pm)
                        <span class="px-2 py-1 rounded text-xs font-medium"
                              style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280; font-size:9px; letter-spacing:0.04em;">
                            {{ $pm }}
                        </span>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
        @endif

    </div>
</div>
@endsection
