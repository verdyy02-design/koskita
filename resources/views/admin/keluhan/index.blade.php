@extends('layouts.app')
@section('content')
@include('css.ui-style')

<style>
    .ui-table.table-wide { min-width: 1060px; }

    .judul-cell { min-width: 220px; }
    .judul-cell .judul { font-weight: 600; }
    .judul-cell .desk {
        margin-top: 3px;
        color: var(--ink-soft);
        font-size: .84rem;
        line-height: 1.45;
    }

    .assign-form { display: flex; gap: 8px; align-items: center; min-width: 290px; }
    .assign-form select {
        flex: 1;
        min-width: 0;
        padding: 8px 10px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--ink);
        font: inherit;
        font-size: .88rem;
    }

    .assign-form select:focus {
        outline: none;
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
    }
</style>

<div class="ui-page" style="--w: 1240px;">

    <div class="ui-head">
        <div>
            <h1>Data Keluhan</h1>
            <p>Kelola laporan kerusakan dan masalah dari penghuni KosKita.</p>
        </div>

        <span class="tag">Total {{ $keluhans->count() }} laporan</span>
    </div>


    @if(session('success'))
        <div class="ui-alert ui-alert-success" role="status">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if(session('error'))
        <div class="ui-alert ui-alert-error" role="alert">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            <div>{{ session('error') }}</div>
        </div>
    @endif


    <div class="ui-panel">
        <div class="ui-scroll">

            <table class="ui-table table-wide">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Keluhan</th>
                        <th>Kategori</th>
                        <th>Teknisi</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Tugaskan teknisi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($keluhans as $keluhan)

                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td class="col-strong">
                                {{ $keluhan->penghuni?->user?->name ?? 'Tidak diketahui' }}
                            </td>

                            <td>
                                @if($keluhan->kamar?->nomor_kamar)
                                    <span class="chip">{{ $keluhan->kamar->nomor_kamar }}</span>
                                @else
                                    <span class="col-muted">-</span>
                                @endif
                            </td>

                            <td class="judul-cell">
                                <div class="judul">{{ $keluhan->judul }}</div>

                                @if($keluhan->deskripsi)
                                    <div class="desk">{{ \Illuminate\Support\Str::limit($keluhan->deskripsi, 70) }}</div>
                                @endif
                            </td>

                            <td><span class="tag">{{ $keluhan->kategori }}</span></td>

                            <td>
                                @if($keluhan->teknisi)
                                    {{ $keluhan->teknisi->name }}
                                @else
                                    <span class="col-muted">Belum ditugaskan</span>
                                @endif
                            </td>

                            <td>
                                @if($keluhan->status == 'menunggu')
                                    <span class="badge badge-warn">Menunggu</span>
                                @elseif($keluhan->status == 'diproses')
                                    <span class="badge badge-info">Diproses</span>
                                @elseif($keluhan->status == 'selesai')
                                    <span class="badge badge-ok">Selesai</span>
                                @else
                                    <span class="badge badge-slate">{{ ucfirst($keluhan->status) }}</span>
                                @endif
                            </td>

                            <td class="col-muted col-nowrap">
                                {{ $keluhan->created_at->format('d/m/Y') }}
                            </td>

                            <td>
                                <form action="{{ route('admin.keluhan.assign', $keluhan->id) }}"
                                      method="POST"
                                      class="assign-form">

                                    @csrf

                                    <select name="teknisi_id" required aria-label="Pilih teknisi">
                                        <option value="">Pilih teknisi</option>

                                        @foreach($teknisis as $teknisi)
                                            <option value="{{ $teknisi->id }}"
                                                {{ $keluhan->teknisi_id == $teknisi->id ? 'selected' : '' }}>
                                                {{ $teknisi->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        {{ $keluhan->teknisi_id ? 'Ubah' : 'Tugaskan' }}
                                    </button>

                                </form>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="9">
                                <div class="ui-empty">
                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
                                    <strong>Belum ada keluhan</strong>
                                    Laporan dari penghuni akan muncul di sini.
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
