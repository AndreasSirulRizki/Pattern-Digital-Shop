<!DOCTYPE html>
<html lang="id" x-data="{ sidebarOpen: true, sidebarMobile: false }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Pattern Digital Shop</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

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
            background-color: #faf8f5;
            color: #1a1a1a;
            -webkit-font-smoothing: antialiased;
        }
        h1,h2,h3,h4,h5,h6 { font-family: 'Montserrat', sans-serif; }

        /* Scrollbar */
        ::-webkit-scrollbar { width: 4px; height: 4px; }
        ::-webkit-scrollbar-track { background: #f5f5f5; }
        ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 2px; }
        ::-webkit-scrollbar-thumb:hover { background: #9ca3af; }

        /* ── SIDEBAR ── */
        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #ffffff;
            border-right: 1px solid #e5e7eb;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 40;
            display: flex;
            flex-direction: column;
            transition: transform 0.25s ease, width 0.25s ease;
            overflow: hidden;
            box-shadow: 2px 0 12px rgba(0,0,0,0.04);
        }
        .sidebar.collapsed { width: 60px; }
        .sidebar.mobile-hidden { transform: translateX(-100%); }

        /* Sidebar logo */
        .sidebar-logo {
            padding: 18px 16px 14px;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .logo-icon {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1a1a1a, #333333);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(0,0,0,0.12);
        }
        .logo-text { overflow: hidden; white-space: nowrap; }
        .logo-text .title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700; font-size: 12px;
            color: #1a1a1a; line-height: 1.2;
        }
        .logo-text .sub {
            font-size: 9px; color: #9ca3af;
            letter-spacing: 0.08em; text-transform: uppercase;
            margin-top: 1px;
        }

        /* Sidebar nav */
        .sidebar-nav {
            padding: 10px 8px;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .nav-section-label {
            font-size: 9px;
            font-weight: 700;
            color: #d1d5db;
            letter-spacing: 0.12em;
            text-transform: uppercase;
            padding: 10px 8px 4px;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 10px;
            border-radius: 8px;
            color: #6b7280;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            cursor: pointer;
            white-space: nowrap;
            position: relative;
            border: 1px solid transparent;
            margin-bottom: 2px;
        }
        .nav-item:hover {
            color: #1a1a1a;
            background: #f5f5f5;
            border-color: #e5e7eb;
        }
        .nav-item.active {
            background: #1a1a1a;
            border-color: #1a1a1a;
            color: #ffffff;
            box-shadow: 0 2px 8px rgba(0,0,0,0.12), inset 0 1px 0 rgba(255,255,255,0.1);
        }
        .nav-item.active .nav-icon { color: #ffffff; }

        .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 13px;
            flex-shrink: 0;
        }

        .nav-badge {
            margin-left: auto;
            min-width: 18px; height: 18px;
            border-radius: 9px;
            display: inline-flex; align-items: center; justify-content: center;
            font-size: 9px; font-weight: 700;
            padding: 0 5px;
        }
        .nav-badge-yellow { background: rgba(234,179,8,0.12); color: #ca8a04; border: 1px solid rgba(234,179,8,0.25); }
        .nav-badge-red    { background: rgba(239,68,68,0.10);  color: #dc2626; border: 1px solid rgba(239,68,68,0.20); }
        .nav-badge-blue   { background: rgba(59,130,246,0.10); color: #2563eb; border: 1px solid rgba(59,130,246,0.20); }

        /* Sidebar footer */
        .sidebar-footer {
            padding: 10px 8px 16px;
            border-top: 1px solid #e5e7eb;
            flex-shrink: 0;
        }

        /* ── MAIN LAYOUT ── */
        .admin-main {
            margin-left: 240px;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin-left 0.25s ease;
        }
        .admin-main.expanded { margin-left: 60px; }

        /* ── TOPBAR ── */
        .admin-topbar {
            height: 56px;
            background: #ffffff;
            border-bottom: 1px solid #e5e7eb;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 24px;
            position: sticky;
            top: 0;
            z-index: 30;
            flex-shrink: 0;
            box-shadow: 0 1px 6px rgba(0,0,0,0.04);
        }

        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-right { display: flex; align-items: center; gap: 10px; }

        .topbar-title {
            font-family: 'Montserrat', sans-serif;
            font-weight: 700;
            font-size: 16px;
            color: #1a1a1a;
        }
        .topbar-sub {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 1px;
        }

        /* Toggle sidebar btn */
        .sidebar-toggle {
            width: 32px; height: 32px;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            background: transparent;
            border: 1px solid #e5e7eb;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s ease;
            flex-shrink: 0;
        }
        .sidebar-toggle:hover { border-color: #9ca3af; color: #1a1a1a; background: #f5f5f5; }

        /* Search */
        .topbar-search {
            background: #f5f5f5;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #1a1a1a;
            font-size: 12px;
            font-family: 'Inter', sans-serif;
            padding: 7px 12px 7px 32px;
            outline: none;
            width: 220px;
            transition: border-color 0.2s, background 0.2s;
        }
        .topbar-search:focus { border-color: #9ca3af; background: #ffffff; }
        .topbar-search::placeholder { color: #9ca3af; }

        /* Topbar avatar */
        .topbar-avatar {
            width: 32px; height: 32px;
            border-radius: 8px;
            background: linear-gradient(135deg, #1a1a1a, #333333);
            border: 1px solid #e5e7eb;
            display: flex; align-items: center; justify-content: center;
            font-size: 12px; font-weight: 700;
            color: #ffffff;
            cursor: pointer;
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
        .topbar-avatar:hover { border-color: #9ca3af; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }

        .topbar-notif {
            width: 32px; height: 32px;
            border-radius: 8px;
            border: 1px solid #e5e7eb;
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            color: #6b7280;
            cursor: pointer;
            transition: all 0.2s;
            position: relative;
        }
        .topbar-notif:hover { border-color: #9ca3af; color: #1a1a1a; background: #f5f5f5; }
        .notif-dot {
            position: absolute; top: 4px; right: 4px;
            width: 7px; height: 7px; border-radius: 50%;
            background: #ef4444;
            border: 1px solid #ffffff;
        }

        /* ── PAGE CONTENT ── */
        .admin-content {
            flex: 1;
            padding: 24px;
        }

        /* ── Buttons ── */
        .btn-admin-primary {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 8px 16px;
            background: linear-gradient(135deg, #1a1a1a 0%, #000000 50%, #111111 100%);
            border: 1px solid #1a1a1a;
            border-radius: 8px;
            color: #ffffff;
            font-family: 'Inter', sans-serif;
            font-weight: 500; font-size: 12px;
            cursor: pointer; transition: all 0.2s ease;
            text-decoration: none;
            position: relative; overflow: hidden;
        }
        .btn-admin-primary::before {
            content: ''; position: absolute;
            top: 0; left: 0; right: 0; height: 50%;
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            pointer-events: none;
        }
        .btn-admin-primary:hover {
            background: #000000;
            border-color: #000000;
            box-shadow: 0 4px 12px rgba(0,0,0,0.15);
            transform: translateY(-1px);
        }

        .btn-admin-outline {
            display: inline-flex; align-items: center; justify-content: center; gap: 6px;
            padding: 7px 14px;
            background: transparent;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            color: #6b7280;
            font-family: 'Inter', sans-serif;
            font-weight: 500; font-size: 12px;
            cursor: pointer; transition: all 0.2s ease;
            text-decoration: none;
        }
        .btn-admin-outline:hover { border-color: #9ca3af; color: #1a1a1a; background: #f5f5f5; }

        /* Mobile overlay */
        .sidebar-overlay {
            position: fixed; inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 39;
            display: none;
        }

        /* Status indicator */
        .status-dot {
            width: 6px; height: 6px; border-radius: 50%;
            display: inline-block; margin-right: 4px;
        }

        @media (max-width: 1024px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.mobile-open { transform: translateX(0); }
            .admin-main { margin-left: 0 !important; }
            .sidebar-overlay.show { display: block; }
        }
    </style>

    @yield('styles')
</head>

<body>
{{-- ════════════════════════════════════ --}}
{{-- SIDEBAR                              --}}
{{-- ════════════════════════════════════ --}}
<aside class="sidebar"
       :class="{
           'collapsed': !sidebarOpen && window.innerWidth >= 1024,
           'mobile-open': sidebarMobile
       }">

    {{-- Logo --}}
    <div class="sidebar-logo">
        <div class="logo-icon">
            <i class="fas fa-scissors text-white" style="font-size:13px;"></i>
        </div>
        <div class="logo-text" x-show="sidebarOpen || window.innerWidth < 1024">
            <div class="title">Pattern Digital Shop</div>
            <div class="sub">Admin Panel</div>
        </div>
    </div>

    {{-- Navigation --}}
    <nav class="sidebar-nav">

        <div class="nav-section-label" x-show="sidebarOpen || window.innerWidth < 1024">Menu Utama</div>

        <a href="{{ route('admin.dashboard') }}"
           class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
            <i class="fas fa-tachometer-alt nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Dashboard</span>
            @if(request()->routeIs('admin.dashboard'))
            <span class="ml-auto w-1.5 h-1.5 rounded-full" style="background:#ffffff; flex-shrink:0;"></span>
            @endif
        </a>

        <a href="{{ route('admin.produk') }}"
           class="nav-item {{ request()->routeIs('admin.produk*') ? 'active' : '' }}">
            <i class="fas fa-box nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Kelola Produk</span>
        </a>

        <a href="{{ route('admin.kategori') }}"
           class="nav-item {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
            <i class="fas fa-tags nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Kelola Kategori</span>
        </a>

        <a href="{{ route('admin.pesanan') }}"
           class="nav-item {{ request()->routeIs('admin.pesanan*') ? 'active' : '' }}">
            <i class="fas fa-receipt nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Kelola Pesanan</span>
            <span class="nav-badge nav-badge-yellow" x-show="sidebarOpen || window.innerWidth < 1024">5</span>
        </a>

        <a href="{{ route('admin.customer') }}"
           class="nav-item {{ request()->routeIs('admin.customer*') ? 'active' : '' }}">
            <i class="fas fa-users nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Kelola Customer</span>
        </a>

        <div class="nav-section-label" x-show="sidebarOpen || window.innerWidth < 1024" style="margin-top:8px;">Analitik</div>

        <a href="{{ route('admin.laporan') }}"
           class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
            <i class="fas fa-chart-line nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Laporan &amp; Analitik</span>
        </a>

        <a href="{{ route('admin.pembayaran') }}"
           class="nav-item {{ request()->routeIs('admin.pembayaran*') ? 'active' : '' }}">
            <i class="fas fa-receipt nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Verifikasi Pembayaran</span>
        </a>

        <div class="nav-section-label" x-show="sidebarOpen || window.innerWidth < 1024" style="margin-top:8px;">Sistem</div>

        <a href="#"
           class="nav-item {{ request()->routeIs('admin.pengaturan*') ? 'active' : '' }}">
            <i class="fas fa-cog nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Pengaturan Atelier</span>
        </a>

        <a href="{{ route('home') }}" class="nav-item" target="_blank">
            <i class="fas fa-external-link-alt nav-icon"></i>
            <span x-show="sidebarOpen || window.innerWidth < 1024">Lihat Toko</span>
        </a>

    </nav>

    {{-- Footer --}}
    <div class="sidebar-footer">
        {{-- Admin info --}}
        <div class="flex items-center gap-2.5 px-2 py-2 mb-2 rounded-lg"
             style="background:#f5f5f5; border:1px solid #e5e7eb;"
             x-show="sidebarOpen || window.innerWidth < 1024">
            <div style="width:28px; height:28px; border-radius:6px; background:linear-gradient(135deg,#1a1a1a,#333333); border:1px solid #e5e7eb; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                <span style="font-size:10px; font-weight:700; color:#ffffff;">AD</span>
            </div>
            <div class="overflow-hidden">
                <div class="text-xs font-semibold text-[#1a1a1a] truncate">{{ Auth::user()->name ?? 'Admin' }}</div>
                <div class="text-xs truncate" style="color:#9ca3af;">Superadmin</div>
            </div>
        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="nav-item w-full" style="color:#6b7280;">
                <i class="fas fa-sign-out-alt nav-icon" style="color:#ef4444;"></i>
                <span x-show="sidebarOpen || window.innerWidth < 1024" style="color:#ef4444;">Keluar Sistem</span>
            </button>
        </form>
    </div>
</aside>

{{-- Mobile overlay --}}
<div class="sidebar-overlay"
     :class="{ 'show': sidebarMobile }"
     @click="sidebarMobile = false"></div>

{{-- ════════════════════════════════════ --}}
{{-- MAIN                                 --}}
{{-- ════════════════════════════════════ --}}
<div class="admin-main"
     :class="{ 'expanded': !sidebarOpen && window.innerWidth >= 1024 }">

    {{-- ── TOPBAR ── --}}
    <header class="admin-topbar">
        <div class="topbar-left">
            {{-- Desktop collapse toggle --}}
            <button class="sidebar-toggle hidden lg:flex"
                    @click="sidebarOpen = !sidebarOpen">
                <i class="fas fa-bars" style="font-size:12px;"></i>
            </button>
            {{-- Mobile open toggle --}}
            <button class="sidebar-toggle lg:hidden"
                    @click="sidebarMobile = !sidebarMobile">
                <i class="fas fa-bars" style="font-size:12px;"></i>
            </button>

            <div>
                <div class="topbar-title">@yield('header-title', 'Dashboard')</div>
                <div class="topbar-sub">
                    {{ now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
                    &nbsp;·&nbsp;
                    <span style="color:#22c55e;">
                        <i class="fas fa-circle" style="font-size:6px; margin-right:3px;"></i>Sistem Operasional
                    </span>
                </div>
            </div>
        </div>

        <div class="topbar-right">
            {{-- Search --}}
            <div class="relative hidden md:block">
                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2" style="color:#9ca3af; font-size:11px;"></i>
                <input type="text" placeholder="Cari pesanan, SKU, produk..." class="topbar-search">
            </div>

            {{-- Notif --}}
            <button class="topbar-notif">
                <i class="fas fa-bell" style="font-size:12px;"></i>
                <span class="notif-dot"></span>
            </button>

            {{-- Avatar dropdown --}}
            <div class="relative" x-data="{ open: false }">
                <div class="topbar-avatar" @click="open = !open">
                    {{ strtoupper(substr(Auth::user()->name ?? 'A', 0, 2)) }}
                </div>
                <div x-show="open" @click.outside="open = false"
                     x-transition:enter="transition ease-out duration-150"
                     x-transition:enter-start="opacity-0 translate-y-1"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     style="position:absolute; right:0; top:calc(100% + 8px); width:180px;
                            background:#ffffff; border:1px solid #e5e7eb; border-radius:10px;
                            z-index:100; overflow:hidden; box-shadow:0 8px 24px rgba(0,0,0,0.08);">
                    <div style="padding:10px 14px; border-bottom:1px solid #e5e7eb;">
                        <div class="text-xs font-semibold text-[#1a1a1a]">{{ Auth::user()->name ?? 'Admin' }}</div>
                        <div class="text-xs mt-0.5" style="color:#9ca3af;">{{ Auth::user()->email ?? '' }}</div>
                    </div>
                    <div style="padding:5px;">
                        <a href="{{ route('home') }}" target="_blank"
                           class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs transition-colors hover:bg-[#f5f5f5]"
                           style="color:#6b7280;">
                            <i class="fas fa-store" style="font-size:10px;"></i> Lihat Toko
                        </a>
                        <div style="border-top:1px solid #e5e7eb; margin:4px 0;"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                    class="flex items-center gap-2 px-3 py-2 rounded-lg text-xs w-full text-left hover:bg-red-50 transition-colors"
                                    style="color:#ef4444; background:none; border:none; cursor:pointer;">
                                <i class="fas fa-sign-out-alt" style="font-size:10px;"></i> Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </header>

    {{-- ── CONTENT ── --}}
    <main class="admin-content">
        @yield('content')
    </main>

    {{-- ── FOOTER ── --}}
    <footer style="padding:12px 24px; border-top:1px solid #e5e7eb; background:#f5f5f5; flex-shrink:0;">
        <div class="flex items-center justify-between text-xs" style="color:#9ca3af;">
            <span>Pattern Digital Shop Admin OS v2.4 &bull; Server CAD Terintegrasi Bandung</span>
            <span>Hak Akses Administrasi Terkindung &copy; {{ date('Y') }} Pattern Digital Shop</span>
        </div>
    </footer>

</div>

@yield('scripts')
</body>
</html>
