@extends('layouts.teknisi')
@section('content')
@include('css.ui-style')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .dashboard-header {
        margin-bottom: 25px;
    }

    .dashboard-header h2 {
        margin: 0 0 8px;
        font-size: 24px;
    }

    .dashboard-header p {
        margin: 0;
        color: #64748b;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 18px;
        margin-bottom: 28px;
    }

    .stat-card {
        background: white;
        border-radius: 13px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
        border: 1px solid #edf0f5;
    }

    .stat-card .stat-label {
        color: #64748b;
        font-size: 14px;
    }

    .stat-card h3 {
        font-size: 29px;
        margin: 12px 0 0;
    }

    .stat-icon {
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-size: 20px;
        margin-bottom: 15px;
    }

    .blue { background: #dbeafe; color: #2563eb; }
    .orange { background: #ffedd5; color: #ea580c; }
    .green { background: #dcfce7; color: #16a34a; }
    .red { background: #fee2e2; color: #dc2626; }

    .dashboard-card {
        background: white;
        border-radius: 13px;
        padding: 22px;
        box-shadow: 0 3px 12px rgba(0,0,0,.04);
        border: 1px solid #edf0f5;
    }

    .dashboard-card h3 {
        margin: 0 0 18px;
    }

    .task-table {
        width: 100%;
        border-collapse: collapse;
    }

    .task-table th,
    .task-table td {
        padding: 14px 12px;
        border-bottom: 1px solid #edf0f5;
        text-align: left;
        font-size: 14px;
    }

    .task-table th {
        color: #64748b;
        background: #f8fafc;
    }

    .status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-menunggu {
        background: #ffedd5;
        color: #c2410c;
    }

    .status-diproses {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-selesai {
        background: #dcfce7;
        color: #15803d;
    }

    .btn-tugas {
        display: inline-block;
        padding: 9px 14px;
        background: #2563eb;
        color: white;
        border-radius: 7px;
        text-decoration: none;
        font-size: 13px;
    }

    @media (max-width: 900px) {
        .stats-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 600px) {
        .dashboard-header h2 {
            font-size: 20px;
        }

        .stats-grid {
            gap: 10px;
        }

        .stat-card {
            padding: 15px;
        }

        .stat-card h3 {
            font-size: 24px;
        }

        .dashboard-card {
            padding: 15px;
        }
    }
</style>

<div class="ui-page" style="--w: 1100px;">

    <div class="ui-head">
        <div>
            <h2>Selamat Datang, {{ auth()->user()->name }}!</h2>
            <p>Berikut ringkasan pekerjaan teknisi KosKita.</p>
        </div>
    </div>


<div class="stats-grid">

    <div class="stat-card">
        <div class="stat-icon blue">▤</div>
        <div class="stat-label">Total Tugas</div>
        <h3>{{ $totalTugas }}</h3>
    </div>

    <div class="stat-card">
        <div class="stat-icon orange">◷</div>
        <div class="stat-label">Menunggu</div>
        <h3>{{ $tugasMenunggu }}</h3>
    </div>

    <div class="stat-card">
        <div class="stat-icon blue">⚙</div>
        <div class="stat-label">Sedang Diproses</div>
        <h3>{{ $tugasDiproses }}</h3>
    </div>

    <div class="stat-card">
        <div class="stat-icon green">✓</div>
        <div class="stat-label">Selesai</div>
        <h3>{{ $tugasSelesai }}</h3>
    </div>

</div>

<div class="dashboard-card">

    <h3>Tugas Terbaru</h3>

    <div class="table-responsive">

        <table class="ui-table">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Judul Keluhan</th>
                    <th>Penghuni</th>
                    <th>Kamar</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>
                @forelse($tugasTerbaru as $tugas)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $tugas->judul }}</td>
                        <td>{{ $tugas->penghuni->user->name ?? '-' }}</td>
                        <td>{{ $tugas->kamar->nomor_kamar ?? '-' }}</td>
                        <td>
                            <span class="status status-{{ $tugas->status }}">
                                {{ ucfirst($tugas->status) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" style="text-align:center; padding:25px;">
                            Belum ada tugas yang ditugaskan kepada Anda.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection
