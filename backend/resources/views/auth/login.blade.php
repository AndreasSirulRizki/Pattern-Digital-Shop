<!DOCTYPE html>
<html lang="id" x-data>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk — Pattern Digital Shop</title>

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
            margin-bottom: 40px;
        }

        .brand-sep {
            width: 40px; height: 1px;
            background: linear-gradient(90deg, transparent, #333333, transparent);
            margin: 0 auto 32px;
        }

        .feature-badge {
            display: flex; align-items: center; gap: 10px;
            padding: 10px 16px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            margin-bottom: 10px;
            text-align: left;
            transition: border-color 0.2s;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .feature-badge:hover { border-color: #d1d5db; }

        .feature-badge-icon {
            width: 30px; height: 30px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }

        .brand-quote {
            margin-top: 28px;
            padding: 16px 20px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-left: 2px solid #333333;
            border-radius: 0 8px 8px 0;
            text-align: left;
        }

        /* ── KANAN: Form ── */
        .auth-right {
            width: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 48px 40px;
            background: #ffffff;
            position: relative;
        }

        .auth-card {
            width: 100%;
            max-width: 420px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 16px;
            padding: 36px 32px;
            position: relative;
            z-index: 1;
            box-shadow: 0 4px 24px rgba(0,0,0,0.06);
        }

        .auth-card-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: #1a1a1a;
            margin-bottom: 6px;
        }

        .auth-card-sub {
            font-size: 0.8rem;
            color: #6b7280;
            margin-bottom: 28px;
        }

        .input-group {
            position: relative;
            margin-bottom: 16px;
        }

        .input-label {
            display: block;
            font-size: 11px;
            font-weight: 600;
            color: #1a1a1a;
            letter-spacing: 0.06em;
            text-transform: uppercase;
            margin-bottom: 6px;
        }

        .input-wrap { position: relative; }

        .input-icon {
            position: absolute;
            left: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af;
            font-size: 12px;
            pointer-events: none;
            z-index: 1;
            transition: color 0.2s;
        }

        .input-icon-right {
            position: absolute;
            right: 13px; top: 50%; transform: translateY(-50%);
            color: #9ca3af;
            font-size: 12px;
            cursor: pointer;
            z-index: 1;
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

        .input-error {
            font-size: 11px;
            color: #ef4444;
            margin-top: 5px;
            display: flex; align-items: center; gap: 4px;
        }

        .auth-checkbox {
            width: 15px; height: 15px;
            border-radius: 4px;
            border: 1px solid #e5e7eb;
            background: #ffffff;
            accent-color: #1a1a1a;
            cursor: pointer;
            flex-shrink: 0;
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

        .btn-auth-outline {
            width: 100%;
            padding: 10px 16px;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 9px;
            color: #1a1a1a;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 8px;
            text-decoration: none;
        }
        .btn-auth-outline:hover {
            border-color: #d1d5db;
            background: #f5f5f5;
        }

        .auth-divider {
            display: flex; align-items: center; gap: 12px;
            margin: 20px 0;
        }
        .auth-divider-line { flex: 1; height: 1px; background: #e5e7eb; }
        .auth-divider-text { font-size: 11px; color: #9ca3af; font-weight: 500; letter-spacing: 0.06em; }

        .session-status {
            background: rgba(22,163,74,0.08);
            border: 1px solid rgba(22,163,74,0.2);
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 12px;
            color: #16a34a;
            margin-bottom: 20px;
            display: flex; align-items: center; gap: 8px;
        }

        @media (max-width: 768px) {
            .auth-left { display: none; }
            .auth-right { width: 100%; padding: 24px 16px; }
            .auth-card { padding: 28px 20px; }
            .mobile-brand { display: flex; align-items: center; gap: 10px; margin-bottom: 24px; }
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

            @foreach([
                ['icon'=>'fa-file-pdf',       'color'=>'#333333', 'bg'=>'rgba(51,51,51,0.07)',  'title'=>'Pola Digital PDF',   'sub'=>'Langsung cetak, siap pakai'],
                ['icon'=>'fa-ruler-combined', 'color'=>'#3b82f6', 'bg'=>'rgba(59,130,246,0.08)','title'=>'Pola Fisik Presisi', 'sub'=>'Kertas kraft premium A0'],
                ['icon'=>'fa-headset',        'color'=>'#16a34a', 'bg'=>'rgba(22,163,74,0.08)', 'title'=>'Support 08–20 WIB',  'sub'=>'Chat WA & email aktif'],
            ] as $f)
            <div class="feature-badge">
                <div class="feature-badge-icon" style="background:{{ $f['bg'] }}; border:1px solid {{ $f['color'] }}22;">
                    <i class="fas {{ $f['icon'] }}" style="color:{{ $f['color'] }}; font-size:12px;"></i>
                </div>
                <div>
                    <div style="font-size:12px; font-weight:600; color:#1a1a1a;">{{ $f['title'] }}</div>
                    <div style="font-size:11px; color:#6b7280; margin-top:1px;">{{ $f['sub'] }}</div>
                </div>
            </div>
            @endforeach

            <div class="brand-quote">
                <p style="font-size:12px; color:#6b7280; font-style:italic; line-height:1.6;">
                    "Pola yang tepat adalah fondasi dari busana yang sempurna."
                </p>
                <div style="font-size:11px; color:#333333; margin-top:6px; font-weight:600;">— Budi Setiawan, Founder</div>
            </div>

        </div>
    </div>

    {{-- ══════════════ KANAN: FORM ══════════════ --}}
    <div class="auth-right">
        <div style="width:100%; max-width:420px; position:relative; z-index:1;">

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

                @if (session('status'))
                <div class="session-status">
                    <i class="fas fa-check-circle"></i>
                    {{ session('status') }}
                </div>
                @endif

                <div class="auth-card-title">Masuk ke Akun</div>
                <div class="auth-card-sub">Selamat datang kembali 👋</div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Email --}}
                    <div class="input-group">
                        <label class="input-label" for="email">Email <span style="color:#ef4444;">*</span></label>
                        <div class="input-wrap">
                            <i class="fas fa-envelope input-icon"></i>
                            <input id="email" name="email" type="email"
                                   class="auth-input"
                                   value="{{ old('email') }}"
                                   placeholder="email@kamu.com"
                                   required autofocus autocomplete="username">
                        </div>
                        @error('email')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div class="input-group" x-data="{ show: false }">
                        <div class="flex items-center justify-between mb-1.5">
                            <label class="input-label" style="margin-bottom:0;" for="password">Password <span style="color:#ef4444;">*</span></label>
                            @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}"
                               style="font-size:11px; color:#6b7280; text-decoration:none; transition:color 0.2s;"
                               onmouseover="this.style.color='#1a1a1a'"
                               onmouseout="this.style.color='#6b7280'">
                                Lupa password?
                            </a>
                            @endif
                        </div>
                        <div class="input-wrap">
                            <i class="fas fa-lock input-icon"></i>
                            <input id="password" name="password"
                                   :type="show ? 'text' : 'password'"
                                   class="auth-input"
                                   placeholder="••••••••"
                                   required autocomplete="current-password">
                            <button type="button" class="input-icon-right" @click="show = !show" tabindex="-1">
                                <i class="fas" :class="show ? 'fa-eye-slash' : 'fa-eye'"></i>
                            </button>
                        </div>
                        @error('password')
                        <div class="input-error"><i class="fas fa-exclamation-circle"></i> {{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Remember me --}}
                    <div class="flex items-center gap-2 mb-6">
                        <input id="remember_me" name="remember" type="checkbox" class="auth-checkbox">
                        <label for="remember_me" style="font-size:12px; color:#6b7280; cursor:pointer; user-select:none;">
                            Ingat saya selama 30 hari
                        </label>
                    </div>

                    <button type="submit" class="btn-auth-primary">
                        <i class="fas fa-sign-in-alt" style="font-size:12px;"></i>
                        Masuk Sekarang
                    </button>

                </form>

                <div class="auth-divider">
                    <div class="auth-divider-line"></div>
                    <span class="auth-divider-text">ATAU</span>
                    <div class="auth-divider-line"></div>
                </div>

                <button type="button" class="btn-auth-outline" onclick="alert('Google login belum dikonfigurasi.')">
                    <svg width="14" height="14" viewBox="0 0 24 24" style="flex-shrink:0;">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Masuk dengan Google
                </button>

                <p style="text-align:center; margin-top:20px; font-size:12px; color:#6b7280;">
                    Belum punya akun?
                    <a href="{{ route('register') }}"
                       style="color:#1a1a1a; text-decoration:none; font-weight:600; transition:color 0.2s;"
                       onmouseover="this.style.color='#333333'"
                       onmouseout="this.style.color='#1a1a1a'">
                        Daftar sekarang
                    </a>
                </p>

            </div>
        </div>
    </div>

</div>
</body>
</html>
