@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 1100px;">

    <div class="ui-head">
        <div>
            <h1>Data Penghuni</h1>
            <p>Kelola data penghuni KosKita.</p>
        </div>

        <a href="{{ route('penghuni.create') }}" class="btn btn-primary">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah penghuni
        </a>
    </div>


    @if(session('success'))
        <div class="ui-alert ui-alert-success" role="status">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif


    <div class="ui-panel">
        <div class="ui-scroll">

            <table class="ui-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>NIK</th>
                        <th>No. HP</th>
                        <th>Kamar</th>
                        <th>Tanggal masuk</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($penghunis as $penghuni)

                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td class="col-strong">{{ $penghuni->user->name ?? '-' }}</td>

                            <td class="col-muted">{{ $penghuni->nik }}</td>

                            <td class="col-muted">{{ $penghuni->no_hp }}</td>

                            <td>
                                @if($penghuni->kamar)
                                    <span class="chip">{{ $penghuni->kamar->nomor_kamar }}</span>
                                @else
                                    <span class="col-muted">Belum ada kamar</span>
                                @endif
                            </td>

                            <td class="col-muted col-nowrap">
                                {{ \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('d M Y') }}
                            </td>

                            <td class="col-aksi">
                                <div class="ui-actions">

                                    <a href="{{ route('penghuni.edit', $penghuni->id) }}" class="btn btn-ghost btn-sm">
                                        <svg class="ui-icon" viewBox="0 0 24 24"><path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16v4Z"/><path d="m13.5 6.5 4 4"/></svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('penghuni.destroy', $penghuni->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm"
                                            onclick="return confirm('Yakin ingin menghapus penghuni ini?')">
                                            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="ui-empty">
                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M22 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                                    <strong>Belum ada data penghuni</strong>
                                    Tambahkan penghuni pertama untuk mulai mengelola data.
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
