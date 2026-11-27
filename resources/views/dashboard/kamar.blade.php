@extends('layouts.penghuni')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .pk-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --tone-blue-bg: #dbe7fe; --tone-blue-fg: #1d4ed8;
        --ok-bg: #dff3e8;   --ok-fg: #17663d;
        --warn-bg: #fdf0d2; --warn-fg: #8a5a05;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 860px) / 2)) 56px;
    }

    .pk-page * { box-sizing: border-box; }

    .pk-icon {
        width: 16px;
        height: 16px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.9;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .page-title { margin-bottom: 24px; }
    .page-title h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .page-title p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    .room-card { padding: 28px; }

    .room-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 22px;
        border-bottom: 1px solid var(--line);
    }

    .room-header .caption { color: var(--ink-soft); font-size: .88rem; font-weight: 500; }

    .room-number {
        margin-top: 2px;
        font-size: 2.2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.1;
        color: var(--blue);
    }

    .status {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 6px 14px;
        border-radius: 999px;
        background: var(--tone-blue-bg);
        color: var(--tone-blue-fg);
        font-size: .85rem;
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

    .room-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 14px;
    }

    .info {
        padding: 16px 18px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .label {
        display: flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 7px;
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 500;
    }

    .label .pk-icon { color: var(--blue); }

    .value { font-size: 1rem; font-weight: 600; word-break: break-word; }
    .value small { color: var(--ink-soft); font-weight: 500; }

    .empty { padding: 56px 20px; text-align: center; color: var(--ink-soft); }
    .empty .pk-icon { width: 44px; height: 44px; margin-bottom: 12px; color: var(--blue); opacity: .7; }
    .empty h2 { margin: 0 0 6px; color: var(--ink); font-size: 1.15rem; }
    .empty p { margin: 0; }

    @media (max-width: 700px) {
        .pk-page { padding: 20px 14px 40px; }
        .page-title h1 { font-size: 1.6rem; }
        .room-grid { grid-template-columns: 1fr; }
        .room-card { padding: 22px; }
    }
</style>

<div class="pk-page">

    <div class="page-title">
        <h1>Kamar Saya</h1>
        <p>Informasi kamar yang sedang kamu tempati.</p>
    </div>


    @if ($penghuni && $penghuni->kamar)

        <div class="panel room-card">

            <div class="room-header">

                <div>
                    <div class="caption">Nomor kamar</div>
                    <div class="room-number">{{ $penghuni->kamar->nomor_kamar }}</div>
                </div>

                <span class="status status-{{ \Illuminate\Support\Str::slug($penghuni->kamar->status) }}">
                    {{ ucfirst($penghuni->kamar->status) }}
                </span>

            </div>


            <div class="room-grid">

                <div class="info">
                    <div class="label">
                        <svg class="pk-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                        Harga kamar
                    </div>

                    <div class="value">
                        Rp {{ number_format($penghuni->kamar->harga, 0, ',', '.') }}
                        <small>/ bulan</small>
                    </div>
                </div>


                <div class="info">
                    <div class="label">
                        <svg class="pk-icon" viewBox="0 0 24 24"><path d="M8 6h13"/><path d="M8 12h13"/><path d="M8 18h13"/><path d="M3 6h.01"/><path d="M3 12h.01"/><path d="M3 18h.01"/></svg>
                        Fasilitas
                    </div>

                    <div class="value">
                        {{ $penghuni->kamar->fasilitas ?? 'Tidak ada data' }}
                    </div>
                </div>


                <div class="info">
                    <div class="label">
                        <svg class="pk-icon" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><path d="M16 2v4"/><path d="M8 2v4"/><path d="M3 10h18"/></svg>
                        Tanggal masuk
                    </div>

                    <div class="value">
                        {{ \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d F Y') }}
                    </div>
                </div>


                <div class="info">
                    <div class="label">
                        <svg class="pk-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Nama penghuni
                    </div>

                    <div class="value">{{ $penghuni->user->name }}</div>
                </div>

            </div>

        </div>

    @else

        <div class="panel empty">

            <svg class="pk-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>

            <h2>Belum memiliki kamar</h2>

            <p>Saat ini belum ada kamar yang terhubung dengan akun kamu.</p>

        </div>

    @endif

</div>

@endsection
