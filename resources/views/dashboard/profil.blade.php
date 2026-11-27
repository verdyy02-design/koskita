@extends('layouts.penghuni')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .profil-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --ok-bg: #dff3e8;
        --ok-fg: #17663d;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 860px) / 2)) 56px;
    }

    .profil-page * { box-sizing: border-box; }

    .profil-icon {
        width: 18px;
        height: 18px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.9;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Header */
    .profil-head { margin-bottom: 24px; }
    .profil-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .profil-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    /* Panel */
    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    /* Identitas */
    .profil-hero {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 26px;
    }

    .profil-avatar {
        display: grid;
        place-items: center;
        width: 72px;
        height: 72px;
        flex: none;
        border-radius: 50%;
        background: var(--blue);
        color: #fff;
        font-size: 1.9rem;
        font-weight: 700;
    }

    .profil-hero h2 { margin: 0; font-size: 1.4rem; font-weight: 700; letter-spacing: -0.01em; }
    .profil-hero p { margin: 4px 0 0; color: var(--ink-soft); font-size: .92rem; }

    .profil-actions {
        display: flex;
        gap: 10px;
        margin-left: auto;
        flex-wrap: wrap;
    }

    /* Tombol */
    .profil-page .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 16px;
        border: 1px solid transparent;
        border-radius: 10px;
        font: inherit;
        font-size: .9rem;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .15s, border-color .15s, color .15s;
    }

    .profil-page .btn-primary { background: var(--blue); color: #fff; }
    .profil-page .btn-primary:hover { background: var(--blue-dark); }
    .profil-page .btn-ghost { background: var(--card); border-color: var(--line); color: var(--ink); }
    .profil-page .btn-ghost:hover { border-color: var(--blue); color: var(--blue); }

    .profil-page a:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    /* Info */
    .profil-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 20px;
        margin-top: 20px;
    }

    .info-card { padding: 24px 26px; }

    .info-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 6px;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .info-title .profil-icon { width: 20px; height: 20px; color: var(--blue); }

    .info-list { margin: 0; }

    .info-row {
        display: flex;
        flex-direction: column;
        gap: 3px;
        padding: 14px 0;
        border-bottom: 1px solid var(--line);
    }

    .info-row:last-child { border-bottom: 0; padding-bottom: 0; }

    .info-row dt { color: var(--ink-soft); font-size: .82rem; font-weight: 500; }
    .info-row dd { margin: 0; font-size: .96rem; font-weight: 600; word-break: break-word; }

    .badge-aktif {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 4px 12px;
        border-radius: 999px;
        background: var(--ok-bg);
        color: var(--ok-fg);
        font-size: .84rem;
        font-weight: 600;
    }

    .badge-aktif::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    @media (max-width: 760px) {
        .profil-page { padding: 20px 14px 40px; }
        .profil-head h1 { font-size: 1.6rem; }
        .profil-grid { grid-template-columns: 1fr; }
        .profil-hero { flex-direction: column; align-items: flex-start; }
        .profil-actions { margin-left: 0; }
    }
</style>

<div class="profil-page">

    <div class="profil-head">
        <h1>Profil Saya</h1>
        <p>Informasi data pribadi dan kamar Anda.</p>
    </div>


    <!-- IDENTITAS -->
    <div class="panel profil-hero">

        <div class="profil-avatar">
            {{ strtoupper(substr($penghuni->user->name, 0, 1)) }}
        </div>

        <div>
            <h2>{{ $penghuni->user->name }}</h2>
            <p>Penghuni KosKita</p>
        </div>

        <div class="profil-actions">
            <a href="{{ route('penghuni.profil.edit') }}" class="btn btn-primary">
                <svg class="profil-icon" viewBox="0 0 24 24"><path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16v4Z"/><path d="m13.5 6.5 4 4"/></svg>
                Edit profil
            </a>

            <a href="{{ route('penghuni.password.edit') }}" class="btn btn-ghost">
                <svg class="profil-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Ganti password
            </a>
        </div>

    </div>


    <div class="profil-grid">

        <!-- INFORMASI PRIBADI -->
        <div class="panel info-card">

            <h3 class="info-title">
                <svg class="profil-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Informasi pribadi
            </h3>

            <dl class="info-list">
                <div class="info-row">
                    <dt>Nama</dt>
                    <dd>{{ $penghuni->user->name }}</dd>
                </div>

                <div class="info-row">
                    <dt>Email</dt>
                    <dd>{{ $penghuni->user->email }}</dd>
                </div>

                <div class="info-row">
                    <dt>NIK</dt>
                    <dd>{{ $penghuni->nik }}</dd>
                </div>

                <div class="info-row">
                    <dt>No. HP</dt>
                    <dd>{{ $penghuni->no_hp }}</dd>
                </div>

                <div class="info-row">
                    <dt>Alamat</dt>
                    <dd>{{ $penghuni->alamat ?? '-' }}</dd>
                </div>
            </dl>

        </div>


        <!-- INFORMASI KAMAR -->
        <div class="panel info-card">

            <h3 class="info-title">
                <svg class="profil-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
                Informasi kamar
            </h3>

            <dl class="info-list">
                <div class="info-row">
                    <dt>Nomor kamar</dt>
                    <dd>{{ $penghuni->kamar->nomor_kamar ?? 'Belum ditempatkan' }}</dd>
                </div>

                <div class="info-row">
                    <dt>Tanggal masuk</dt>
                    <dd>
                        {{ $penghuni->tanggal_masuk
                            ? \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d-m-Y')
                            : '-' }}
                    </dd>
                </div>

                <div class="info-row">
                    <dt>Tanggal keluar</dt>
                    <dd>
                        @if($penghuni->tanggal_keluar)
                            {{ \Carbon\Carbon::parse($penghuni->tanggal_keluar)->format('d-m-Y') }}
                        @else
                            <span class="badge-aktif">Masih aktif</span>
                        @endif
                    </dd>
                </div>
            </dl>

        </div>

    </div>

</div>

@endsection
