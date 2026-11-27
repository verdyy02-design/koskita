@extends('layouts.penghuni')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .pm-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --ok-bg: #dff3e8;   --ok-fg: #17663d;
        --warn-bg: #fdf0d2; --warn-fg: #8a5a05;
        --busy-bg: #fde4e1; --busy-fg: #a3281c;
        --slate-bg: #e2e8f0; --slate-fg: #334155;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 1000px) / 2)) 56px;
    }

    .pm-page * { box-sizing: border-box; }

    .pm-icon {
        width: 20px;
        height: 20px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .pm-head { margin-bottom: 24px; }
    .pm-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .pm-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    .panel {
        margin-bottom: 22px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 4px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .panel-title .pm-icon { color: var(--blue); }
    .panel-sub { margin: 0; color: var(--ink-soft); font-size: .92rem; }

    /* Buttons */
    .pm-page .btn {
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
        white-space: nowrap;
        cursor: pointer;
        transition: background-color .15s, border-color .15s, color .15s;
    }

    .pm-page .btn .pm-icon { width: 16px; height: 16px; }
    .pm-page .btn-sm { padding: 8px 14px; font-size: .84rem; border-radius: 8px; }
    .pm-page .btn-primary { background: var(--blue); color: #fff; }
    .pm-page .btn-primary:hover { background: var(--blue-dark); }
    .pm-page .btn-ghost { background: var(--card); border-color: var(--line); color: var(--ink); }
    .pm-page .btn-ghost:hover { border-color: var(--blue); color: var(--blue); }

    .pm-page a:focus-visible,
    .pm-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    /* QRIS */
    .qris-panel { padding: 28px; }

    .qris-body {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 28px;
        margin-top: 22px;
        align-items: start;
    }

    .qris-image {
        padding: 14px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .qris-image img { display: block; width: 100%; height: auto; border-radius: 6px; }

    .qris-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 32px 20px;
        background: var(--mist);
        border: 1px dashed #9db4e0;
        border-radius: 14px;
        text-align: center;
        color: var(--ink-soft);
    }

    .qris-placeholder .pm-icon { width: 40px; height: 40px; color: var(--blue); opacity: .7; }
    .qris-placeholder strong { color: var(--ink); }
    .qris-placeholder p { margin: 0; font-size: .9rem; line-height: 1.5; }

    .qris-side { display: flex; flex-direction: column; gap: 16px; }

    .owner-label { color: var(--ink-soft); font-size: .82rem; font-weight: 500; }
    .owner-name { margin: 2px 0 0; font-weight: 600; }

    .qris-actions { display: flex; gap: 10px; flex-wrap: wrap; }

    .transfer-box {
        padding: 16px 18px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .transfer-box .heading { margin: 0 0 10px; font-size: .9rem; font-weight: 600; }

    .transfer-row {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 4px 0;
        font-size: .92rem;
    }

    .transfer-row .k { color: var(--ink-soft); }
    .transfer-row .v { font-weight: 600; font-variant-numeric: tabular-nums; }

    .qris-note { margin: 0; color: var(--ink-soft); font-size: .88rem; line-height: 1.5; }

    /* Alert */
    .pm-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 10px;
        font-weight: 500;
    }

    .pm-alert .pm-icon { width: 20px; height: 20px; }
    .pm-alert-success { background: var(--ok-bg); color: var(--ok-fg); border: 1px solid #bde3cd; border-left: 4px solid var(--ok-fg); }
    .pm-alert-error { background: var(--busy-bg); color: var(--busy-fg); border: 1px solid #f3b9b3; border-left: 4px solid var(--busy-fg); }

    /* Tabel */
    .table-head { padding: 24px 26px 18px; }
    .table-scroll { overflow-x: auto; }

    .pm-table { width: 100%; min-width: 760px; border-collapse: collapse; }

    .pm-table thead th {
        padding: 13px 20px;
        background: var(--mist);
        border-top: 1px solid var(--line);
        border-bottom: 1px solid var(--line);
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .pm-table tbody td {
        padding: 15px 20px;
        border-bottom: 1px solid var(--line);
        font-size: .92rem;
        vertical-align: middle;
    }

    .pm-table tbody tr:last-child td { border-bottom: 0; }
    .pm-table tbody tr:hover { background: #f3f7ff; }

    .col-no { width: 56px; color: var(--ink-soft); }
    .col-jumlah { font-weight: 600; font-variant-numeric: tabular-nums; white-space: nowrap; }
    .col-date { color: var(--ink-soft); white-space: nowrap; }

    .badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-lunas { background: var(--ok-bg); color: var(--ok-fg); }
    .badge-menunggu { background: var(--warn-bg); color: var(--warn-fg); }
    .badge-ditolak { background: var(--busy-bg); color: var(--busy-fg); }
    .badge-belum { background: var(--slate-bg); color: var(--slate-fg); }

    .aksi-note { color: var(--ink-soft); font-size: .86rem; }

    /* Kosong */
    .empty { padding: 56px 20px; text-align: center; color: var(--ink-soft); }
    .empty .pm-icon { width: 44px; height: 44px; margin-bottom: 12px; color: var(--blue); opacity: .7; }
    .empty h3 { margin: 0 0 6px; color: var(--ink); font-size: 1.1rem; }
    .empty p { margin: 0; }

    @media (max-width: 760px) {
        .pm-page { padding: 20px 14px 40px; }
        .pm-head h1 { font-size: 1.6rem; }
        .qris-panel { padding: 22px; }
        .qris-body { grid-template-columns: 1fr; }
        .qris-image,
        .qris-placeholder { max-width: 300px; }
        .table-head { padding: 20px 22px 16px; }
    }
</style>

<div class="pm-page">

    <div class="pm-head">
        <h1>Pembayaran Saya</h1>
        <p>Daftar tagihan pembayaran kos Anda.</p>
    </div>


    <!-- QRIS -->
    <div class="panel qris-panel">

        <h2 class="panel-title">
            <svg class="pm-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5" rx="1"/><rect x="16" y="3" width="5" height="5" rx="1"/><rect x="3" y="16" width="5" height="5" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/></svg>
            Pembayaran kos via QRIS
        </h2>
        <p class="panel-sub">Scan QRIS DANA Bisnis di bawah untuk melakukan pembayaran.</p>

        <div class="qris-body">

            @if($qris && $qris->gambar_qris)

                <div class="qris-image">
                    <img
                        src="{{ asset('storage/' . $qris->gambar_qris) }}"
                        alt="QRIS DANA Bisnis"
                    >
                </div>

            @else

                <div class="qris-placeholder">
                    <svg class="pm-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5" rx="1"/><rect x="16" y="3" width="5" height="5" rx="1"/><rect x="3" y="16" width="5" height="5" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/></svg>
                    <strong>QRIS belum tersedia</strong>
                    <p>Admin belum mengunggah QRIS pembayaran, silakan gunakan metode pembayaran yang lain ya!</p>
                </div>

            @endif


            <div class="qris-side">

                @if($qris && $qris->gambar_qris)

                    <div>
                        <div class="owner-label">Atas nama</div>
                        <p class="owner-name">{{ $qris->nama_pemilik ?? 'Pemilik KosKita' }}</p>
                    </div>

                    <div class="qris-actions">
                        <a href="{{ asset('storage/' . $qris->gambar_qris) }}"
                           download="QRIS-KosKita"
                           class="btn btn-primary">
                            <svg class="pm-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m7 10 5 5 5-5"/><path d="M12 15V3"/></svg>
                            Download QRIS
                        </a>
                    </div>

                @endif

                <div class="transfer-box">
                    <p class="heading">Alternatif pembayaran DANA</p>

                    <div class="transfer-row">
                        <span class="k">Nomor</span>
                        <span class="v" id="nomorDana">082250746645</span>
                    </div>

                    <div class="transfer-row">
                        <span class="k">Atas nama</span>
                        <span class="v">Muhammad Vierdian Aguina</span>
                    </div>

                    <div class="transfer-row" style="margin-top: 8px;">
                        <button type="button" class="btn btn-ghost btn-sm" id="salinNomor">
                            <svg class="pm-icon" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                            <span>Salin nomor</span>
                        </button>
                    </div>
                </div>

                <p class="qris-note">
                    Setelah membayar, silakan unggah bukti pembayaran pada tagihan Anda.
                </p>

            </div>

        </div>

    </div>


    @if(session('success'))
        <div class="pm-alert pm-alert-success" role="status">
            <svg class="pm-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="pm-alert pm-alert-error" role="alert">
            <svg class="pm-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            {{ session('error') }}
        </div>
    @endif


    <!-- DAFTAR TAGIHAN -->
    @if($pembayarans->count() > 0)

        <div class="panel">

            <div class="table-head">
                <h2 class="panel-title">
                    <svg class="pm-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
                    Daftar tagihan
                </h2>
            </div>

            <div class="table-scroll">
                <table class="pm-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Periode</th>
                            <th>Jumlah</th>
                            <th>Jatuh tempo</th>
                            <th>Status</th>
                            <th>Tanggal bayar</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($pembayarans as $pembayaran)
                            <tr>
                                <td class="col-no">{{ $loop->iteration }}</td>

                                <td>{{ $pembayaran->bulan ?? $pembayaran->periode }}</td>

                                <td class="col-jumlah">
                                    Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </td>

                                <td class="col-date">
                                    {{ $pembayaran->tanggal_jatuh_tempo
                                        ? \Carbon\Carbon::parse($pembayaran->tanggal_jatuh_tempo)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if($pembayaran->status === 'lunas')
                                        <span class="badge badge-lunas">Lunas</span>
                                    @elseif($pembayaran->status === 'menunggu_verifikasi')
                                        <span class="badge badge-menunggu">Menunggu verifikasi</span>
                                    @elseif($pembayaran->status === 'ditolak')
                                        <span class="badge badge-ditolak">Ditolak</span>
                                    @else
                                        <span class="badge badge-belum">Belum lunas</span>
                                    @endif
                                </td>

                                <td class="col-date">
                                    {{ $pembayaran->tanggal_bayar
                                        ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td>
                                    @if(in_array($pembayaran->status, ['belum_lunas', 'ditolak']))
                                        <a href="{{ route('penghuni.pembayaran.bayar', $pembayaran->id) }}"
                                           class="btn btn-primary btn-sm">
                                            Bayar sekarang
                                        </a>
                                    @elseif($pembayaran->status === 'menunggu_verifikasi')
                                        <span class="aksi-note">Sedang diperiksa admin</span>
                                    @elseif($pembayaran->status === 'lunas')
                                        <span class="aksi-note">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>

    @else

        <div class="panel empty">

            <svg class="pm-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>

            <h3>Belum ada tagihan</h3>

            <p>Belum ada tagihan pembayaran yang diberikan kepada Anda.</p>

        </div>

    @endif

</div>

<script>
    (function () {
        var tombol = document.getElementById('salinNomor');
        var nomor = document.getElementById('nomorDana');
        if (!tombol || !nomor || !navigator.clipboard) return;

        tombol.addEventListener('click', function () {
            navigator.clipboard.writeText(nomor.textContent.trim()).then(function () {
                var label = tombol.querySelector('span');
                label.textContent = 'Tersalin';
                setTimeout(function () { label.textContent = 'Salin nomor'; }, 1800);
            });
        });
    })();
</script>

@endsection
