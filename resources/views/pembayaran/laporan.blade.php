
@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .report-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --ok: #17663d;
        --bad: #a3281c;

        font-family: 'Figtree', system-ui, sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 1200px) / 2)) 56px;
    }

    .report-page * { box-sizing: border-box; }

    .report-header { margin-bottom: 28px; }

    .report-header h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -.02em;
    }

    .report-header p {
        margin: 6px 0 0;
        color: var(--ink-soft);
        font-size: .95rem;
    }

    .report-panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 8px 24px rgba(15,23,42,.06);
        padding: 26px;
        margin-top: 24px;
    }

    .report-title {
        font-size: 1.1rem;
        font-weight: 700;
        margin: 0 0 18px;
    }

    .report-filter {
        display: flex;
        flex-wrap: wrap;
        align-items: end;
        gap: 14px;
    }

    .report-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
    }

    .report-field label {
        font-size: .84rem;
        font-weight: 600;
        color: var(--ink-soft);
    }

    .report-field select {
        min-width: 160px;
        padding: 11px 13px;
        border: 1px solid var(--line);
        border-radius: 9px;
        background: white;
        color: var(--ink);
        font: inherit;
        outline: none;
    }

    .report-field select:focus {
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37,99,235,.12);
    }

    .report-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 11px 17px;
        border: 0;
        border-radius: 9px;
        font: inherit;
        font-size: .88rem;
        font-weight: 600;
        text-decoration: none;
        cursor: pointer;
        transition: .2s;
    }

    .report-btn-primary {
        background: var(--blue);
        color: white;
    }

    .report-btn-primary:hover { background: var(--blue-dark); }

    .report-btn-light {
        background: var(--mist);
        color: var(--ink-soft);
    }

    .report-btn-light:hover { background: var(--line); }

    .report-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-top: 24px;
    }

    .report-stat {
        background: white;
        border: 1px solid var(--line);
        border-radius: 16px;
        padding: 22px;
        box-shadow: 0 1px 2px rgba(15,23,42,.04), 0 8px 24px rgba(15,23,42,.04);
        min-width: 0;
    }

    .report-stat-label {
        color: var(--ink-soft);
        font-size: .88rem;
        font-weight: 500;
    }

    .report-stat-value {
        margin-top: 9px;
        font-size: 1.45rem;
        font-weight: 700;
        letter-spacing: -.02em;
        overflow-wrap: anywhere;
    }

    .report-stat-caption {
        margin-top: 13px;
        padding-top: 12px;
        border-top: 1px solid var(--line);
        font-size: .82rem;
        color: var(--ink-soft);
    }

    .report-stat.income .report-stat-value { color: var(--ok); }
    .report-stat.unpaid .report-stat-value { color: var(--bad); }
    .report-stat.pending .report-stat-value { color: #a16207; }
    .report-stat.total .report-stat-value { color: var(--blue); }

    .report-table-wrap {
        overflow-x: auto;
        margin: 0 -26px -26px;
    }

    .report-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .report-table th {
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

    .report-table td {
        padding: 14px 20px;
        border-bottom: 1px solid var(--line);
        font-size: .9rem;
        vertical-align: middle;
    }

    .report-table tbody tr:last-child td { border-bottom: 0; }
    .report-table tbody tr:hover { background: #f3f7ff; }

    .report-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: .8rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-lunas { background: #dcfce7; color: #166534; }
    .status-belum { background: #fee2e2; color: #991b1b; }
    .status-menunggu { background: #fef3c7; color: #92400e; }
    .status-ditolak { background: #fce7f3; color: #9d174d; }

    .report-empty {
        padding: 40px 20px !important;
        text-align: center;
        color: var(--ink-soft);
    }

    @media (max-width: 1100px) {
        .report-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
    }

    @media (max-width: 600px) {
        .report-page { padding: 20px 14px 40px; }
        .report-header h1 { font-size: 1.6rem; }
        .report-grid { grid-template-columns: 1fr; }
        .report-panel { padding: 20px; }
        .report-table-wrap { margin: 0 -20px -20px; }
        .report-filter { align-items: stretch; }
        .report-field, .report-field select { width: 100%; }
    }
</style>

<div class="report-page">

    {{-- HEADER --}}
    <div class="report-header">
        <h1>Laporan Keuangan</h1>
        <p>Ringkasan dan riwayat transaksi pembayaran KosKita.</p>
    </div>

    {{-- FILTER --}}
    <div class="report-panel">
        <h2 class="report-title">Filter Laporan</h2>

        <form method="GET" action="{{ route('pembayaran.laporan') }}" class="report-filter">

            <div class="report-field">
                <label>Bulan</label>
                <select name="bulan">
                    <option value="">Semua Bulan</option>
                    @foreach([
                        1 => 'Januari', 2 => 'Februari', 3 => 'Maret',
                        4 => 'April', 5 => 'Mei', 6 => 'Juni',
                        7 => 'Juli', 8 => 'Agustus', 9 => 'September',
                        10 => 'Oktober', 11 => 'November', 12 => 'Desember'
                    ] as $angka => $nama)
                        <option value="{{ $angka }}" {{ (string)$bulan === (string)$angka ? 'selected' : '' }}>
                            {{ $nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="report-field">
                <label>Tahun</label>
                <select name="tahun">
                    @for($i = now()->year; $i >= 2020; $i--)
                        <option value="{{ $i }}" {{ (int)$tahun === $i ? 'selected' : '' }}>
                            {{ $i }}
                        </option>
                    @endfor
                </select>
            </div>

            <button type="submit" class="report-btn report-btn-primary">
                Terapkan Filter
            </button>

            <a href="{{ route('pembayaran.laporan') }}" class="report-btn report-btn-light">
                Reset
            </a>
        </form>
    </div>

    {{-- RINGKASAN --}}
    <div class="report-grid">

        <div class="report-stat income">
            <div class="report-stat-label">Total Pemasukan</div>
            <div class="report-stat-value">
                Rp{{ number_format($totalPemasukan, 0, ',', '.') }}
            </div>
            <div class="report-stat-caption">Pembayaran berstatus lunas</div>
        </div>

        <div class="report-stat unpaid">
            <div class="report-stat-label">Tagihan Belum Lunas</div>
            <div class="report-stat-value">
                Rp{{ number_format($totalNominalBelumLunas, 0, ',', '.') }}
            </div>
            <div class="report-stat-caption">Termasuk tagihan ditolak</div>
        </div>

        <div class="report-stat pending">
            <div class="report-stat-label">Menunggu Verifikasi</div>
            <div class="report-stat-value">
                Rp{{ number_format($totalMenungguVerifikasi, 0, ',', '.') }}
            </div>
            <div class="report-stat-caption">Menunggu pemeriksaan admin</div>
        </div>

        <div class="report-stat total">
            <div class="report-stat-label">Total Tagihan</div>
            <div class="report-stat-value">{{ $jumlahTransaksi }}</div>
            <div class="report-stat-caption">Data sesuai filter</div>
        </div>

    </div>

    {{-- RIWAYAT TRANSAKSI --}}
    <div class="report-panel">
        <h2 class="report-title">Riwayat Transaksi</h2>

        <div class="report-table-wrap">
            <table class="report-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Penghuni</th>
                        <th>Kamar</th>
                        <th>Periode</th>
                        <th>Jumlah</th>
                        <th>Tanggal Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pembayarans as $pembayaran)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pembayaran->penghuni->user->name ?? '-' }}</td>
                            <td>{{ $pembayaran->penghuni->kamar->nomor_kamar ?? '-' }}</td>
                            <td>{{ $pembayaran->bulan ?? $pembayaran->periode ?? '-' }}</td>
                            <td style="white-space:nowrap;">
                                Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </td>
                            <td>
                                {{ $pembayaran->tanggal_bayar
                                    ? \Carbon\Carbon::parse($pembayaran->tanggal_bayar)->format('d/m/Y')
                                    : '-' }}
                            </td>
                            <td>
                                @php
                                    $statusClass = [
                                        'lunas' => 'status-lunas',
                                        'belum_lunas' => 'status-belum',
                                        'menunggu_verifikasi' => 'status-menunggu',
                                        'ditolak' => 'status-ditolak',
                                    ];

                                    $statusText = [
                                        'lunas' => 'Lunas',
                                        'belum_lunas' => 'Belum Lunas',
                                        'menunggu_verifikasi' => 'Menunggu Verifikasi',
                                        'ditolak' => 'Ditolak',
                                    ];
                                @endphp

                                <span class="report-badge {{ $statusClass[$pembayaran->status] ?? '' }}">
                                    {{ $statusText[$pembayaran->status] ?? ucfirst($pembayaran->status) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="report-empty">
                                Belum ada data tagihan untuk periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
