<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'KosKita' }}</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
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

        .sidebar .logo h2 {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .sidebar .logo h2 .sidebar-icon {
            width: 28px;
            height: 28px;
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

        .main > .topbar h3,
        .main > .topbar .topbar-title,
        .main > .topbar .user-name,
        .main > .topbar .user-info strong {
            color: #f1f5ff;
        }

        .main > .topbar .user-role,
        .main > .topbar .user-info small {
            color: #8b95b0;
        }

        .main > .topbar .avatar {
            background: #2563eb;
            color: #fff;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .3);
        }

        /* =========================================
        RESPONSIVE SIDEBAR ADMIN
        ========================================= */

        /* Hamburger */
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

        /* Overlay */
        .sidebar-overlay {
            display: none;
        }

        @media (max-width: 768px) {
            .menu-toggle {
                display: flex;
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
                justify-content: flex-start;
                gap: 12px;
                white-space: nowrap;
            }

            .sidebar .menu a .sidebar-icon {
                flex-shrink: 0;
            }

            .sidebar .logout {
                margin-top: auto;
            }

            .main {
                margin-left: 0;
                width: 100%;
                min-width: 0;
            }

            .main > .topbar {
                padding: 12px 16px;
                display: flex;
                align-items: center;
                gap: 12px;
            }

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

        @media (max-width: 480px) {
            .main > .topbar {
                padding: 10px 12px;
                gap: 9px;
            }

            .main > .topbar h3 {
                font-size: 16px;
            }

            .main > .topbar .user-info {
                margin-left: auto;
                min-width: 0;
            }

            .main > .topbar .user-info strong {
                font-size: 12px;
            }

            .main > .topbar .user-info small {
                font-size: 10px;
            }

            .main > .topbar .avatar {
                flex-shrink: 0;
            }
        }

    </style>
</head>

<body>

    <!-- SIDEBAR -->

    <aside class="sidebar">

        <div class="logo">

            <h2>
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
                <span>Kos<span>Kita</span></span>
            </h2>

            <small>Management System</small>

        </div>


        <ul class="menu">

            <li>
                <a href="/admin/dashboard"
                    class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="9" rx="1"/><rect x="14" y="3" width="7" height="5" rx="1"/><rect x="14" y="12" width="7" height="9" rx="1"/><rect x="3" y="16" width="7" height="5" rx="1"/></svg>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('kamar.index') }}"
                    class="{{ request()->routeIs('kamar.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
                    Data Kamar
                </a>
            </li>

            <li>
                <a href="{{ route('penghuni.index') }}"
                    class="{{ request()->routeIs('penghuni.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                    Penghuni
                </a>
            </li>

            <li>
                <a href="{{ route('teknisi.index') }}"
                    class="{{ request()->routeIs('teknisi.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                    Teknisi
                </a>
            </li>

            <li>
                <a href="{{ route('pembayaran.index') }}"
                    class="{{ request()->routeIs('pembayaran.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                    Pembayaran
                </a>
            </li>

            <li>
                <a href="{{ route('admin.qris.index') }}"
                    class="{{ request()->routeIs('admin.qris.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5" rx="1"/><rect x="16" y="3" width="5" height="5" rx="1"/><rect x="3" y="16" width="5" height="5" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/></svg>
                    Kelola QRIS
                </a>
            </li>

            <li>
                <a href="{{ route('admin.keluhan.index') }}"
                    class="{{ request()->routeIs('admin.keluhan.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
                    Keluhan
                </a>
            </li>

            <li>
                <a href="{{ route('admin.activity-log.index') }}"
                    class="{{ request()->routeIs('admin.activity-log.*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                    Activity Log
                </a>
            </li>

        </ul>


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


        <!-- TOPBAR -->

        <header class="topbar">
            <button type="button"
                    class="menu-toggle"
                    id="menuToggle"
                    aria-label="Buka menu"
                    aria-expanded="false">

                <svg viewBox="0 0 24 24" aria-hidden="true">
                    <path d="M4 6h16M4 12h16M4 18h16"/>
                </svg>

            </button>

            <h3>
                {{ $title ?? 'Dashboard' }}
            </h3>


            <div class="user-info">

                <div>

                    <strong>
                        {{ auth()->user()->name }}
                    </strong>

                    <br>

                    <small>
                        {{ ucfirst(auth()->user()->role) }}
                    </small>

                </div>


                <div class="avatar">

                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}

                </div>

            </div>

        </header>


        <!-- CONTENT -->

        <section class="content">

            @yield('content')

        </section>


    </main>

    @vite('resources/js/app.js')
</body>

</html>
