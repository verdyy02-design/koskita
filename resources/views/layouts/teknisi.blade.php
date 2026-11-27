<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KosKita - Teknisi</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/teknisi.css') }}">
<style>
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

        .sidebar {
            position: fixed;
            inset: 0 auto 0 0;
            width: 250px;
            background: #0f172a;
            color: white;
            display: flex;
            flex-direction: column;
            z-index: 1100;
            transition: transform .3s ease;
        }

        .sidebar .logo h2 {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sidebar .logo h2 .sidebar-icon {
            width: 28px;
            height: 28px;
            stroke-width: 1.7;
            color: #60a5fa;
            opacity: 1;
        }

        .logo {
            padding: 25px 22px;
            border-bottom: 1px solid #293449;
        }

        .logo h2 {
            margin: 0;
            font-size: 23px;
        }

        .logo h2 span {
            color: #60a5fa;
        }

        .logo small {
            display: block;
            color: #94a3b8;
            margin-top: 6px;
        }

        .menu {
            list-style: none;
            padding: 20px 12px;
            margin: 0;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 13px 15px;
            margin-bottom: 6px;
            border-radius: 9px;
            color: #cbd5e1;
            text-decoration: none;
            transition: .2s;
        }

        .menu a:hover,
        .menu a.active {
            background: #2563eb;
            color: white;
        }

        .menu-icon {
            width: 20px;
            text-align: center;
        }

        .logout {
            margin-top: auto;
            padding: 15px;
            border-top: 1px solid #293449;
        }

        .logout button {
            width: 100%;
            border: 0;
            background: #7f1d1d;
            color: white;
            padding: 12px;
            border-radius: 8px;
            cursor: pointer;
        }

        .main {
            margin-left: 250px;
            min-height: 100vh;
        }

        .topbar {
            background:
                radial-gradient(640px 170px at 50% -70%, rgba(37, 99, 235, .55), transparent 72%),
                linear-gradient(180deg, #0b1230, #070b1c);
            border-bottom: 1px solid rgba(255, 255, 255, .07);
            box-shadow: 0 8px 24px rgba(5, 7, 15, .18);
            min-height: 75px;
            padding: 15px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
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

        .topbar h3 {
            margin: 0;
            font-size: 20px;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #475569;
            font-size: 14px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: #dbeafe;
            color: #1d4ed8;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

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

        .sidebar-overlay {
            display: none;
        }

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

        .sidebar .logo p {
            display: block !important;
            position: static !important;
            margin: 5px 0 0 95px;
            color: #a8b3c7;
            font-size: 12px;
        }
</style>
</head>

<body>
<div class="app">

    <aside class="sidebar" id="sidebar">

        <div class="logo">
            <h2>
                <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
                Kos<span>Kita</span>
            </h2>
            <p>Portal Teknisi</p>
        </div>

        <ul class="menu">
            <li>
                <a href="{{ route('teknisi.dashboard') }}"
                   class="{{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}">
                    <span class="menu-icon">▦</span>
                    Dashboard
                </a>
            </li>

            <li>
                <a href="{{ route('teknisi.tugas.index') }}"
                   class="{{ request()->routeIs('teknisi.tugas.*') ? 'active' : '' }}">
                    <span class="menu-icon">▤</span>
                    Tugas Saya
                </a>
            </li>
            <li>
                <a href="{{ route('teknisi.profil') }}"
                    class="{{ request()->routeIs('teknisi.profil*') ? 'active' : '' }}">
                    <svg class="sidebar-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                    Profil Saya
                </a>
            </li>
        </ul>

        <div class="logout">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit">↪ Logout</button>
            </form>
        </div>

    </aside>

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

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

            <h3>@yield('title', 'Dashboard')</h3>

            <div class="user-info">
                <span class="user-name">
                    {{ auth()->user()->name }}
                    <small style="display:block; color:#94a3b8;">
                        Teknisi
                    </small>
                </span>

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
