@extends('layouts.app')

@section('title', 'Pesanan Berhasil - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Sukses Page ── */

    @keyframes checkPop {
        0%   { transform: scale(0) rotate(-15deg); opacity: 0; }
        60%  { transform: scale(1.15) rotate(4deg); opacity: 1; }
        100% { transform: scale(1) rotate(0); opacity: 1; }
    }
    @keyframes ringPulse {
        0%, 100% { box-shadow: 0 0 0 0 rgba(22,163,74,0.15); }
        50%       { box-shadow: 0 0 0 12px rgba(22,163,74,0); }
    }
    @keyframes fadeUp {
        from { opacity: 0; transform: translateY(16px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes slideIn {
        from { opacity: 0; transform: translateX(-8px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    .success-ring {
        width: 110px; height: 110px;
        border-radius: 50%;
        background: #dcfce7;
        border: 2px solid #86efac;
        display: flex; align-items: center; justify-content: center;
        animation: ringPulse 2.5s ease-in-out infinite;
        margin: 0 auto;
        position: relative;
    }
    .success-ring::before {
        content: '';
        position: absolute; inset: 6px;
        border-radius: 50%;
        background: #bbf7d0;
        border: 1px solid rgba(22,163,74,0.15);
    }
    .success-icon {
        position: relative; z-index: 1;
        font-size: 38px;
        color: #16a34a;
        animation: checkPop 0.6s cubic-bezier(0.34,1.56,0.64,1) 0.2s both;
    }

    .order-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        padding: 28px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        animation: fadeUp 0.5s ease 0.3s both;
    }

    .info-card {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 16px 18px;
    }

    .order-detail-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
        gap: 12px;
    }
    .order-detail-row:last-child { border-bottom: none; }

    .step-next {
        display: flex;
        align-items: flex-start;
        gap: 14px;
        padding: 14px 0;
        border-bottom: 1px solid #f0f0f0;
        animation: slideIn 0.4s ease both;
    }
    .step-next:last-child { border-bottom: none; }
    .step-next:nth-child(1) { animation-delay: 0.4s; }
    .step-next:nth-child(2) { animation-delay: 0.55s; }
    .step-next:nth-child(3) { animation-delay: 0.7s; }

    .step-next-num {
        width: 28px; height: 28px; border-radius: 50%;
        background: #1a1a1a;
        border: 1px solid #1a1a1a;
        display: flex; align-items: center; justify-content: center;
        font-size: 11px; font-weight: 700; color: #ffffff;
        flex-shrink: 0; margin-top: 1px;
    }

    .btn-primary-full {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 13px 24px;
        background: #1a1a1a;
        border: none; border-radius: 10px;
        color: #ffffff;
        font-family: 'Montserrat', sans-serif; font-weight: 700; font-size: 14px;
        cursor: pointer; transition: all 0.25s ease;
        position: relative; overflow: hidden; text-decoration: none;
    }
    .btn-primary-full::before {
        content: '';
        position: absolute; top: 0; left: 0; right: 0; height: 50%;
        background: linear-gradient(180deg, rgba(255,255,255,0.07) 0%, transparent 100%);
        pointer-events: none;
    }
    .btn-primary-full:hover {
        background: #333333;
        box-shadow: 0 4px 20px rgba(26,26,26,0.2);
        transform: translateY(-1px);
    }

    .btn-outline-full {
        display: flex; align-items: center; justify-content: center; gap: 8px;
        width: 100%; padding: 12px 24px;
        background: #ffffff;
        border: 1px solid #333333; border-radius: 10px;
        color: #333333; font-family: 'Inter', sans-serif; font-weight: 500; font-size: 14px;
        cursor: pointer; transition: all 0.2s ease; text-decoration: none;
    }
    .btn-outline-full:hover {
        border-color: #1a1a1a; color: #1a1a1a;
        background: #f5f5f5;
    }

    /* Order number badge */
    .order-no-badge {
        display: inline-flex; align-items: center; gap: 8px;
        padding: 8px 16px; border-radius: 8px;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        font-family: 'Montserrat', monospace; font-weight: 700;
        color: #1a1a1a; font-size: 14px; letter-spacing: 0.08em;
    }

    .status-badge-success {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 4px 12px; border-radius: 20px;
        background: rgba(22,163,74,0.1);
        border: 1px solid rgba(22,163,74,0.25);
        color: #16a34a; font-size: 11px; font-weight: 700;
        letter-spacing: 0.05em; text-transform: uppercase;
    }
    .status-badge-success::before {
        content: ''; width: 6px; height: 6px; border-radius: 50%;
        background: #16a34a;
        box-shadow: 0 0 6px rgba(22,163,74,0.5);
    }
</style>
@endsection

@section('content')
@php
    // Ambil dari session (set oleh CheckoutController@store)
    $noOrder  = session('no_order', request('order', 'ORD-' . strtoupper(substr(md5(time()), 0, 8))));
    $tglOrder = now()->locale('id')->isoFormat('dddd, D MMMM Y · HH:mm') . ' WIB';

    // Ambil data pesanan dari DB untuk info lengkap
    $pesanan  = \App\Models\Pesanan::with(['detailPesanans.produk', 'pembayaran'])
                    ->where('no_order', $noOrder)
                    ->where('user_id', Auth::id())
                    ->first();

    $tipe     = $pesanan?->tipe_pesanan ?? 'fisik';
    $total    = $pesanan?->total ?? 0;
    $kurir    = $pesanan?->kurir ?? null;
    $metode   = $pesanan?->pembayaran?->metode ?? 'qris';
    $statusBayar = $pesanan?->pembayaran?->status ?? 'pending';
@endphp

<div class="min-h-screen" style="background:#faf8f5;">
    {{-- Flash message (optional, biasanya sudah ditampilkan di layout) --}}

    <div class="max-w-xl mx-auto px-4 sm:px-6 py-14">

        {{-- ── Success Icon ── --}}
        <div class="text-center mb-8">
            <div class="success-ring mb-6">
                <i class="fas fa-check success-icon"></i>
            </div>

            <div class="mb-3">
                <span class="status-badge-success">Pembayaran Berhasil</span>
            </div>

            <h1 class="font-montserrat font-bold text-[#1a1a1a] text-3xl tracking-tight mb-2">
                Pesanan Dikonfirmasi!
            </h1>
            <p class="text-sm leading-relaxed" style="color:#6b7280; max-width:320px; margin:0 auto;">
                @if($tipe === 'digital')
                    File PDF kamu sudah siap. Cek email untuk link download atau unduh langsung dari halaman akun.
                @elseif($metode === 'cod')
                    Pesanan COD berhasil dibuat. Siapkan uang pas saat kurir datang mengantarkan pesanan.
                @elseif($metode === 'transfer')
                    Bukti transfer berhasil diupload. Admin akan memverifikasi dalam 1×24 jam.
                @else
                    Bukti pembayaran QRIS berhasil diupload. Admin akan memverifikasi dalam 1×24 jam.
                @endif
            </p>
        </div>

        {{-- ── Order Card ── --}}
        <div class="order-card">

            {{-- No Order --}}
            <div class="text-center mb-6">
                <div class="text-xs mb-2" style="color:#6b7280; letter-spacing:0.05em; text-transform:uppercase;">
                    Nomor Pesanan Kamu
                </div>
                <div class="order-no-badge">
                    <i class="fas fa-receipt" style="font-size:12px; opacity:0.7;"></i>
                    {{ $noOrder }}
                </div>
                <div class="text-xs mt-2" style="color:#6b7280;">{{ $tglOrder }}</div>
            </div>

            {{-- Detail baris --}}
            <div class="info-card mb-5">
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Status Pembayaran</span>
                    @if($metode === 'cod')
                        <span class="status-badge-success" style="font-size:10px;">Diproses</span>
                    @elseif($statusBayar === 'berhasil')
                        <span class="status-badge-success" style="font-size:10px;">Lunas</span>
                    @else
                        <span style="display:inline-flex; align-items:center; gap:6px; padding:4px 12px; border-radius:20px; background:rgba(234,179,8,0.1); border:1px solid rgba(234,179,8,0.3); color:#d97706; font-size:11px; font-weight:700; letter-spacing:0.05em; text-transform:uppercase;">
                            <span style="width:6px; height:6px; border-radius:50%; background:#d97706; display:inline-block;"></span>
                            Menunggu Verifikasi
                        </span>
                    @endif
                </div>
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Metode Bayar</span>
                    <span class="font-medium text-sm" style="color:#1a1a1a;">
                        @if($metode === 'transfer')
                            <i class="fas fa-university mr-1.5" style="color:#333333; font-size:11px;"></i>Transfer Bank (SeaBank)
                        @elseif($metode === 'cod')
                            <i class="fas fa-money-bill-wave mr-1.5" style="color:#d97706; font-size:11px;"></i>COD (Bayar di Tempat)
                        @else
                            <i class="fas fa-qrcode mr-1.5" style="color:#333333; font-size:11px;"></i>QRIS (DANA)
                        @endif
                    </span>
                </div>
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Tipe Produk</span>
                    <span class="text-sm font-semibold" style="color:#1a1a1a;">
                        {{ $tipe === 'digital' ? '⬡ Digital PDF' : '📦 Fisik (Hard Tube)' }}
                    </span>
                </div>
                @if($tipe === 'fisik')
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Kurir</span>
                    <span class="text-sm" style="color:#1a1a1a;">{{ $kurir ? strtoupper($kurir) : 'JNE' }} · Est. 2–3 hari</span>
                </div>
                <div class="order-detail-row">
                    <span style="color:#6b7280;">No. Resi</span>
                    <span class="text-sm" style="color:#6b7280;">Akan dikirim via WhatsApp & Email</span>
                </div>
                @else
                <div class="order-detail-row">
                    <span style="color:#6b7280;">File Download</span>
                    <span class="text-sm font-semibold" style="color:#16a34a;">
                        <i class="fas fa-check-circle mr-1"></i>Tersedia Sekarang
                    </span>
                </div>
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Link Dikirim ke</span>
                    <span class="text-sm" style="color:#1a1a1a;">{{ Auth::user()->email }}</span>
                </div>
                @endif
                <div class="order-detail-row">
                    <span style="color:#6b7280;">Total Dibayar</span>
                    <span class="font-montserrat font-bold" style="color:#1a1a1a; font-size:16px;">
                        Rp {{ number_format($total, 0, ',', '.') }}
                    </span>
                </div>
            </div>

            {{-- ── Info Pembayaran berdasarkan metode ── --}}
            @if($metode === 'qris')
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:18px 20px; margin-bottom:20px; display:flex; align-items:flex-start; gap:12px;">
                <i class="fas fa-clock" style="color:#16a34a; font-size:14px; margin-top:2px; flex-shrink:0;"></i>
                <div>
                    <p style="font-size:13px; font-weight:600; color:#166534; margin-bottom:4px;">Menunggu Verifikasi Admin</p>
                    <p style="font-size:12px; color:#166534; line-height:1.6;">
                        Bukti pembayaran QRIS berhasil diupload. Admin akan memverifikasi dalam <strong>1×24 jam</strong>. Pesanan akan segera diproses setelah terverifikasi.
                    </p>
                </div>
            </div>

            @elseif($metode === 'transfer')
            <div style="background:#fffbeb; border:1px solid rgba(234,179,8,0.3); border-radius:12px; padding:20px; margin-bottom:20px;">
                <div class="flex items-center gap-2 mb-4">
                    <i class="fas fa-clock" style="color:#d97706; font-size:14px;"></i>
                    <span style="font-size:13px; font-weight:700; color:#1a1a1a;">Menunggu Verifikasi Transfer</span>
                </div>
                <p style="font-size:12px; color:#92400e; line-height:1.6; margin-bottom:12px;">
                    Bukti transfer berhasil diupload. Admin akan memverifikasi ke rekening SeaBank <strong style="color:#1a1a1a;">901339829925</strong> a/n <strong style="color:#1a1a1a;">Saepudin</strong> dalam <strong>1×24 jam</strong>.
                </p>
                <p style="font-size:12px; color:#92400e; line-height:1.6;">
                    Ada pertanyaan? Chat kami di WhatsApp
                    <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer"
                       style="font-weight:700; color:#1a1a1a;">+62 882-9678-3577</a>.
                </p>
            </div>

            @elseif($metode === 'cod')
            <div style="background:#f0fdf4; border:1px solid #bbf7d0; border-radius:12px; padding:18px 20px; margin-bottom:20px; display:flex; align-items:flex-start; gap:12px;">
                <i class="fas fa-truck" style="color:#16a34a; font-size:14px; margin-top:2px; flex-shrink:0;"></i>
                <div>
                    <p style="font-size:13px; font-weight:600; color:#166534; margin-bottom:4px;">Pesanan COD Sedang Diproses</p>
                    <p style="font-size:12px; color:#166534; line-height:1.6;">
                        Tim kami akan mengemas pola dan mengirimkan via kurir. Siapkan uang pas saat barang tiba — kamu tidak perlu upload bukti apapun.
                    </p>
                </div>
            </div>
            @endif

            {{-- ── Langkah Selanjutnya ── --}}
            <div class="mb-5">
                <div class="text-xs font-semibold mb-3 uppercase tracking-widest" style="color:#6b7280;">
                    Langkah Selanjutnya
                </div>

                @if($tipe === 'digital')
                <div class="step-next">
                    <div class="step-next-num">1</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Cek email kamu</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            Link download file PDF dikirim ke <span style="color:#333333;">budi.atelier@garmentpro.com</span> dalam 30 detik.
                        </p>
                    </div>
                </div>
                <div class="step-next">
                    <div class="step-next-num">2</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Download file PDF / CAD</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            Bisa diunduh berulang kali dari halaman akun · tidak ada batas download.
                        </p>
                    </div>
                </div>
                <div class="step-next">
                    <div class="step-next-num">3</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Cetak &amp; mulai produksi</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            Cetak di plotter A0 atau A4 multi-sheet. Butuh bantuan? Chat support kami.
                        </p>
                    </div>
                </div>
                @else
                <div class="step-next">
                    <div class="step-next-num">1</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Pesanan sedang dikemas</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            Tim kami akan mengemas pola dalam hard tube silinder 2mm yang tahan air.
                        </p>
                    </div>
                </div>
                <div class="step-next">
                    <div class="step-next-num">2</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Nomor resi dikirim ke kamu</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            No. resi JNE akan dikirim via WhatsApp &amp; email dalam 1×24 jam setelah packing selesai.
                        </p>
                    </div>
                </div>
                <div class="step-next">
                    <div class="step-next-num">3</div>
                    <div>
                        <p class="text-sm font-semibold text-[#1a1a1a]">Terima &amp; cek pesanan</p>
                        <p class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">
                            Pastikan pola diterima dalam kondisi baik. Ada masalah? Foto &amp; kirim ke WA kami dalam 2×24 jam.
                        </p>
                    </div>
                </div>
                @endif
            </div>

            {{-- ── Action Buttons ── --}}
            <div class="flex flex-col gap-3">
                @if($tipe === 'digital')
                <a href="{{ route('dashboard') }}" class="btn-primary-full">
                    <i class="fas fa-download" style="font-size:13px;"></i>
                    Download File Sekarang
                </a>
                @else
                <a href="{{ route('dashboard') }}" class="btn-primary-full">
                    <i class="fas fa-box" style="font-size:12px;"></i>
                    Lacak Pesanan
                </a>
                @endif

                <a href="{{ route('katalog') }}" class="btn-outline-full">
                    <i class="fas fa-store" style="font-size:12px;"></i>
                    Lanjut Belanja
                </a>
            </div>

        </div>{{-- end order-card --}}

        {{-- ── Support ── --}}
        <div class="mt-6 flex flex-col sm:flex-row items-center justify-center gap-4 text-xs" style="color:#6b7280;">
            <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer" class="hover:text-[#1a1a1a] transition-colors flex items-center gap-1.5">
                <i class="fab fa-whatsapp" style="color:#22c55e;"></i>
                Chat via WhatsApp
            </a>
            <span class="hidden sm:inline" style="color:#d1d5db;">·</span>
            <a href="#" class="hover:text-[#1a1a1a] transition-colors flex items-center gap-1.5">
                <i class="fas fa-envelope"></i>
                hello@patternshop.id
            </a>
            <span class="hidden sm:inline" style="color:#d1d5db;">·</span>
            <a href="{{ route('katalog') }}" class="hover:text-[#1a1a1a] transition-colors">
                Katalog Pola
            </a>
        </div>

    </div>
</div>

<script>
    function copyNorekSukses() {
        var norek = document.getElementById('norek-sukses').textContent.trim();
        navigator.clipboard.writeText(norek).then(function () {
            var icon = document.getElementById('copy-icon-sukses');
            if (icon) {
                icon.className = 'fas fa-check';
                icon.style.color = '#16a34a';
                setTimeout(function () {
                    icon.className = 'fas fa-copy';
                    icon.style.color = '#6b7280';
                }, 2000);
            }
        }).catch(function () {
            alert('No. rekening: ' + norek);
        });
    }
</script>
@endsection
