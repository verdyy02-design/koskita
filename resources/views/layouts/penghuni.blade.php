<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>KosKita - Penghuni</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/penghuni.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">

    <style>
        /* Ikon sidebar: satu warna, garis tipis, ikut warna teks menu */
        .sidebar-icon {
            width: 20px;
            height: 20px;
            flex: none;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
            opacity: .75;
            transition: opacity .15s;
        }

        .sidebar .menu a,
        .sidebar .logout button {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sidebar .menu a { color: #a8b3c7; }
        .sidebar .menu a:hover { color: #e2e8f0; }
        .sidebar .menu a:hover .sidebar-icon,
        .sidebar .menu a.active .sidebar-icon { opacity: 1; }
        .sidebar .menu a.active { color: #fff; }

        .sidebar .logout button { color: #a8b3c7; }
        .sidebar .logout button:hover { color: #fca5a5; }
        .sidebar .logout button:hover .sidebar-icon { opacity: 1; }

        .sidebar .logo h1 {
            display: center;
            align-items: center;
            gap: 10px;
        }

        .sidebar .logo h1 .sidebar-icon {
            width: 26px;
            height: 26px;
            stroke-width: 1.7;
            color: #60a5fa;
            opacity: 1;
        }

        /* Tema gelap seperti halaman login: sidebar dan topbar */
        aside.sidebar {
            background:
                radial-gradient(420px 260px at 50% -6%, rgba(37, 99, 235, .38), transparent 70%),
                linear-gradient(180deg, #0b1230, #05070f 78%);
            border-right: 1px solid rgba(255, 255, 255, .05);
        }

        .main > .topbar {
            background:
                radial-gradient(640px 170px at 50% -70%, rgba(37, 99, 235, .55), transparent 72%),
                linear-gradient(180deg, #0b1230, #070b1c);
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            box-shadow: 0 8px 24px rgba(5, 7, 15, .18);
            color: #f1f5ff;
        }

        .main > .topbar .topbar-title,
        .main > .topbar .user-name {
            color: #f1f5ff;
        }

        .main > .topbar .user-role {
            color: #8b95b0;
        }

        .main > .topbar .avatar {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .3);
        }

        /* Lonceng notifikasi */
        .notif-bell {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            margin-right: 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .07);
            border: 1px solid rgba(255, 255, 255, .08);
            color: #c3cde6;
            text-decoration: none;
            transition: background-color .15s, color .15s, border-color .15s;
        }

        .notif-bell:hover {
            background: rgba(255, 255, 255, .13);
            border-color: rgba(143, 176, 255, .45);
            color: #fff;
        }

        .notif-bell:focus-visible {
            outline: 3px solid rgba(143, 176, 255, .6);
            outline-offset: 2px;
        }

        .notif-bell svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .notif-badge {
            position: absolute;
            top: -6px;
            right: -6px;
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 20px;
            height: 20px;
            padding: 0 5px;
            border-radius: 999px;
            background: #ef4444;
            box-shadow: 0 0 0 2px #0b1230;
            color: #fff;
            font-size: 11px;
            font-weight: 700;
            line-height: 1;
        }

        /* =========================================
        RESPONSIVE LAYOUT PENGHUNI
        ========================================= */

        /* Tombol hamburger: hanya muncul di mobile */
        .menu-toggle {
            display: none;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            flex-shrink: 0;
            border: 1px solid rgba(255,255,255,.12);
            border-radius: 10px;
            background: rgba(255,255,255,.07);
            color: #fff;
            cursor: pointer;
        }

        .menu-toggle svg {
            width: 22px;
            height: 22px;
            fill: none;
            stroke: currentColor;
            stroke-width: 2;
            stroke-linecap: round;
        }

        /* Overlay tersembunyi secara default */
        .sidebar-overlay {
            display: none;
        }

        /* Laptop kecil dan tablet landscape */
        @media (max-width: 1024px) and (min-width: 769px) {
            .sidebar {
                width: 230px;
            }

            .main {
                margin-left: 230px;
                width: calc(100% - 230px);
            }

            .main > .topbar {
                padding-left: 20px;
                padding-right: 20px;
            }
        }

        /* Smartphone dan tablet kecil */
        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
                position: relative;
                z-index: 1060;
            }

            .sidebar {
                position: fixed;
                top: 0;
                bottom: 0;
                left: 0;
                width: min(280px, 85vw);
                max-width: 280px;
                height: 100vh;
                height: 100dvh;
                overflow-y: auto;
                z-index: 1100;
                transform: translateX(-100%);
                transition: transform .3s ease;
                display: flex;
                flex-direction: column;
            }

            .sidebar.active {
                transform: translateX(0);
            }

            .sidebar .menu a {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 12px;
            }

            .sidebar .menu a span {
                display: inline;
            }

            .sidebar .logo h1 {
                font-size: 22px;
                white-space: nowrap;
            }

            .sidebar .logout {
                margin-top: auto;
            }

            .main {
                margin-left: 0;
                width: 100%;
            }

            .main > .topbar {
                padding: 12px 16px;
            }

            /* Overlay */
            .sidebar-overlay {
                display: block;
                position: fixed;
                inset: 0;
                z-index: 1050;
                background: rgba(0,0,0,.55);
                opacity: 0;
                visibility: hidden;
                pointer-events: none;
                transition: opacity .3s ease, visibility .3s ease;
            }

            .sidebar-overlay.active {
                opacity: 1;
                visibility: visible;
                pointer-events: auto;
            }
        }

        /* Smartphone */
        @media (max-width: 480px) {
            .main > .topbar {
                padding: 10px 12px;
            }

            .notif-bell {
                width: 36px;
                height: 36px;
                margin-right: 8px;
            }

            .notif-bell svg {
                width: 20px;
                height: 20px;
            }
        }

        /* Smartphone kecil */
        @media (max-width: 360px) {
            .main > .topbar {
                padding: 8px 10px;
            }

            .notif-bell {
                width: 34px;
                height: 34px;
                margin-right: 6px;
            }

            .notif-bell svg {
                width: 18px;
                height: 18px;
            }
        }
        /* FIX NAMA MENU SIDEBAR */
        .sidebar .menu a {
            display: flex !important;
            align-items: center !important;
            justify-content: flex-start !important;
            gap: 12px !important;
            color: #a8b3c7;
            font-size: 14px;
            white-space: nowrap;
        }

        .sidebar .menu a .sidebar-icon {
            flex-shrink: 0;
        }

        /* Pastikan teks menu terlihat */
        .sidebar .menu a {
            font-size: 14px !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        /* FIX LOGO DAN SUBTITLE SIDEBAR */
        .sidebar .logo {
            display: block;
        }

        .sidebar .logo h1 {
            display: center;
            align-items: center;
            gap: 10px;
        }

        .sidebar .logo .logo-text {
            display: inline !important;
            visibility: visible !important;
            opacity: 1 !important;
        }

        .sidebar .logo h1::before,
        .sidebar .logo h1::after,
        .sidebar .logo-text::before,
        .sidebar .logo-text::after {
            content: none !important;
            display: none !important;
        }

        .sidebar .logo p {
            display: block !important;
            position: static !important;
            margin: 5px 0 0 36px;
            color: #a8b3c7;
            font-size: 12px;
        }
    </style>
</head>

<body>

<div class="app">

    <!-- SIDEBAR -->
    <aside class="sidebar">

        <div class="logo">
            <h1>
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
                <span class="logo-text">Kos<span>Kita</span></span>
            </h1>
            <p>Portal Penghuni</p>
        </div>


        <nav class="menu">

            <a href="{{ route('penghuni.dashboard') }}"
               class="{{ request()->routeIs('penghuni.dashboard') ? 'active' : '' }}">
                <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                Dashboard
            </a>

            <a href="{{ route('penghuni.kamar') }}"
               class="{{ request()->routeIs('penghuni.kamar') ? 'active' : '' }}">
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
                Kamar Saya
            </a>

            <a href="{{ route('penghuni.pembayaran') }}"
               class="{{ request()->routeIs('penghuni.pembayaran') ? 'active' : '' }}">
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                Pembayaran
            </a>

            <a href="{{ route('penghuni.keluhan') }}"
               class="{{ request()->routeIs('penghuni.keluhan*') ? 'active' : '' }}">
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
                Keluhan
            </a>

            <a href="{{ route('penghuni.profil') }}"
               class="{{ request()->routeIs('penghuni.profil') ? 'active' : '' }}">
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Profil
            </a>

        </nav>


       <div class="logout">

            <form action="/logout" method="POST">

                @csrf

                <button type="submit">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><path d="m16 17 5-5-5-5"/><path d="M21 12H9"/></svg>
                    Logout
                </button>

            </form>

        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>


    <!-- MAIN -->
    <main class="main">

        <header class="topbar">

            <button type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="Buka menu"
                    aria-expanded="false">
                <svg viewBox="0 0 24 24">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
            </button>

            <div class="topbar-title">
                @yield('title', 'Dashboard')
            </div>

            <div class="user-info">

                {{-- LONCENG NOTIFIKASI --}}
                <a href="{{ route('penghuni.notifikasi') }}"
                   class="notif-bell"
                   title="Notifikasi"
                   aria-label="Notifikasi">

                    <svg viewBox="0 0 24 24" aria-hidden="true">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>

                    @php
                        $jumlahNotifikasi = auth()->user()->unreadNotifications()->count();
                    @endphp

                    @if ($jumlahNotifikasi > 0)
                        <span class="notif-badge">
                            {{ $jumlahNotifikasi > 99 ? '99+' : $jumlahNotifikasi }}
                        </span>
                    @endif

                </a>

                <div class="user-text">

                    <div class="user-name">
                        {{ auth()->user()->name }}
                    </div>

                    <div class="user-role">
                        Penghuni
                    </div>

                </div>

                <div class="avatar">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>

            </div>


        </header>


        <section class="content">

            @yield('content')

        </section>

    </main>

</div>

@vite('resources/js/penghuni.js')

</body>
</html>
