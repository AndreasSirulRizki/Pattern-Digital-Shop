<!DOCTYPE html>
<html lang="id" x-data="{ mobileMenuOpen: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Pattern Digital Shop')</title>

    <!-- Google Fonts: Montserrat + Inter -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Alpine.js -->
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
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(180deg, #faf8f5 0%, #ffffff 100%);
            background-color: #faf8f5;
            color: #1a1a1a;
            -webkit-font-smoothing: antialiased;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Montserrat', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 5px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 3px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* Navbar */
        .navbar-glossy {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid #e5e7eb;
            box-shadow: 0 1px 8px rgba(0,0,0,0.06);
        }

        /* Buttons */
        .btn-primary {
            display: inline-flex; align-items: center; justify-content: center;
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 50%, #111111 100%);
            border: 1px solid #1a1a1a;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease;
            position: relative; overflow: hidden;
            text-decoration: none;
        }
        .btn-primary::before {
            content: '';
            position: absolute; top: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            pointer-events: none;
        }
        .btn-primary:hover {
            background: #000000;
            border-color: #000000;
            box-shadow: 0 4px 16px rgba(0,0,0,0.15), inset 0 1px 0 rgba(255,255,255,0.08);
            transform: translateY(-1px);
        }

        .btn-outline {
            display: inline-flex; align-items: center; justify-content: center;
            background: transparent;
            border: 1px solid #333333;
            color: #333333;
            font-family: 'Inter', sans-serif;
            font-weight: 500;
            border-radius: 8px;
            cursor: pointer;
            transition: all 0.25s ease;
            text-decoration: none;
        }
        .btn-outline:hover {
            border-color: #1a1a1a;
            color: #1a1a1a;
            background: #f5f5f5;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        /* Nav Link */
        .nav-link {
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            font-weight: 500;
            transition: color 0.2s ease;
            position: relative;
            padding-bottom: 2px;
        }
        .nav-link::after {
            content: '';
            position: absolute; bottom: -2px; left: 0; right: 0;
            height: 1px; background: #1a1a1a;
            transform: scaleX(0); transition: transform 0.2s ease;
        }
        .nav-link:hover { color: #1a1a1a; }
        .nav-link:hover::after { transform: scaleX(1); }
        .nav-link.active { color: #1a1a1a; }
        .nav-link.active::after { transform: scaleX(1); }

        /* Search */
        .search-input {
            background: #f5f5f5; border: 1px solid #e5e7eb;
            color: #1a1a1a; transition: all 0.2s ease;
        }
        .search-input:focus { outline: none; border-color: #9ca3af; background: #ffffff; }
        .search-input::placeholder { color: #9ca3af; }

        /* Footer links */
        .footer-link {
            color: #6b7280; font-size: 0.875rem;
            text-decoration: none; transition: color 0.2s ease;
            display: inline-block;
        }
        .footer-link:hover { color: #1a1a1a; }

        /* Divider */
        .divider { background: linear-gradient(90deg, transparent, #e5e7eb, transparent); height: 1px; }

        /* Card */
        .card-dark {
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            transition: all 0.3s ease;
        }
        .card-dark:hover {
            border-color: #d1d5db;
            box-shadow: 0 8px 24px rgba(0,0,0,0.08), 0 0 0 1px rgba(0,0,0,0.04);
            transform: translateY(-3px);
        }

        /* Social icon */
        .social-icon {
            width: 32px; height: 32px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: #f5f5f5; border: 1px solid #e5e7eb;
            color: #6b7280; font-size: 0.75rem;
            text-decoration: none; transition: all 0.2s ease;
        }
        .social-icon:hover { border-color: #9ca3af; color: #1a1a1a; background: #ffffff; }
    </style>

    @yield('styles')
</head>
<body>

{{-- ═══════════════ NAVBAR ═══════════════ --}}
<nav class="navbar-glossy fixed top-0 left-0 right-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center h-16 gap-6">

            {{-- Logo --}}
            <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0 no-underline">
                <div class="w-8 h-8 rounded-lg flex items-center justify-center shrink-0"
                     style="background: linear-gradient(135deg, #1a1a1a, #333333); box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
                    <i class="fas fa-scissors text-white" style="font-size: 13px;"></i>
                </div>
                <div class="leading-tight">
                    <div class="font-bold text-[#1a1a1a] text-sm font-montserrat tracking-wide leading-none">Pattern Digital</div>
                    <div class="font-medium tracking-widest" style="color: #6b7280; font-size: 8px; letter-spacing: 0.15em;">POLA JAHIT PREMIUM</div>
                </div>
            </a>

            {{-- Nav Links (desktop) --}}
            <div class="hidden md:flex items-center gap-5 shrink-0">
                <a href="{{ route('home') }}" class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Beranda</a>
                <a href="{{ route('katalog') }}" class="nav-link {{ request()->routeIs('katalog') ? 'active' : '' }}">Katalog</a>
                <a href="{{ route('cara-pesan') }}" class="nav-link {{ request()->routeIs('cara-pesan') ? 'active' : '' }}">Cara Pesan</a>
                <a href="{{ route('kontak') }}" class="nav-link {{ request()->routeIs('kontak') ? 'active' : '' }}">Kontak</a>
            </div>

            {{-- Search (desktop, spacer flex) --}}
            <div class="hidden lg:flex flex-1 max-w-sm">
                <div class="relative w-full">
                    <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color: #9ca3af; font-size: 11px;"></i>
                    <input type="text" placeholder="Cari pola jahit..."
                           class="search-input w-full pl-9 pr-4 py-2 rounded-lg text-sm">
                </div>
            </div>

            <div class="flex-1 hidden lg:block"></div>

            {{-- Right Actions --}}
            <div class="flex items-center gap-2 shrink-0">
                <a href="{{ route('keranjang') }}" class="relative p-2 rounded-lg hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('keranjang') ? 'bg-[#f5f5f5]' : '' }}">
                    <i class="fas fa-shopping-cart" style="color: {{ request()->routeIs('keranjang') ? '#1a1a1a' : '#6b7280' }}; font-size: 14px;"></i>
                    <span class="absolute -top-0.5 -right-0.5 w-4 h-4 rounded-full flex items-center justify-center font-bold text-white"
                          style="background: #1a1a1a; font-size: 9px;">0</span>
                </a>

                @auth
                    {{-- Pesanan Saya link --}}
                    <a href="{{ route('riwayat') }}"
                       class="hidden md:inline-flex items-center gap-1.5 nav-link {{ request()->routeIs('riwayat*') ? 'active' : '' }}"
                       style="font-size:13px;">
                        <i class="fas fa-receipt" style="font-size:11px;"></i> Pesanan
                    </a>

                    {{-- Akun dropdown --}}
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open"
                                class="btn-primary px-4 py-2 text-sm gap-1.5"
                                :class="open ? 'opacity-90' : ''">
                            <i class="fas fa-user-circle" style="font-size:11px;"></i>
                            <span class="hidden sm:inline">{{ Auth::user()->name }}</span>
                            <i class="fas fa-chevron-down" style="font-size:9px;" :class="open ? 'rotate-180' : ''" class="transition-transform"></i>
                        </button>
                        {{-- Dropdown menu --}}
                        <div x-show="open"
                             @click.outside="open = false"
                             x-transition:enter="transition ease-out duration-150"
                             x-transition:enter-start="opacity-0 translate-y-1"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-100"
                             x-transition:leave-start="opacity-100"
                             x-transition:leave-end="opacity-0"
                             style="position:absolute; right:0; top:calc(100% + 8px); width:200px; background:#ffffff; border:1px solid #e5e7eb; border-radius:10px; z-index:100; overflow:hidden; box-shadow:0 8px 32px rgba(0,0,0,0.08);">
                            {{-- User info --}}
                            <div style="padding:12px 16px; border-bottom:1px solid #e5e7eb;">
                                <div class="text-xs font-semibold text-[#1a1a1a] truncate">{{ Auth::user()->name }}</div>
                                <div class="text-xs truncate mt-0.5" style="color:#9ca3af;">{{ Auth::user()->email }}</div>
                            </div>
                            {{-- Menu items --}}
                            <div style="padding:6px;">
                                <a href="{{ route('riwayat') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors hover:bg-[#f5f5f5] {{ request()->routeIs('riwayat*') ? 'text-[#1a1a1a]' : '' }}"
                                   style="{{ request()->routeIs('riwayat*') ? 'color:#1a1a1a;' : 'color:#6b7280;' }}">
                                    <i class="fas fa-receipt w-4 text-center" style="font-size:12px;"></i>
                                    Pesanan Saya
                                </a>
                                <a href="{{ route('keranjang') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors hover:bg-[#f5f5f5]"
                                   style="color:#6b7280;">
                                    <i class="fas fa-shopping-cart w-4 text-center" style="font-size:12px;"></i>
                                    Keranjang
                                </a>
                                <a href="{{ route('profile.edit') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors hover:bg-[#f5f5f5]"
                                   style="color:#6b7280;">
                                    <i class="fas fa-user-cog w-4 text-center" style="font-size:12px;"></i>
                                    Profil Saya
                                </a>
                                <a href="{{ route('dashboard') }}"
                                   class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors hover:bg-[#f5f5f5]"
                                   style="color:#6b7280;">
                                    <i class="fas fa-tachometer-alt w-4 text-center" style="font-size:12px;"></i>
                                    Dashboard
                                </a>
                                <div style="border-top:1px solid #e5e7eb; margin:6px 0;"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                            class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-sm transition-colors hover:bg-red-50 w-full text-left"
                                            style="color:#6b7280; background:none; border:none; cursor:pointer;">
                                        <i class="fas fa-sign-out-alt w-4 text-center" style="font-size:12px; color:#ef4444;"></i>
                                        <span style="color:#ef4444;">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <a href="{{ route('login') }}" class="btn-primary px-4 py-2 text-sm gap-1.5">
                        <i class="fas fa-sign-in-alt" style="font-size: 11px;"></i> Masuk
                    </a>
                @endauth

                {{-- Mobile toggle --}}
                <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-lg hover:bg-[#f5f5f5] transition-colors">
                    <i class="fas" :class="mobileMenuOpen ? 'fa-times' : 'fa-bars'" style="color: #6b7280; font-size: 14px;"></i>
                </button>
            </div>
        </div>

        {{-- Mobile search --}}
        <div class="lg:hidden pb-3">
            <div class="relative">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color: #9ca3af; font-size: 11px;"></i>
                <input type="text" placeholder="Cari pola jahit..."
                       class="search-input w-full pl-9 pr-4 py-2 rounded-lg text-sm">
            </div>
        </div>
    </div>

    {{-- Mobile Menu --}}
    <div x-show="mobileMenuOpen"
         x-transition:enter="transition ease-out duration-150"
         x-transition:enter-start="opacity-0 -translate-y-1"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="md:hidden"
         style="background: #ffffff; border-top: 1px solid #e5e7eb;">
        <div class="px-4 py-3 space-y-0.5">
            <a href="{{ route('home') }}" class="block px-3 py-2.5 rounded-lg text-sm text-[#1a1a1a] hover:bg-[#f5f5f5] transition-colors">Beranda</a>
            <a href="{{ route('katalog') }}" class="block px-3 py-2.5 rounded-lg text-sm hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('katalog') ? 'text-[#1a1a1a]' : '' }}" style="{{ request()->routeIs('katalog') ? '' : 'color:#6b7280;' }}">Katalog</a>
            <a href="{{ route('cara-pesan') }}" class="block px-3 py-2.5 rounded-lg text-sm hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('cara-pesan') ? 'text-[#1a1a1a]' : '' }}" style="{{ request()->routeIs('cara-pesan') ? '' : 'color:#6b7280;' }}">Cara Pesan</a>
            <a href="{{ route('kontak') }}" class="block px-3 py-2.5 rounded-lg text-sm hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('kontak') ? 'text-[#1a1a1a]' : '' }}" style="{{ request()->routeIs('kontak') ? '' : 'color:#6b7280;' }}">Kontak</a>
            @auth
            <div style="border-top:1px solid #e5e7eb; margin:6px 0;"></div>
            <a href="{{ route('riwayat') }}" class="block px-3 py-2.5 rounded-lg text-sm hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('riwayat*') ? 'text-[#1a1a1a]' : '' }}" style="{{ request()->routeIs('riwayat*') ? '' : 'color:#6b7280;' }}">
                <i class="fas fa-receipt mr-2" style="font-size:11px;"></i>Pesanan Saya
            </a>
            <a href="{{ route('keranjang') }}" class="block px-3 py-2.5 rounded-lg text-sm hover:bg-[#f5f5f5] transition-colors {{ request()->routeIs('keranjang') ? 'text-[#1a1a1a]' : '' }}" style="{{ request()->routeIs('keranjang') ? '' : 'color:#6b7280;' }}">
                <i class="fas fa-shopping-cart mr-2" style="font-size:11px;"></i>Keranjang
            </a>
            @endauth
        </div>
    </div>
</nav>

{{-- Spacer navbar --}}
<div class="h-16"></div>

{{-- ═══════════════ MAIN CONTENT ═══════════════ --}}
<main>
    @yield('content')
</main>

{{-- ═══════════════ FOOTER ═══════════════ --}}
<footer style="background: #f5f5f5; border-top: 1px solid #e5e7eb;">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-14 pb-8">

        {{-- 4 Kolom --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 mb-12">

            {{-- 1: Brand --}}
            <div>
                <div class="flex items-center gap-2.5 mb-4">
                    <div class="w-7 h-7 rounded-lg flex items-center justify-center shrink-0"
                         style="background: linear-gradient(135deg, #1a1a1a, #333333);">
                        <i class="fas fa-scissors text-white" style="font-size: 11px;"></i>
                    </div>
                    <span class="font-bold text-[#1a1a1a] text-sm font-montserrat">Pattern Digital Shop</span>
                </div>
                <p class="text-sm leading-relaxed mb-5" style="color: #6b7280;">
                    Toko pola jahit terpercaya sejak 2020. Menyediakan pola fisik dan digital berkualitas untuk penjahit profesional maupun pemula.
                </p>
                <div class="flex gap-2">
                    <a href="https://www.instagram.com/patterndigitalshop?stkn=MXJhdXJodHhpNGR2dg==" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me/6288296783577" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-whatsapp"></i></a>
                    <a href="#" class="social-icon"><i class="fab fa-tiktok"></i></a>
                    <a href="https://www.facebook.com/share/1VBZ4F3PvX/" target="_blank" rel="noopener noreferrer" class="social-icon"><i class="fab fa-facebook-f"></i></a>
                </div>
            </div>

            {{-- 2: Katalog --}}
            <div>
                <h4 class="font-semibold text-[#1a1a1a] text-sm font-montserrat mb-4 tracking-wide">Katalog Pola</h4>
                <ul class="space-y-2.5">
                    @foreach(['Pola Kemeja Pria','Pola Kemeja Wanita','Pola Gaun & Dress','Pola Celana & Rok','Pola Digital (PDF)','Promo Hari Ini'] as $item)
                    <li>
                        <a href="#" class="footer-link flex items-center gap-2">
                            <i class="fas fa-chevron-right" style="color: #d1d5db; font-size: 10px;"></i>
                            {{ $item }}
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>

            {{-- 3: Kontak --}}
            <div id="kontak">
                <h4 class="font-semibold text-[#1a1a1a] text-sm font-montserrat mb-4 tracking-wide">Kontak Support</h4>
                <ul class="space-y-3">
                    <li class="flex items-start gap-3">
                        <i class="fas fa-phone-alt mt-0.5 shrink-0" style="color: #333333; font-size: 11px;"></i>
                        <div>
                            <div class="footer-link">+62 821-XXXX-XXXX</div>
                            <div class="text-xs mt-0.5" style="color: #9ca3af;">Senin–Sabtu, 08.00–17.00 WIB</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fab fa-whatsapp mt-0.5 shrink-0" style="color: #22c55e; font-size: 11px;"></i>
                        <div>
                            <div class="footer-link">WhatsApp Business</div>
                            <div class="text-xs mt-0.5" style="color: #9ca3af;">Senin–Sabtu, 08.00–20.00 WIB</div>
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-envelope mt-0.5 shrink-0" style="color: #333333; font-size: 11px;"></i>
                        <div><div class="footer-link">hello@patternshop.id</div></div>
                    </li>
                    <li class="flex items-start gap-3">
                        <i class="fas fa-map-marker-alt mt-0.5 shrink-0" style="color: #333333; font-size: 11px;"></i>
                        <div><div class="footer-link">Jl. Merdeka No. 10, Bandung</div></div>
                    </li>
                </ul>
            </div>

            {{-- 4: Newsletter --}}
            <div>
                <h4 class="font-semibold text-[#1a1a1a] text-sm font-montserrat mb-4 tracking-wide">Newsletter & Promo</h4>
                <p class="text-sm mb-4 leading-relaxed" style="color: #6b7280;">
                    Daftarkan email kamu dan dapatkan notifikasi pola terbaru serta promo eksklusif langsung di inbox.
                </p>
                <form action="{{ route('newsletter.subscribe') }}" method="POST">
                    @csrf
                    <div class="flex gap-2">
                        <input type="email" name="email" placeholder="Alamat email kamu..."
                               class="search-input flex-1 px-3 py-2 rounded-lg text-sm min-w-0" required>
                        <button type="submit" class="btn-primary px-4 py-2 text-sm whitespace-nowrap">Daftar</button>
                    </div>
                    @if(session('newsletter_success'))
                        <div class="text-green-600 text-xs mt-2">
                            <i class="fas fa-check-circle mr-1"></i>{{ session('newsletter_success') }}
                        </div>
                    @endif
                </form>
                <div class="mt-5">
                    <p class="text-xs mb-2 font-medium uppercase tracking-widest" style="color: #9ca3af;">Tersedia di</p>
                    <div class="flex gap-2">
                        <span class="px-3 py-1.5 rounded text-xs font-medium" style="background:#ffffff; border:1px solid #e5e7eb; color:#6b7280;">
                            <i class="fas fa-store mr-1"></i>Tokopedia
                        </span>
                        <span class="px-3 py-1.5 rounded text-xs font-medium" style="background:#ffffff; border:1px solid #e5e7eb; color:#6b7280;">
                            <i class="fas fa-store mr-1"></i>Shopee
                        </span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Divider --}}
        <div class="divider mb-6"></div>

        {{-- Bottom --}}
        <div class="flex flex-col md:flex-row items-center justify-between gap-3">
            <p class="text-xs" style="color: #9ca3af;">
                © {{ date('Y') }} Pattern Digital Shop. Hak cipta dilindungi undang-undang.
            </p>
            <div class="flex gap-5">
                <a href="{{ route('cara-pesan') }}" class="text-xs transition-colors hover:text-[#1a1a1a]" style="color:#9ca3af;">Cara Pesan</a>
                <a href="#" class="text-xs transition-colors hover:text-[#1a1a1a]" style="color:#9ca3af;">Kebijakan Pengiriman</a>
                <a href="#" class="text-xs transition-colors hover:text-[#1a1a1a]" style="color:#9ca3af;">Syarat & Ketentuan</a>
            </div>
        </div>
    </div>
</footer>

@yield('scripts')
</body>
</html>
