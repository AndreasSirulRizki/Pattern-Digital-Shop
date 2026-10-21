<!DOCTYPE html>
<html lang="id" x-data>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar — Pattern Digital Shop</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        'montserrat': ['Montserrat', 'sans-serif'],
                        'inter': ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        * { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: 'Inter', sans-serif;
            background: #faf8f5;
            color: #1a1a1a;
            min-height: 100vh;
            -webkit-font-smoothing: antialiased;
        }

        .auth-wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* ── KIRI: Branding ── */
        .auth-left {
            width: 50%;
            position: relative;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 48px 40px;
            background: #f5f5f5;
            overflow: hidden;
            border-right: 1px solid #e5e7eb;
        }

        .auth-left::before {
            content: '';
            position: absolute; inset: 0;
            background:
                repeating-linear-gradient(0deg, transparent, transparent 59px, rgba(0,0,0,0.025) 59px, rgba(0,0,0,0.025) 60px),
                repeating-linear-gradient(90deg, transparent, transparent 59px, rgba(0,0,0,0.025) 59px, rgba(0,0,0,0.025) 60px);
            pointer-events: none;
        }

        .auth-left-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 380px;
        }

        .brand-logo-circle {
            width: 72px; height: 72px;
            border-radius: 20px;
            background: #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 4px 20px rgba(26,26,26,0.15);
        }

        .brand-name {
            font-family: 'Montserrat', sans-serif;
            font-weight: 800;
            font-size: 1.75rem;
            color: #1a1a1a;
            letter-spacing: -0.02em;
            line-height: 1.2;
            margin-bottom: 8px;
        }
        .brand-name span { color: #333333; }

        .brand-tagline {
            font-size: 0.8rem;
            color: #6b7280;
            font-weight: 500;
            letter-spacing: 0.18em;
            text-transform: uppercase;
            margin-bottom: 36px;
        }

        .brand-sep {
            width: 40px; height: 1px;
            background: linear-gradient(90deg, transparent, #333333, transparent);
            margin: 0 auto 28px;
        }

        /* Steps */
        .step-item {
            display: flex; align-items: flex-start; gap: 12px;
            padding: 10px 0;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }
        .step-item:last-child { border-bottom: none; }

        .step-num {
            width: 26px; height: 26px;
            border-radius: 8px;
            background: #1a1a1a;
            border: 1px solid #1a1a1a;
            display: flex; align-items: center; justify-content: center;
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 11px;
            color: #ffffff;
            flex-shrink: 0;
            margin-top: 1px;
        }

        /* Benefit tags */
        .benefit-row {
            display: flex; flex-wrap: wrap; gap: 6px;
            margin-top: 24px;
        }
        .benefit-tag {
            display: inline-flex; align-items: center; gap: 5px;
            padding: 5px 10px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 20px;
            font-size: 11px; color: #6b7280;
        }

        /* ── KANAN: Form ── */
        .auth-right {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 40px;
            background: #ffffff;
            position: relative;
            overflow-y: auto;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 32px 28px;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }

        .auth-card-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.35rem;
            color: #1a1a1a;
            margin-bottom: 4px;
        }

        .auth-card-sub {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 22px;
        }

        .input-group { margin-bottom: 14px; }

        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #1a1a1a;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 5px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 12px;
            pointer-events: none; z-index: 1;
            transition: color 0.2s;
        }

        .input-icon-right {
            position: absolute;
            right: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af; font-size: 12px;
            cursor: pointer; z-index: 1;
            background: none; border: none; padding: 4px;
            transition: color 0.2s;
        }
        .input-icon-right:hover { color: #6b7280; }

        .auth-input {
            width: 100%;
            background: #f5f5f5;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            font-size: 13px;
            padding: 10px 40px 10px 38px;
            outline: none;
            transition: all 0.2s;
        }
        .auth-input:focus {
            border-color: #1a1a1a;
            background: #ffffff;
            box-shadow: 0 0 0 3px rgba(26,26,26,0.06);
        }
        .auth-input::placeholder { color: #9ca3af; }
        .auth-input.no-right { padding-right: 14px; }

        .input-error {
            font-size: 11px; color: #ef4444;
            margin-top: 4px;
            display: flex; align-items: center; gap: 4px;
        }

        .auth-checkbox {
            width: 15px; height: 15px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            accent-color: #1a1a1a;
            cursor: pointer; flex-shrink: 0;
        }

        .btn-auth-primary {
            width: 100%;
            padding: 11px 16px;
            background: #1a1a1a;
            border: none;
            border-radius: 9px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none;
        }
        .btn-auth-primary:hover {
            background: #333333;
            box-shadow: 0 4px 16px rgba(26,26,26,0.2);
            transform: translateY(-1px);
        }
        .btn-auth-primary:active { transform: translateY(0); }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 24px 16px; }
            .auth-card { padding: 24px 18px; }
            .mobile-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 20px; }
        }
        @media (min-width: 769px) { .mobile-brand { display: none; } }
    </style>
</head>
<body>

<div class="auth-wrapper">

    {{-- ══════════════ KIRI: BRANDING ══════════════ --}}
    <div class="auth-left">
        <div class="auth-left-content">

            <div class="brand-logo-circle">
                <i class="fas fa-scissors" style="color:#ffffff; font-size:26px;"></i>
            </div>

            <div class="brand-name">Pattern<br><span>Digital Shop</span></div>
            <div class="brand-tagline">Your Garment Partner</div>
            <div class="brand-sep"></div>

            {{-- Langkah daftar --}}
            <div style="width:100%;">
                <div style="font-size:11px; font-weight:600; color:#6b7280; letter-spacing:0.08em; text-transform:uppercase; margin-bottom:14px;">
                    Cara Bergabung
                </div>

                @foreach([
                    ['num'=>'01', 'title'=>'Buat Akun',       'sub'=>'Isi nama, email & password'],
                    ['num'=>'02', 'title'=>'Jelajahi Katalog', 'sub'=>'Pilih pola sesuai kebutuhan'],
                    ['num'=>'03', 'title'=>'Bayar & Unduh',    'sub'=>'Pola langsung bisa digunakan'],
                ] as $s)
                <div class="step-item">
                    <div class="step-num">{{ $s['num'] }}</div>
                    <div>
                        <div style="font-size:12px; font-weight:600; color:#1a1a1a;">{{ $s['title'] }}</div>
                        <div style="font-size:11px; color:#6b7280; margin-top:2px;">{{ $s['sub'] }}</div>
                    </div>
                </div>
                @endforeach
            </div>

            {{-- Benefit tags --}}
            <div class="benefit-row">
                @foreach(['Gratis Daftar', 'Akses Katalog Penuh', 'Riwayat Pesanan', 'Support 24/7'] as $b)
                <span class="benefit-tag">
                    <i class="fas fa-check" style="color:#16a34a; font-size:9px;"></i>
                    {{ $b }}
                </span>
                @endforeach
            </div>

            <div style="margin-top:24px; padding:14px 16px; background:#ffffff; border:1px solid #e5e7eb; border-left:2px solid #333333; border-radius:0 8px 8px 0; text-align:left;">
                <p style="font-size:12px; color:#6b7280; font-style:italic; line-height:1.6;">
                    "Lebih dari 3.500 penjahit profesional telah mempercayakan kebutuhan pola mereka kepada kami."
                </p>
                <div style="font-size:11px; color:#333333; margin-top:6px; font-weight:600;">— Tim Pattern Digital Shop</div>
            </div>

        </div>
    </div>

    {{-- ══════════════ KANAN: FORM ══════════════ --}}
    <div class="auth-right">
        <div style="width:100%; max-width:420px; position:relative; z-index:1; padding:16px 0;">

            {{-- Logo mini mobile --}}
            <div class="mobile-brand">
                <div style="width:36px;height:36px;border-radius:10px;background:#1a1a1a;display:flex;align-items:center;justify-content:center;">
                    <i class="fas fa-scissors" style="color:#ffffff; font-size:14px;"></i>
                </div>
                <div>
                    <div style="font-family:'Montserrat',sans-serif;font-weight:700;font-size:14px;color:#1a1a1a;">Pattern Digital Shop</div>
                    <div style="font-size:10px;color:#6b7280;letter-spacing:0.1em;text-transform:uppercase;">Your Garment Partner</div>
                </div>
            </div>

            <div class="auth-card">

                <div class="auth-card-title">Buat Akun Baru</div>
                <div class="auth-card-sub">Gratis selamanya · Tanpa biaya tersembunyi</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    {{-- Nama Lengkap --}}
                    <div class="input-group">
                        <label class="input-label" for="name">Nama Lengkap <span style="color:#ef4444;">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-user input-icon"></i>
                            <input id="name" name="name" type="text"
                                   class="auth-input no-right"
                                   value="{{ old('name') }}"
                                   placeholder="Nama lengkap kamu"
                                   required autofocus autocomplete="name">
                        </div>
                        @error('name')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Email --}}
                    <div class="input-group">
                        <label class="input-label" for="email">Email <span style="color:#ef4444;">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" name="email" type="email"
                                   class="auth-input no-right"
                                   value="{{ old('email') }}"
                                   placeholder="email@kamu.com"
                                   required autocomplete="username">
                        </div>
                        @error('email')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- No. HP --}}
                    <div class="input-group">
                        <label class="input-label" for="phone">
                            No. HP
                            <span style="color:#9ca3af; font-weight:400; text-transform:none; letter-spacing:0;">(opsional)</span>
                        </label>
                        <div class="input-wrap">
                            <i class="fas fa-phone input-icon"></i>
                            <input id="phone" name="phone" type="tel"
                                   class="auth-input no-right"
                                   value="{{ old('phone') }}"
                                   placeholder="08xx-xxxx-xxxx"
                                   autocomplete="tel">
                        </div>
                        @error('phone')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="input-group" x-data="{ show: false }">
                        <label class="input-label" for="password">Password <span style="color:#ef4444;">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" name="password"
                                   :type="show ? 'text' : 'password'"
                                   class="auth-input"
                                   placeholder="Min. 8 karakter"
                                   required autocomplete="new-password">
                            <button type="button" class="input-icon-right" @click="show = !show" tabindex="-1">
                                <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Konfirmasi Password --}}
                    <div class="input-group" x-data="{ show: false }">
                        <label class="input-label" for="password_confirmation">Konfirmasi Password <span style="color:#ef4444;">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password_confirmation" name="password_confirmation"
                                   :type="show ? 'text' : 'password'"
                                   class="auth-input"
                                   placeholder="Ulangi password"
                                   required autocomplete="new-password">
                            <button type="button" class="input-icon-right" @click="show = !show" tabindex="-1">
                                <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Checkbox S&K --}}
                    <div style="margin-bottom:20px; margin-top:4px;">
                        <label style="display:flex; align-items:flex-start; gap:9px; cursor:pointer;">
                            <input type="checkbox" name="agree_terms" class="auth-checkbox" style="margin-top:1px;" required>
                            <span style="font-size:12px; color:#6b7280; line-height:1.5;">
                                Saya setuju dengan
                                <a href="#" style="color:#1a1a1a; text-decoration:none; font-weight:600;"
                                   onmouseover="this.style.color='#333333'"
                                   onmouseout="this.style.color='#1a1a1a'">Syarat &amp; Ketentuan</a>
                                serta
                                <a href="#" style="color:#1a1a1a; text-decoration:none; font-weight:600;"
                                   onmouseover="this.style.color='#333333'"
                                   onmouseout="this.style.color='#1a1a1a'">Kebijakan Privasi</a>
                                Pattern Digital Shop
                            </span>
                        </label>
                    </div>

                    <button type="submit" class="btn-auth-primary">
                        <i class="fas fa-user-plus" style="font-size:12px;"></i>
                        Buat Akun Sekarang
                    </button>

                </form>

                <p style="text-align:center; margin-top:18px; font-size:12px; color:#6b7280;">
                    Sudah punya akun?
                    <a href="{{ route('login') }}"
                       style="color:#1a1a1a; text-decoration:none; font-weight:600; transition:color 0.2s;"
                       onmouseover="this.style.color='#333333'"
                       onmouseout="this.style.color='#1a1a1a'">
                        Masuk di sini
                    </a>
                </p>

            </div>
        </div>
    </div>

</div>
</body>
</html>
