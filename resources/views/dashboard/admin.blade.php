@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .dash-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;

        --tone-blue-bg: #dbe7fe;   --tone-blue-fg: #1d4ed8;
        --tone-indigo-bg: #e3e5fb; --tone-indigo-fg: #4338ca;
        --tone-slate-bg: #e2e8f0;  --tone-slate-fg: #334155;
        --tone-amber-bg: #fdf0d2;  --tone-amber-fg: #8a5a05;
        --ok: #17663d;
        --bad: #a3281c;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 1200px) / 2)) 56px;
    }

    .dash-page * { box-sizing: border-box; }

    .dash-icon {
        width: 22px;
        height: 22px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Header */
    .dash-head { margin-bottom: 28px; }
    .dash-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .dash-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    /* Grid */
    .stat-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
    }

    .stat-grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }

    /* Panel dasar */
    .panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    /* Kartu statistik */
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
    .tone-slate  { background: var(--tone-slate-bg);  color: var(--tone-slate-fg); }
    .tone-amber  { background: var(--tone-amber-bg);  color: var(--tone-amber-fg); }

    .stat-label { color: var(--ink-soft); font-size: .88rem; font-weight: 500; }

    .stat-value {
        margin-top: 4px;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.1;
        font-variant-numeric: tabular-nums;
    }

    .stat-detail {
        margin-top: 16px;
        padding-top: 14px;
        border-top: 1px solid var(--line);
        font-size: .84rem;
        color: var(--ink-soft);
    }

    .stat-row {
        display: flex;
        justify-content: space-between;
        padding: 3px 0;
    }

    .stat-row strong { color: var(--ink); font-weight: 600; font-variant-numeric: tabular-nums; }

    /* Section */
    .dash-section { margin-top: 24px; padding: 26px; }

    .section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        font-size: 1.1rem;
        font-weight: 700;
    }

    .section-title .dash-icon { width: 20px; height: 20px; color: var(--blue); }

    /* Tile pembayaran */
    .pay-tile {
        padding: 18px 20px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .pay-tile .stat-value { font-size: 1.7rem; }
    .pay-tile .ok { color: var(--ok); }
    .pay-tile .bad { color: var(--bad); }

    /* Tabel aktivitas */
    .table-scroll { overflow-x: auto; margin: 0 -26px -26px; }

    .activity-table { width: 100%; min-width: 680px; border-collapse: collapse; }

    .activity-table th {
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

    .activity-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--line);
        font-size: .9rem;
        vertical-align: middle;
    }

    .activity-table tbody tr:last-child td { border-bottom: 0; }
    .activity-table tbody tr:hover { background: #f3f7ff; }

    .activity-badge {
        display: inline-block;
        padding: 5px 12px;
        background: var(--tone-blue-bg);
        color: var(--tone-blue-fg);
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
    }

    .activity-time { color: var(--ink-soft); white-space: nowrap; font-variant-numeric: tabular-nums; }

    .empty-cell { padding: 40px 20px !important; text-align: center; color: var(--ink-soft); }

    /* Info */
    .info-card p { margin: 0; color: var(--ink-soft); line-height: 1.7; max-width: 80ch; }
    .info-card p + p { margin-top: 10px; }

    @media (max-width: 1100px) {
        .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        .stat-grid.cols-3 { grid-template-columns: repeat(3, minmax(0, 1fr)); }
    }

    @media (max-width: 600px) {
        .dash-page { padding: 20px 14px 40px; }
        .dash-head h1 { font-size: 1.6rem; }
        .stat-grid,
        .stat-grid.cols-3 { grid-template-columns: 1fr; }
        .dash-section { padding: 20px; }
        .table-scroll { margin: 0 -20px -20px; }
    }


    /* LAPORAN KEUANGAN */
    .finance-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .finance-card {
        padding: 22px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .finance-card .finance-label {
        color: var(--ink-soft);
        font-size: .88rem;
        font-weight: 500;
    }

    .finance-card .finance-value {
        margin-top: 9px;
        font-size: 1.55rem;
        font-weight: 700;
        color: var(--ink);
        overflow-wrap: anywhere;
    }

    .finance-card .finance-caption {
        margin-top: 8px;
        font-size: .82rem;
        color: var(--ink-soft);
    }

    .finance-card.income {
        background: #ecfdf5;
        border-color: #bbf7d0;
    }

    .finance-card.income .finance-value {
        color: #15803d;
    }

    .finance-card.pending {
        background: #fffbeb;
        border-color: #fde68a;
    }

    .finance-card.pending .finance-value {
        color: #a16207;
    }

    .finance-card.unpaid {
        background: #fef2f2;
        border-color: #fecaca;
    }

    .finance-card.unpaid .finance-value {
        color: #b91c1c;
    }

    .finance-chart {
        display: flex;
        align-items: flex-end;
        justify-content: space-around;
        gap: 12px;
        min-height: 250px;
        padding: 25px 10px 0;
        border-bottom: 1px solid var(--line);
    }

    .finance-chart-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: flex-end;
        flex: 1;
        height: 220px;
        min-width: 0;
        gap: 8px;
    }

    .finance-bar {
        width: min(100%, 34px);
        min-height: 3px;
        background: linear-gradient(180deg, #60a5fa, #2563eb);
        border-radius: 7px 7px 0 0;
        transition: height .3s ease;
    }

    .finance-month {
        font-size: .72rem;
        color: var(--ink-soft);
        white-space: nowrap;
    }

    .finance-chart-value {
        font-size: .68rem;
        color: var(--ink-soft);
        font-weight: 600;
    }

    .finance-summary {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-top: 18px;
        color: var(--ink-soft);
        font-size: .88rem;
    }

    @media (max-width: 700px) {
        .finance-grid {
            grid-template-columns: 1fr;
        }

        .finance-chart {
            gap: 5px;
            padding-left: 0;
            padding-right: 0;
        }

        .finance-month {
            font-size: .62rem;
        }

        .finance-chart-value {
            font-size: .58rem;
        }
    }

</style>

<div class="dash-page">

    <!-- HEADER -->
    <div class="dash-head">
        <h1>Dashboard Admin</h1>
        <p>Selamat datang di sistem manajemen KosKita.</p>
    </div>


    <!-- STATISTIK UTAMA -->
    <div class="stat-grid">

        <!-- KAMAR -->
        <div class="panel stat-card">
            <div class="stat-icon tone-blue">
                <svg class="dash-icon" viewBox="0 0 24 24"><path d="M2 20v-8a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v8"/><path d="M4 10V6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4"/><path d="M12 4v6"/><path d="M2 18h20"/></svg>
            </div>
            <div class="stat-label">Total kamar</div>
            <div class="stat-value">{{ $totalKamar }}</div>
            <div class="stat-detail">
                <div class="stat-row"><span>Kosong</span><strong>{{ $kamarKosong }}</strong></div>
                <div class="stat-row"><span>Terisi</span><strong>{{ $kamarTerisi }}</strong></div>
                <div class="stat-row"><span>Perbaikan</span><strong>{{ $kamarPerbaikan }}</strong></div>
            </div>
        </div>

        <!-- PENGHUNI -->
        <div class="panel stat-card">
            <div class="stat-icon tone-indigo">
                <svg class="dash-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-label">Total penghuni</div>
            <div class="stat-value">{{ $totalPenghuni }}</div>
            <div class="stat-detail">
                <div class="stat-row"><span>Penghuni aktif</span><strong>{{ $penghuniAktif }}</strong></div>
            </div>
        </div>

        <!-- TEKNISI -->
        <div class="panel stat-card">
            <div class="stat-icon tone-slate">
                <svg class="dash-icon" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
            </div>
            <div class="stat-label">Total teknisi</div>
            <div class="stat-value">{{ $totalTeknisi }}</div>
            <div class="stat-detail">
                Akun teknisi terdaftar
            </div>
        </div>

        <!-- KELUHAN -->
        <div class="panel stat-card">
            <div class="stat-icon tone-amber">
                <svg class="dash-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
            </div>
            <div class="stat-label">Total keluhan</div>
            <div class="stat-value">{{ $totalKeluhan }}</div>
            <div class="stat-detail">
                <div class="stat-row"><span>Menunggu</span><strong>{{ $keluhanMenunggu }}</strong></div>
                <div class="stat-row"><span>Diproses</span><strong>{{ $keluhanDiproses }}</strong></div>
                <div class="stat-row"><span>Selesai</span><strong>{{ $keluhanSelesai }}</strong></div>
            </div>
        </div>

    </div>


    <!-- STATISTIK PEMBAYARAN -->
    <div class="panel dash-section">

        <h2 class="section-title">
            <svg class="dash-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
            Ringkasan pembayaran
        </h2>

        <div class="stat-grid cols-3">

            <div class="pay-tile">
                <div class="stat-label">Total tagihan</div>
                <div class="stat-value">{{ $totalTagihan }}</div>
            </div>

            <div class="pay-tile">
                <div class="stat-label">Tagihan lunas</div>
                <div class="stat-value ok">{{ $tagihanLunas }}</div>
            </div>

            <div class="pay-tile">
                <div class="stat-label">Belum lunas</div>
                <div class="stat-value bad">{{ $tagihanBelumLunas }}</div>
            </div>

        </div>

    </div>


<!-- LAPORAN KEUANGAN -->
<div class="panel dash-section">

    <h2 class="section-title">
        <svg class="dash-icon" viewBox="0 0 24 24">
            <path d="M3 3v18h18"/>
            <path d="m19 9-5 5-4-4-5 5"/>
        </svg>
        Laporan Keuangan
    </h2>

    <!-- KARTU KEUANGAN -->
    <div class="finance-grid">

        <div class="finance-card income">
            <div class="finance-label">Total Pemasukan</div>
            <div class="finance-value">
                Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
            <div class="finance-caption">
                Dari seluruh pembayaran lunas
            </div>
        </div>

        <div class="finance-card unpaid">
            <div class="finance-label">Tagihan Belum Lunas</div>
            <div class="finance-value">
                Rp{{ number_format($totalNominalBelumLunas, 0, ',', '.') }}
            </div>
            <div class="finance-caption">
                {{ $tagihanBelumLunas }} tagihan belum lunas
            </div>
        </div>

        <div class="finance-card pending">
            <div class="finance-label">Menunggu Verifikasi</div>
            <div class="finance-value">
                Rp{{ number_format($totalMenungguVerifikasi, 0, ',', '.') }}
            </div>
            <div class="finance-caption">
                {{ $tagihanMenungguVerifikasi }} pembayaran menunggu
            </div>
        </div>

    </div>

    <!-- GRAFIK PEMASUKAN -->
    <div style="margin-top:30px;">

        <h3 style="font-size:1rem; font-weight:700; margin-bottom:5px;">
            Grafik Pemasukan Bulanan
        </h3>

        <p style="font-size:.85rem; color:var(--ink-soft); margin-bottom:10px;">
            Periode Januari – Desember {{ $tahunLaporan }}
        </p>

        @php
            $maksimalPemasukan = max(
                array_column($pemasukanBulanan, 'total')
            ) ?: 1;
        @endphp

        <div class="finance-chart">

            @foreach($pemasukanBulanan as $data)

                @php
                    $tinggiBar = ($data['total'] / $maksimalPemasukan) * 170;
                @endphp

                <div class="finance-chart-item">

                    <div class="finance-chart-value">
                        {{ $data['total'] > 0
                            ? number_format($data['total'] / 1000000, 1, ',', '.') . ' jt'
                            : '0' }}
                    </div>

                    <div
                        class="finance-bar"
                        style="height: {{ $data['total'] > 0 ? max($tinggiBar, 5) : 3 }}px;"
                        title="Rp{{ number_format($data['total'], 0, ',', '.') }}"
                    ></div>

                    <div class="finance-month">
                        {{ substr($data['bulan'], 0, 3) }}
                    </div>

                </div>

            @endforeach

        </div>

        <div class="finance-summary">
            <span>
                Total transaksi lunas:
                <strong>{{ $tagihanLunas }} transaksi</strong>
            </span>

            <span>
                Tahun laporan:
                <strong>{{ $tahunLaporan }}</strong>
            </span>
        </div>

    </div>

</div>


    <!-- AKTIVITAS TERBARU -->
    <div class="panel dash-section">

        <h2 class="section-title">
            <svg class="dash-icon" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
            Aktivitas terbaru
        </h2>

        <div class="table-scroll">
            <table class="activity-table">

                <thead>
                    <tr>
                        <th>Pengguna</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($aktivitasTerbaru as $aktivitas)

                        <tr>
                            <td>{{ $aktivitas->nama_pengguna ?? 'System' }}</td>

                            <td>{{ ucfirst($aktivitas->role ?? '-') }}</td>

                            <td>
                                <span class="activity-badge">{{ $aktivitas->aktivitas }}</span>
                            </td>

                            <td>{{ $aktivitas->deskripsi ?? '-' }}</td>

                            <td class="activity-time">{{ $aktivitas->created_at->format('d/m/Y H:i') }}</td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="empty-cell">Belum ada aktivitas tercatat.</td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>

    </div>


    <!-- INFO SISTEM -->
    <div class="panel dash-section info-card">

        <h2 class="section-title">
            <svg class="dash-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
            Sistem KosKita
        </h2>

        <p>
            KosKita merupakan sistem informasi manajemen kos
            yang membantu administrator dalam mengelola kamar,
            penghuni, teknisi, pembayaran, keluhan, serta
            penugasan teknisi.
        </p>

        <p>
            Melalui dashboard ini, administrator dapat memantau
            kondisi operasional kos dan melihat aktivitas terbaru
            yang terjadi di dalam sistem.
        </p>

    </div>

</div>

@endsection
