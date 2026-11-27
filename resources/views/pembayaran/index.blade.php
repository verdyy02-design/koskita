@extends('layouts.app')
@section('content')
@include('css.ui-style')

<style>
    .ui-table.table-wide { min-width: 1080px; }

    .ui-page .btn-ok { background: var(--ok-bg); border-color: #bde3cd; color: var(--ok-fg); }
    .ui-page .btn-ok:hover { background: #cdeedb; }

    .aksi-stack { display: flex; gap: 8px; }
    .aksi-stack form { margin: 0; }

    .amount { font-weight: 700; font-variant-numeric: tabular-nums; white-space: nowrap; }
</style>

<div class="ui-page" style="--w: 1240px;">

    <div class="ui-head">
        <div>
            <h1>Data Pembayaran</h1>
            <p>Kelola tagihan pembayaran penghuni KosKita.</p>
        </div>

        <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Buat tagihan
        </a>

    </div>


    {{-- ALERT --}}
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


    {{-- TABLE CARD --}}
    <div class="ui-panel">

        @if($pembayarans->count() > 0)

            <div class="ui-scroll">

                <table class="ui-table table-wide">

                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Penghuni</th>
                            <th>Kamar</th>
                            <th>Bulan</th>
                            <th>Jumlah</th>
                            <th>Jatuh tempo</th>
                            <th>Status</th>
                            <th>Tanggal bayar</th>
                            <th>Bukti transfer</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pembayarans as $pembayaran)

                            <tr>

                                <td class="col-no">{{ $loop->iteration }}</td>

                                <td class="col-strong">
                                    {{ $pembayaran->penghuni->user->name ?? '-' }}
                                </td>

                                <td>
                                    @if(optional($pembayaran->penghuni?->kamar)->nomor_kamar)
                                        <span class="chip">{{ $pembayaran->penghuni->kamar->nomor_kamar }}</span>
                                    @else
                                        <span class="col-muted">-</span>
                                    @endif
                                </td>

                                <td>{{ $pembayaran->bulan }}</td>

                                <td class="amount">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </td>

                                <td class="col-muted col-nowrap">
                                    {{ $pembayaran->tanggal_jatuh_tempo?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    @if($pembayaran->status === 'lunas')
                                        <span class="badge badge-ok">Lunas</span>
                                    @elseif($pembayaran->status === 'menunggu_verifikasi')
                                        <span class="badge badge-warn">Menunggu verifikasi</span>
                                    @elseif($pembayaran->status === 'ditolak')
                                        <span class="badge badge-busy">Ditolak</span>
                                    @else
                                        <span class="badge badge-slate">Belum lunas</span>
                                    @endif
                                </td>

                                <td class="col-muted col-nowrap">
                                    {{ $pembayaran->tanggal_bayar?->format('d/m/Y') ?? '-' }}
                                </td>

                                <td>
                                    @if($pembayaran->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}"
                                           target="_blank"
                                           class="btn btn-ghost btn-sm">
                                            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                                            Lihat bukti
                                        </a>
                                    @else
                                        <span class="col-muted">Belum ada bukti</span>
                                    @endif
                                </td>

                                <td class="col-aksi">
                                    @if($pembayaran->status === 'menunggu_verifikasi')

                                        <div class="aksi-stack">

                                            <form action="{{ route('pembayaran.approve', $pembayaran->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Terima pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-ok btn-sm">
                                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="m5 12 5 5L20 7"/></svg>
                                                    Terima
                                                </button>
                                            </form>

                                            <form action="{{ route('pembayaran.reject', $pembayaran->id) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Tolak bukti pembayaran ini?')">
                                                @csrf
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
                                                    Tolak
                                                </button>
                                            </form>

                                        </div>

                                    @elseif($pembayaran->status === 'lunas')

                                        <span class="col-muted">Terverifikasi</span>

                                    @elseif($pembayaran->status === 'ditolak')

                                        <span class="col-muted">Ditolak</span>

                                    @else

                                        <span class="col-muted">Belum ada bukti</span>

                                    @endif
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            {{-- EMPTY STATE --}}
            <div class="ui-empty">

                <svg class="ui-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>

                <strong>Belum ada data pembayaran</strong>

                Silakan buat tagihan pembayaran baru.

                <div style="margin-top: 16px;">
                    <a href="{{ route('pembayaran.create') }}" class="btn btn-primary">
                        <svg class="ui-icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
                        Buat tagihan
                    </a>
                </div>

            </div>

        @endif

    </div>

</div>

@endsection
