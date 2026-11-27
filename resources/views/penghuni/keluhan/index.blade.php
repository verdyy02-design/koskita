@extends('layouts.penghuni')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 1000px;">

    <div class="ui-head">
        <div>
            <h1>Keluhan Saya</h1>
            <p>Pantau laporan kerusakan atau masalah kos Anda.</p>
        </div>

        <a href="{{ route('penghuni.keluhan.create') }}" class="btn btn-primary">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Buat keluhan
        </a>
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

            <table class="ui-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($keluhans as $keluhan)

                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td class="col-strong">{{ $keluhan->judul }}</td>

                            <td><span class="tag">{{ $keluhan->kategori }}</span></td>

                            <td class="col-muted col-nowrap">{{ $keluhan->created_at->format('d/m/Y') }}</td>

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
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5">
                                <div class="ui-empty">
                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/><path d="M12 7v4"/><path d="M12 14h.01"/></svg>
                                    <strong>Belum ada keluhan</strong>
                                    Keluhan yang kamu kirim akan muncul di sini.
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
