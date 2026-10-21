@extends('layouts.app')

@section('title', 'Kontak - Pattern Digital Shop')

@section('styles')
<style>
    /* ── Kontak Page ── */

    /* Hero */
    .kontak-hero {
        position: relative;
        padding: 80px 0 64px;
        overflow: hidden;
        text-align: center;
    }
    .kontak-hero::before {
        content: '';
        position: absolute; inset: 0;
        background:
            radial-gradient(ellipse 60% 40% at 50% 0%, rgba(51,51,51,0.04) 0%, transparent 70%),
            repeating-linear-gradient(
                0deg, transparent, transparent 39px,
                rgba(0,0,0,0.025) 39px, rgba(0,0,0,0.025) 40px
            ),
            repeating-linear-gradient(
                90deg, transparent, transparent 39px,
                rgba(0,0,0,0.025) 39px, rgba(0,0,0,0.025) 40px
            );
        pointer-events: none;
    }
    .hero-label {
        display: inline-flex; align-items: center; gap: 7px;
        padding: 5px 14px; border-radius: 20px;
        background: rgba(51,51,51,0.07);
        border: 1px solid rgba(51,51,51,0.15);
        color: #333333;
        font-size: 11px; font-weight: 700;
        letter-spacing: 0.1em; text-transform: uppercase;
        margin-bottom: 20px;
    }

    /* Stat cards */
    .stat-hero-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 20px 24px;
        text-align: center;
        transition: all 0.2s;
        position: relative; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .stat-hero-card:hover {
        border-color: #333333;
        box-shadow: 0 8px 24px rgba(0,0,0,0.08);
        transform: translateY(-2px);
    }
    .stat-num {
        font-family: 'Montserrat', sans-serif;
        font-weight: 800; font-size: 2rem;
        color: #1a1a1a;
        line-height: 1;
    }

    /* Section label */
    .section-label {
        display: inline-flex; align-items: center; gap: 6px;
        font-size: 10px; font-weight: 700;
        color: #6b7280; letter-spacing: 0.12em; text-transform: uppercase;
        margin-bottom: 10px;
    }
    .section-label::before, .section-label::after {
        content: ''; flex: 1; height: 1px; background: #e5e7eb; width: 24px;
    }

    /* Story section */
    .story-img {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        position: relative;
    }

    /* Quote */
    .founder-quote {
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-left: 3px solid #333333;
        border-radius: 0 10px 10px 0;
        padding: 16px 20px;
        margin-top: 20px;
        position: relative;
    }
    .founder-quote::before {
        content: '\201C';
        position: absolute; top: -8px; left: 14px;
        font-size: 48px; line-height: 1;
        color: rgba(51,51,51,0.1);
        font-family: Georgia, serif;
    }

    /* Contact cards */
    .kontak-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        padding: 28px 24px;
        text-align: center;
        transition: all 0.25s ease;
        position: relative; overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .kontak-card:hover {
        border-color: #333333;
        box-shadow: 0 8px 32px rgba(0,0,0,0.1);
        transform: translateY(-3px);
    }
    .kontak-icon {
        width: 52px; height: 52px; border-radius: 14px;
        display: flex; align-items: center; justify-content: center;
        margin: 0 auto 16px;
        font-size: 20px;
    }

    /* Jam ops */
    .jam-row {
        display: flex; justify-content: space-between; align-items: center;
        padding: 11px 0;
        border-bottom: 1px solid #f0f0f0;
        font-size: 13px;
    }
    .jam-row:last-child { border-bottom: none; }
    .jam-dot {
        width: 6px; height: 6px; border-radius: 50%;
        display: inline-block; margin-right: 8px;
    }

    /* Maps */
    .maps-wrap {
        border-radius: 14px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
        position: relative;
    }
    .maps-wrap iframe { display: block; }
    .maps-overlay-badge {
        position: absolute; bottom: 16px; left: 16px;
        background: rgba(255,255,255,0.95);
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        padding: 10px 14px;
        backdrop-filter: blur(10px);
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }

    /* Form kontak */
    .form-input-kontak {
        width: 100%;
        background: #f5f5f5;
        border: 1px solid #e5e7eb;
        border-radius: 8px;
        color: #1a1a1a; font-size: 13px;
        font-family: 'Inter', sans-serif;
        padding: 10px 14px;
        outline: none; transition: border-color 0.2s;
    }
    .form-input-kontak:focus { border-color: #1a1a1a; box-shadow: 0 0 0 2px rgba(26,26,26,0.06); }
    .form-input-kontak::placeholder { color: #9ca3af; }
    textarea.form-input-kontak { resize: vertical; min-height: 120px; }
    select.form-input-kontak { cursor: pointer; }
    select.form-input-kontak option { background: #ffffff; color: #1a1a1a; }

    .form-label-kontak {
        display: block; font-size: 11px; font-weight: 600;
        color: #1a1a1a; margin-bottom: 6px;
        letter-spacing: 0.04em; text-transform: uppercase;
    }

    /* Divider */
    .silver-divider {
        height: 1px;
        background: linear-gradient(90deg, transparent, #e5e7eb, transparent);
        margin: 56px 0;
    }

    /* Section card */
    .section-card {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 14px;
        overflow: hidden;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }
    .section-card-header {
        padding: 16px 22px;
        border-bottom: 1px solid #e5e7eb;
        background: #faf8f5;
        display: flex; align-items: center; gap: 10px;
    }
    .section-card-body { padding: 22px; }

    /* Trust badges */
    .trust-item {
        display: flex; align-items: center; gap: 10px;
        padding: 10px 14px; border-radius: 8px;
        background: #f5f5f5; border: 1px solid #e5e7eb;
        transition: border-color 0.2s;
    }
    .trust-item:hover { border-color: #d1d5db; }
</style>
@endsection

@section('content')
<div style="background:#faf8f5;">

    {{-- ══════════════════════════════════════ --}}
    {{-- HERO                                   --}}
    {{-- ══════════════════════════════════════ --}}
    <section class="kontak-hero">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">

            {{-- Breadcrumb --}}
            <div class="flex items-center justify-center gap-2 text-xs mb-8" style="color:#6b7280;">
                <a href="{{ route('home') }}" class="hover:text-[#1a1a1a] transition-colors">Beranda</a>
                <i class="fas fa-chevron-right" style="font-size:8px;"></i>
                <span style="color:#1a1a1a;">Tentang Kami</span>
            </div>

            <div class="hero-label">
                <i class="fas fa-scissors" style="font-size:9px;"></i>
                Pattern Digital Shop — Since 2020
            </div>

            <h1 class="font-montserrat font-bold text-[#1a1a1a] mb-4"
                style="font-size:clamp(2rem,5vw,3rem); line-height:1.15; letter-spacing:-0.02em;">
                Tentang Pattern<br>
                <span style="color:#333333;">Digital Shop</span>
            </h1>
            <p class="text-sm leading-relaxed mx-auto mb-10" style="color:#6b7280; max-width:520px;">
                Partner terpercaya untuk kebutuhan pola jahit Anda — dari pola fisik premium hingga file CAD digital resolusi tinggi.
            </p>

            {{-- Stats --}}
            <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 max-w-2xl mx-auto">
                @foreach([
                    ['num'=>'3.500+', 'label'=>'Customer Aktif',      'sub'=>'Di seluruh Indonesia'],
                    ['num'=>'10.000+','label'=>'Pola Terjual',        'sub'=>'Fisik & Digital'],
                    ['num'=>'99.8%',  'label'=>'Kepuasan Pelanggan',  'sub'=>'Rating & Ulasan'],
                ] as $s)
                <div class="stat-hero-card">
                    <div class="stat-num">{{ $s['num'] }}</div>
                    <div class="text-sm font-semibold text-[#1a1a1a] mt-2">{{ $s['label'] }}</div>
                    <div class="text-xs mt-1" style="color:#6b7280;">{{ $s['sub'] }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- ══════════════════════════════════════ --}}
        {{-- CERITA / ABOUT 2 KOLOM                 --}}
        {{-- ══════════════════════════════════════ --}}
        <section class="py-16">
            <div class="flex flex-col lg:flex-row gap-14 items-center">

                {{-- KIRI: Teks --}}
                <div class="w-full lg:w-[55%]">
                    <div class="section-label">
                        <i class="fas fa-star" style="font-size:9px; color:#333333;"></i>
                        Cerita Kami
                    </div>
                    <h2 class="font-montserrat font-bold text-[#1a1a1a] text-3xl leading-tight mb-6">
                        Menjembatani Visi Desainer Busana dengan Ketepatan Produksi Garmen Massal
                    </h2>

                    <div class="space-y-4 text-sm leading-relaxed" style="color:#6b7280;">
                        <p>
                            Pattern Digital Shop lahir dari kegelisahan seorang pattern maker profesional yang melihat kesenjangan antara desain busana yang indah dengan implementasi produksi yang presisi. Sejak 2020, kami telah menjadi jembatan antara kreativitas desainer dan realita produksi garmen skala massal.
                        </p>
                        <p>
                            Kami menyediakan pola jahit berkualitas tinggi — baik dalam format fisik yang dicetak pada kertas kraft premium maupun file digital CAD yang siap digunakan langsung di mesin plotter. Setiap pola dikerjakan oleh tim pattern maker berpengalaman dengan standar industri garmen internasional.
                        </p>
                        <p>
                            Visi kami sederhana: <strong style="color:#1a1a1a;">membuat pola berkualitas profesional dapat diakses oleh siapapun</strong> — mulai dari penjahit rumahan, studio fashion, hingga pabrik garmen skala besar.
                        </p>
                        <p>
                            Bergabunglah dengan lebih dari 3.500 customer aktif yang telah mempercayakan kebutuhan pola mereka kepada kami. Kualitas premium, harga terjangkau, dan layanan yang responsif adalah komitmen kami setiap hari.
                        </p>
                    </div>

                    <div class="founder-quote">
                        <p class="text-sm leading-relaxed italic" style="color:#6b7280;">
                            "Kami percaya bahwa pola yang baik adalah fondasi dari busana yang sempurna. Setiap garis dan kurva yang kami buat membawa tanggung jawab terhadap kualitas akhir produk yang dikenakan."
                        </p>
                        <div class="flex items-center gap-3 mt-3">
                            <div style="width:32px; height:32px; border-radius:50%; background:#e5e7eb; border:1px solid #d1d5db; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas fa-user" style="color:#6b7280; font-size:12px;"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[#1a1a1a]">Budi Setiawan</div>
                                <div class="text-xs" style="color:#6b7280;">Founder & Head Pattern Maker</div>
                            </div>
                            <div style="width:30px; height:1px; background:linear-gradient(90deg,#333333,transparent); margin-left:4px;"></div>
                            <span class="text-xs" style="color:#6b7280;">Pattern Digital Shop</span>
                        </div>
                    </div>
                </div>

                {{-- KANAN: Gambar --}}
                <div class="w-full lg:w-[45%]">
                    <div class="story-img">
                        <img src="https://via.placeholder.com/600x440/f5f5f5/6b7280?text=Workshop+Pattern+Maker"
                             alt="Workshop Pattern Digital Shop"
                             class="w-full h-auto"
                             onerror="this.src='https://via.placeholder.com/600x440/f5f5f5/6b7280?text=Workshop'">
                    </div>

                    <div class="grid grid-cols-2 gap-3 mt-4">
                        @foreach([
                            ['icon'=>'fa-certificate',   'color'=>'#333333', 'label'=>'Produk Asli',    'sub'=>'100% Garansi Kualitas'],
                            ['icon'=>'fa-redo',          'color'=>'#3b82f6', 'label'=>'Revisi Gratis',  'sub'=>'Jika ada kesalahan cetak'],
                            ['icon'=>'fa-headset',       'color'=>'#16a34a', 'label'=>'Support Aktif',  'sub'=>'Chat WA 08.00–20.00'],
                            ['icon'=>'fa-shipping-fast', 'color'=>'#7c3aed', 'label'=>'Kirim Cepat',   'sub'=>'Same day Jabodetabek'],
                        ] as $t)
                        <div class="trust-item">
                            <div style="width:32px; height:32px; border-radius:8px; background:{{ $t['color'] }}15; border:1px solid {{ $t['color'] }}25; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fas {{ $t['icon'] }}" style="color:{{ $t['color'] }}; font-size:12px;"></i>
                            </div>
                            <div>
                                <div class="text-xs font-semibold text-[#1a1a1a]">{{ $t['label'] }}</div>
                                <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $t['sub'] }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>

            </div>
        </section>

        <div class="silver-divider"></div>

        {{-- ══════════════════════════════════════ --}}
        {{-- KANAL KOMUNIKASI (3 CARD)              --}}
        {{-- ══════════════════════════════════════ --}}
        <section class="py-4 pb-16">
            <div class="text-center mb-10">
                <div class="section-label justify-center">
                    <i class="fas fa-satellite-dish" style="font-size:9px; color:#333333;"></i>
                    Hubungi Kami
                </div>
                <h2 class="font-montserrat font-bold text-[#1a1a1a] text-2xl mt-2">Kanal Komunikasi &amp; Layanan Pelanggan</h2>
                <p class="text-sm mt-2 mx-auto" style="color:#6b7280; max-width:400px;">
                    Tim kami siap membantu Anda setiap hari kerja dengan respons cepat dan solusi terbaik.
                </p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">

                {{-- WhatsApp --}}
                <div class="kontak-card">
                    <div class="kontak-icon" style="background:rgba(34,197,94,0.08); border:1px solid rgba(34,197,94,0.2);">
                        <i class="fab fa-whatsapp" style="color:#22c55e;"></i>
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest mb-2" style="color:#6b7280;">WhatsApp Business</div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-lg mb-1">+62 882-9678-3577</div>
                    <div class="text-xs mb-4" style="color:#6b7280;">Senin–Sabtu, 08.00–20.00 WIB</div>
                    <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer"
                       class="btn-outline px-5 py-2 text-sm gap-2 w-full justify-center">
                        <i class="fab fa-whatsapp" style="font-size:12px; color:#22c55e;"></i>
                        Chat WhatsApp
                    </a>
                </div>

                {{-- Email --}}
                <div class="kontak-card">
                    <div class="kontak-icon" style="background:rgba(51,51,51,0.07); border:1px solid rgba(51,51,51,0.15);">
                        <i class="fas fa-envelope" style="color:#333333;"></i>
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest mb-2" style="color:#6b7280;">Email Support</div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-base mb-1">hello@patternshop.id</div>
                    <div class="text-xs mb-4" style="color:#6b7280;">Balasan dalam 1×24 jam kerja</div>
                    <a href="mailto:hello@patternshop.id"
                       class="btn-outline px-5 py-2 text-sm gap-2 w-full justify-center">
                        <i class="fas fa-paper-plane" style="font-size:11px;"></i>
                        Kirim Email
                    </a>
                </div>

                {{-- Alamat --}}
                <div class="kontak-card">
                    <div class="kontak-icon" style="background:rgba(59,130,246,0.08); border:1px solid rgba(59,130,246,0.2);">
                        <i class="fas fa-map-marker-alt" style="color:#3b82f6;"></i>
                    </div>
                    <div class="text-xs font-semibold uppercase tracking-widest mb-2" style="color:#6b7280;">Alamat Workshop</div>
                    <div class="font-montserrat font-bold text-[#1a1a1a] text-base mb-1">Jl. Merdeka No. 10</div>
                    <div class="text-xs mb-4" style="color:#6b7280;">Bandung, Jawa Barat 40111</div>
                    <a href="https://maps.google.com" target="_blank"
                       class="btn-outline px-5 py-2 text-sm gap-2 w-full justify-center">
                        <i class="fas fa-directions" style="font-size:11px;"></i>
                        Lihat Maps
                    </a>
                </div>

            </div>
        </section>

        {{-- ══════════════════════════════════════════════════ --}}
        {{-- JAM OPERASIONAL + FORM KONTAK                     --}}
        {{-- ══════════════════════════════════════════════════ --}}
        <section class="pb-16">
            <div class="flex flex-col lg:flex-row gap-6">

                {{-- JAM OPERASIONAL --}}
                <div class="w-full lg:w-[40%]">
                    <div class="section-card h-full">
                        <div class="section-card-header">
                            <div style="width:28px; height:28px; border-radius:7px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-clock" style="color:#333333; font-size:11px;"></i>
                            </div>
                            <span class="font-montserrat font-bold text-[#1a1a1a] text-sm">Jadwal Operasional Waktu &amp; Studio</span>
                        </div>
                        <div class="section-card-body">
                            @foreach([
                                ['hari'=>'Senin — Jumat', 'jam'=>'09.00 — 17.00', 'status'=>'buka', 'note'=>'Layanan penuh'],
                                ['hari'=>'Sabtu',         'jam'=>'09.00 — 15.00', 'status'=>'buka', 'note'=>'Layanan terbatas'],
                                ['hari'=>'Minggu',        'jam'=>'Tutup',         'status'=>'tutup','note'=>'Hari libur'],
                            ] as $j)
                            <div class="jam-row">
                                <div class="flex items-center gap-2">
                                    <span class="jam-dot"
                                          style="background:{{ $j['status'] === 'buka' ? '#16a34a' : '#d1d5db' }};"></span>
                                    <span class="font-medium text-[#1a1a1a] text-sm">{{ $j['hari'] }}</span>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm {{ $j['status'] === 'tutup' ? '' : 'font-semibold' }}"
                                         style="{{ $j['status'] === 'tutup' ? 'color:#9ca3af;' : 'color:#1a1a1a;' }}">
                                        {{ $j['jam'] }}
                                    </div>
                                    <div class="text-xs mt-0.5" style="color:#6b7280;">{{ $j['note'] }}</div>
                                </div>
                            </div>
                            @endforeach

                            <div class="mt-5 p-3 rounded-lg" style="background:#faf8f5; border:1px solid #e5e7eb;">
                                <div class="flex items-center gap-2 mb-2">
                                    <i class="fas fa-star" style="color:#d97706; font-size:10px;"></i>
                                    <span class="text-xs font-semibold text-[#1a1a1a]">Promo Luar Pulau</span>
                                </div>
                                <p class="text-xs leading-relaxed" style="color:#6b7280;">
                                    Pengiriman ke luar Jawa tersedia via JNE, J&amp;T, dan POS Indonesia. Estimasi 3–7 hari kerja. Gratis ongkir untuk pembelian di atas Rp 500.000.
                                </p>
                            </div>

                            <div class="mt-5">
                                <div class="text-xs font-semibold uppercase tracking-widest mb-3" style="color:#6b7280;">Ikuti Kami</div>
                                <div class="flex gap-2 flex-wrap">
                                    @foreach([
                                        ['icon'=>'fa-instagram', 'label'=>'Instagram', 'color'=>'#e1306c', 'href'=>'https://www.instagram.com/patterndigitalshop?stkn=MXJhdXJodHhpNGR2dg=='],
                                        ['icon'=>'fa-tiktok',    'label'=>'TikTok',    'color'=>'#1a1a1a', 'href'=>'#'],
                                        ['icon'=>'fa-facebook-f','label'=>'Facebook',  'color'=>'#1877f2', 'href'=>'https://www.facebook.com/share/1VBZ4F3PvX/'],
                                        ['icon'=>'fa-youtube',   'label'=>'YouTube',   'color'=>'#ff0000', 'href'=>'#'],
                                    ] as $sm)
                                    <a href="{{ $sm['href'] }}"
                                       {{ $sm['href'] !== '#' ? 'target="_blank" rel="noopener noreferrer"' : '' }}
                                       class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-all"
                                       style="background:#f5f5f5; border:1px solid #e5e7eb; color:#6b7280;"
                                       onmouseover="this.style.borderColor='{{ $sm['color'] }}40'; this.style.color='{{ $sm['color'] }}';"
                                       onmouseout="this.style.borderColor='#e5e7eb'; this.style.color='#6b7280';">
                                        <i class="fab {{ $sm['icon'] }}"></i>
                                        {{ $sm['label'] }}
                                    </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- FORM KONTAK --}}
                <div class="w-full lg:w-[60%]">
                    <div class="section-card h-full">
                        <div class="section-card-header">
                            <div style="width:28px; height:28px; border-radius:7px; background:#f5f5f5; border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center;">
                                <i class="fas fa-paper-plane" style="color:#333333; font-size:11px;"></i>
                            </div>
                            <div>
                                <span class="font-montserrat font-bold text-[#1a1a1a] text-sm">Kirim Pesan / Tanya Pattern Maker</span>
                                <div class="text-xs mt-0.5" style="color:#6b7280;">Kami akan membalas dalam 1×24 jam kerja</div>
                            </div>
                        </div>
                        <div class="section-card-body">
                            <form>
                                @csrf
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
                                    <div>
                                        <label class="form-label-kontak">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                                        <input type="text" class="form-input-kontak" placeholder="Nama kamu atau workshop...">
                                    </div>
                                    <div>
                                        <label class="form-label-kontak">Email <span style="color:#ef4444;">*</span></label>
                                        <input type="email" class="form-input-kontak" placeholder="email@kamu.com">
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <label class="form-label-kontak">No. WhatsApp</label>
                                    <input type="tel" class="form-input-kontak" placeholder="08xx-xxxx-xxxx">
                                </div>
                                <div class="mb-4">
                                    <label class="form-label-kontak">Subjek Pesan <span style="color:#ef4444;">*</span></label>
                                    <select class="form-input-kontak">
                                        <option value="">Pilih topik...</option>
                                        <option>Pertanyaan tentang produk</option>
                                        <option>Pemesanan custom pola</option>
                                        <option>Keluhan / komplain</option>
                                        <option>Kerjasama / partnership</option>
                                        <option>Lainnya</option>
                                    </select>
                                </div>
                                <div class="mb-5">
                                    <label class="form-label-kontak">Pesan <span style="color:#ef4444;">*</span></label>
                                    <textarea class="form-input-kontak"
                                              placeholder="Tuliskan pesan, pertanyaan, atau kebutuhan custom pola kamu di sini..."></textarea>
                                </div>
                                <div class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                    <button type="submit" class="btn-primary px-8 py-3 text-sm gap-2">
                                        <i class="fas fa-paper-plane" style="font-size:11px;"></i>
                                        Kirim Pesan Sekarang
                                    </button>
                                    <span class="text-xs" style="color:#6b7280;">
                                        <i class="fas fa-shield-alt mr-1" style="color:#6b7280;"></i>
                                        Data kamu aman &amp; tidak disebarkan
                                    </span>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <div class="silver-divider"></div>

        {{-- ══════════════════════════════════════ --}}
        {{-- MAPS                                   --}}
        {{-- ══════════════════════════════════════ --}}
        <section class="pb-16">
            <div class="text-center mb-8">
                <div class="section-label justify-center">
                    <i class="fas fa-map" style="font-size:9px; color:#333333;"></i>
                    Lokasi
                </div>
                <h2 class="font-montserrat font-bold text-[#1a1a1a] text-2xl mt-2">Lokasi Workshop &amp; Pengambilan Pola</h2>
                <p class="text-sm mt-2" style="color:#6b7280;">
                    Kunjungi workshop kami langsung atau gunakan layanan kirim ke seluruh Indonesia.
                </p>
            </div>

            <div class="flex flex-col lg:flex-row gap-5 items-start">

                <div class="maps-wrap flex-1" style="min-height:380px;">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3960.79836803042!2d107.6089!3d-6.9147!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zNsKwNTQnNTMuMCJTIDEwN8KwMzYnMzIuMCJF!5e0!3m2!1sid!2sid!4v1700000000000!5m2!1sid!2sid"
                        width="100%"
                        height="380"
                        style="border:0;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div class="maps-overlay-badge">
                        <div class="flex items-center gap-2 mb-1">
                            <i class="fas fa-map-marker-alt" style="color:#3b82f6; font-size:12px;"></i>
                            <span class="text-xs font-bold text-[#1a1a1a]">Pattern Digital Shop — Atelier</span>
                        </div>
                        <div class="text-xs" style="color:#6b7280;">Jl. Merdeka No. 10, Bandung</div>
                    </div>
                </div>

                <div style="width:280px; flex-shrink:0;">
                    <div class="section-card">
                        <div class="section-card-header">
                            <i class="fas fa-info-circle" style="color:#6b7280; font-size:12px;"></i>
                            <span class="text-xs font-semibold text-[#1a1a1a] uppercase tracking-wide">Info Lokasi</span>
                        </div>
                        <div class="section-card-body">
                            @foreach([
                                ['icon'=>'fa-map-marker-alt','color'=>'#3b82f6','label'=>'Alamat', 'val'=>'Jl. Merdeka No. 10, Bandung, Jawa Barat 40111'],
                                ['icon'=>'fa-parking',       'color'=>'#16a34a','label'=>'Parkir', 'val'=>'Tersedia parkir motor & mobil di halaman workshop'],
                                ['icon'=>'fa-bus',           'color'=>'#d97706','label'=>'Angkutan','val'=>'Angkot jurusan Merdeka — Dago berhenti 50m dari lokasi'],
                                ['icon'=>'fa-clock',         'color'=>'#333333','label'=>'Buka',   'val'=>'Senin–Jumat 09.00–17.00 · Sabtu 09.00–15.00'],
                            ] as $info)
                            <div style="display:flex; gap:10px; padding:10px 0; border-bottom:1px solid #f0f0f0; align-items:flex-start;">
                                <div style="width:28px; height:28px; border-radius:7px; background:{{ $info['color'] }}12; border:1px solid {{ $info['color'] }}22; display:flex; align-items:center; justify-content:center; flex-shrink:0; margin-top:1px;">
                                    <i class="fas {{ $info['icon'] }}" style="color:{{ $info['color'] }}; font-size:10px;"></i>
                                </div>
                                <div>
                                    <div class="text-xs font-semibold text-[#1a1a1a]">{{ $info['label'] }}</div>
                                    <div class="text-xs mt-0.5 leading-relaxed" style="color:#6b7280;">{{ $info['val'] }}</div>
                                </div>
                            </div>
                            @endforeach

                            <div class="mt-4 flex flex-col gap-2">
                                <a href="https://maps.google.com" target="_blank" class="btn-primary px-4 py-2 text-xs gap-2 w-full justify-center">
                                    <i class="fas fa-directions" style="font-size:10px;"></i>
                                    Petunjuk Arah
                                </a>
                                <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer" class="btn-outline px-4 py-2 text-xs gap-2 w-full justify-center">
                                    <i class="fab fa-whatsapp" style="font-size:11px; color:#22c55e;"></i>
                                    Konfirmasi Kunjungan
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

    </div>
</div>
@endsection
