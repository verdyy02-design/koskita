@extends('layouts.penghuni')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .pd-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;

        --tone-blue-bg: #dbe7fe;   --tone-blue-fg: #1d4ed8;
        --tone-indigo-bg: #e3e5fb; --tone-indigo-fg: #4338ca;
        --tone-amber-bg: #fdf0d2;  --tone-amber-fg: #8a5a05;
        --ok-bg: #dff3e8;   --ok-fg: #17663d;
        --warn-bg: #fdf0d2; --warn-fg: #8a5a05;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 1000px) / 2)) 56px;
    }

    .pd-page * { box-sizing: border-box; }

    .pd-icon {
        width: 22px;
        height: 22px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    /* Sambutan */
    .welcome-box {
        margin-bottom: 22px;
        padding: 30px 32px;
        border-radius: 16px;
        background: linear-gradient(120deg, #1e3a8a, #2563eb);
        color: #fff;
    }

    .welcome-box h1 {
        margin: 0 0 8px;
        font-size: 1.8rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.2;
    }

    .welcome-box p {
        margin: 0;
        max-width: 60ch;
        color: rgba(255, 255, 255, .82);
        font-size: .98rem;
        line-height: 1.6;
    }

    /* Statistik */
    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 22px;
    }

    .stat-card { padding: 22px; }

    .stat-icon {
        display: grid;
        place-items: center;
        width: 44px;
        height: 44px;
        margin-bottom: 16px;
        border-radius: 12px;
    }

    .tone-blue   { background: var(--tone-blue-bg);   color: var(--tone-blue-fg); }
    .tone-indigo { background: var(--tone-indigo-bg); color: var(--tone-indigo-fg); }
    .tone-amber  { background: var(--tone-amber-bg);  color: var(--tone-amber-fg); }

    .stat-title { color: var(--ink-soft); font-size: .88rem; font-weight: 500; }

    .stat-value {
        margin-top: 4px;
        font-size: 1.4rem;
        font-weight: 700;
        letter-spacing: -0.01em;
    }

    /* Informasi kamar */
    .room-card { padding: 28px; }

    .room-card h2 {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 20px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .room-card h2 .pd-icon { width: 20px; height: 20px; color: var(--blue); }

    .room-info {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .info-box {
        padding: 16px 18px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .info-label { margin-bottom: 5px; color: var(--ink-soft); font-size: .82rem; font-weight: 500; }
    .info-value { font-size: 1rem; font-weight: 600; word-break: break-word; }

    /* Badge status */
    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 999px;
        background: var(--tone-blue-bg);
        color: var(--tone-blue-fg);
        font-size: .84rem;
        font-weight: 600;
    }

    .status::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .status-terisi,
    .status-kosong { background: var(--ok-bg); color: var(--ok-fg); }
    .status-perbaikan { background: var(--warn-bg); color: var(--warn-fg); }

    /* Kosong */
    .empty-room { padding: 40px 20px; text-align: center; color: var(--ink-soft); }
    .empty-room .pd-icon { width: 44px; height: 44px; margin-bottom: 12px; color: var(--blue); opacity: .7; }
    .empty-room h3 { margin: 0 0 6px; color: var(--ink); font-size: 1.05rem; }
    .empty-room p { margin: 0; }

    @media (max-width: 900px) {
        .dashboard-grid { grid-template-columns: 1fr; }
        .room-info { grid-template-columns: 1fr; }
    }

    @media (max-width: 600px) {
        .pd-page { padding: 20px 14px 40px; }
        .welcome-box { padding: 24px 22px; }
        .welcome-box h1 { font-size: 1.45rem; }
        .room-card { padding: 22px; }
    }
</style>

<div class="pd-page">

    <!-- SAMBUTAN -->
    <div class="welcome-box">

        <h1>Selamat datang, {{ auth()->user()->name }}!</h1>

        <p>
            Selamat datang di Dashboard Penghuni KosKita.
            Kelola informasi kos kamu dengan mudah.
        </p>

    </div>


    <!-- STATISTIK -->
    <div class="dashboard-grid">

        <div class="panel stat-card">
            <div class="stat-icon tone-blue">
                <svg class="pd-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
            </div>

            <div class="stat-title">Kamar saya</div>

            <div class="stat-value">
                {{ $penghuni?->kamar?->nomor_kamar ?? 'Belum ada' }}
            </div>
        </div>


        <div class="panel stat-card">
            <div class="stat-icon tone-indigo">
                <svg class="pd-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
            </div>

            <div class="stat-title">Pembayaran</div>

            <div class="stat-value">Belum ada data</div>
        </div>


        <div class="panel stat-card">
            <div class="stat-icon tone-amber">
                <svg class="pd-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
            </div>

            <div class="stat-title">Keluhan</div>

            <div class="stat-value">0 keluhan</div>
        </div>

    </div>


    <!-- INFORMASI KAMAR -->
    <div class="panel room-card">

        <h2>
            <svg class="pd-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
            Informasi kamar saya
        </h2>

        @if ($penghuni && $penghuni->kamar)

            <div class="room-info">

                <div class="info-box">
                    <div class="info-label">Nomor kamar</div>
                    <div class="info-value">{{ $penghuni->kamar->nomor_kamar }}</div>
                </div>


                <div class="info-box">
                    <div class="info-label">Harga kamar</div>
                    <div class="info-value">
                        Rp {{ number_format($penghuni->kamar->harga, 0, ',', '.') }}
                    </div>
                </div>


                <div class="info-box">
                    <div class="info-label">Fasilitas</div>
                    <div class="info-value">
                        {{ $penghuni->kamar->fasilitas ?? 'Tidak ada data fasilitas' }}
                    </div>
                </div>


                <div class="info-box">
                    <div class="info-label">Status kamar</div>
                    <div class="info-value">
                        <span class="status status-{{ \Illuminate\Support\Str::slug($penghuni->kamar->status) }}">
                            {{ ucfirst($penghuni->kamar->status) }}
                        </span>
                    </div>
                </div>


                <div class="info-box">
                    <div class="info-label">Tanggal masuk</div>
                    <div class="info-value">
                        {{ \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d F Y') }}
                    </div>
                </div>


                <div class="info-box">
                    <div class="info-label">No. HP</div>
                    <div class="info-value">{{ $penghuni->no_hp }}</div>
                </div>

            </div>

        @else

            <div class="empty-room">

                <svg class="pd-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>

                <h3>Belum ada kamar</h3>

                <p>Kamu belum memiliki kamar yang terdaftar.</p>

            </div>

        @endif

    </div>

</div>

@endsection
