@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .kamar-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --teal: #2563eb;
        --teal-dark: #1d4ed8;
        --mist: #e8eefb;
        --line: #d3def3;
        --surface: #ffffff;
        --page: #e8eefb;
        --gold: #c98a1b;
        --ok-bg: #dff3e8;   --ok-fg: #17663d;
        --busy-bg: #fde4e1; --busy-fg: #a3281c;
        --warn-bg: #fdf0d2; --warn-fg: #8a5a05;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 1100px) / 2)) 56px;
    }

    .kamar-page * { box-sizing: border-box; }

    /* Header */
    .kamar-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .kamar-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }

    .kamar-head p {
        margin: 6px 0 0;
        color: var(--ink-soft);
        font-size: .95rem;
    }

    /* Buttons */
    .kamar-page .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
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

    .kamar-page .btn svg { width: 16px; height: 16px; flex: none; }

    .kamar-page .btn-primary { background: var(--teal); color: #fff; }
    .kamar-page .btn-primary:hover { background: var(--teal-dark); }

    .kamar-page .btn-ghost {
        background: var(--surface);
        border-color: var(--line);
        color: var(--ink);
    }
    .kamar-page .btn-ghost:hover { border-color: var(--teal); color: var(--teal); }

    .kamar-page .btn-danger {
        background: var(--surface);
        border-color: var(--line);
        color: var(--busy-fg);
    }
    .kamar-page .btn-danger:hover { background: var(--busy-bg); border-color: #f3b9b3; }

    .kamar-page .btn-sm { padding: 8px 12px; font-size: .84rem; border-radius: 8px; }

    .kamar-page a:focus-visible,
    .kamar-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    /* Alert */
    .kamar-alert {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        background: var(--ok-bg);
        color: var(--ok-fg);
        border: 1px solid #bde3cd;
        border-left: 4px solid var(--ok-fg);
        border-radius: 10px;
        font-weight: 500;
    }

    .kamar-alert svg { width: 20px; height: 20px; flex: none; }

    /* Table card */
    .kamar-card {
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .08);
        overflow: hidden;
    }

    .kamar-scroll { overflow-x: auto; }

    .kamar-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 720px;
    }

    .kamar-table thead th {
        padding: 14px 20px;
        background: var(--mist);
        border-bottom: 1px solid var(--line);
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .kamar-table tbody td {
        padding: 16px 20px;
        border-bottom: 1px solid var(--line);
        font-size: .93rem;
        vertical-align: middle;
    }

    .kamar-table tbody tr:last-child td { border-bottom: 0; }
    .kamar-table tbody tr:hover { background: #f3f7ff; }

    .col-no { width: 56px; color: var(--ink-soft); }
    .col-aksi { width: 1%; white-space: nowrap; }

    .kamar-nomor {
        display: inline-block;
        min-width: 52px;
        padding: 6px 12px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--teal-dark);
        font-weight: 700;
        text-align: center;
    }

    .kamar-harga { font-weight: 600; font-variant-numeric: tabular-nums; }
    .kamar-harga small { color: var(--ink-soft); font-weight: 500; }

    .kamar-fasilitas { color: var(--ink-soft); max-width: 280px; line-height: 1.45; }

    /* Status badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 600;
        background: var(--mist);
        color: var(--ink-soft);
    }

    .badge::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-tersedia,
    .badge-kosong { background: var(--ok-bg); color: var(--ok-fg); }
    .badge-terisi,
    .badge-penuh { background: var(--busy-bg); color: var(--busy-fg); }
    .badge-dibooking,
    .badge-perbaikan,
    .badge-perawatan,
    .badge-maintenance { background: var(--warn-bg); color: var(--warn-fg); }

    /* Actions */
    .kamar-actions { display: flex; gap: 8px; }
    .kamar-actions form { margin: 0; }

    /* Empty state */
    .kamar-empty {
        padding: 56px 20px;
        text-align: center;
        color: var(--ink-soft);
    }

    .kamar-empty svg { width: 44px; height: 44px; color: var(--teal); opacity: .7; margin-bottom: 12px; }
    .kamar-empty strong { display: block; margin-bottom: 4px; color: var(--ink); font-size: 1.05rem; }
    .kamar-empty .btn { margin-top: 16px; }

    @media (max-width: 600px) {
        .kamar-page { padding: 20px 14px 40px; }
        .kamar-head h1 { font-size: 1.6rem; }
    }
</style>

<div class="kamar-page">

    <div class="kamar-head">
        <div>
            <h1>Data Kamar</h1>
            <p>Kelola nomor kamar, harga, fasilitas, dan status ketersediaan.</p>
        </div>

        <a href="{{ route('kamar.create') }}" class="btn btn-primary">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round"><path d="M12 5v14M5 12h14"/></svg>
            Tambah kamar
        </a>
    </div>

    @if(session('success'))
        <div class="kamar-alert" role="status">
            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="kamar-card">
        <div class="kamar-scroll">
            <table class="kamar-table">

                <thead>
                    <tr>
                        <th class="col-no">No</th>
                        <th>Nomor kamar</th>
                        <th>Harga</th>
                        <th>Fasilitas</th>
                        <th>Status</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($kamars as $kamar)

                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td>
                                <span class="kamar-nomor">{{ $kamar->nomor_kamar }}</span>
                            </td>

                            <td class="kamar-harga">
                                Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                            </td>

                            <td class="kamar-fasilitas">
                                {{ $kamar->fasilitas ?? '-' }}
                            </td>

                            <td>
                                <span class="badge badge-{{ \Illuminate\Support\Str::slug($kamar->status) }}">
                                    {{ ucfirst($kamar->status) }}
                                </span>
                            </td>

                            <td class="col-aksi">
                                <div class="kamar-actions">

                                    <a href="{{ route('kamar.edit', $kamar->id) }}" class="btn btn-ghost btn-sm">
                                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16v4Z"/><path d="m13.5 6.5 4 4"/></svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('kamar.destroy', $kamar->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus kamar ini?')"
                                        >
                                            <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                <div class="kamar-empty">
                                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"><path d="M3 20V8a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v12M3 14h18M3 20h18M7 14v-2a2 2 0 0 1 2-2h6a2 2 0 0 1 2 2v2"/></svg>
                                    <strong>Belum ada data kamar</strong>
                                    Tambahkan kamar pertama untuk mulai mengelola ketersediaan.
                                    <br>
                                    <a href="{{ route('kamar.create') }}" class="btn btn-primary">Tambah kamar</a>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection
