@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 1100px;">

    <div class="ui-head">
        <div>
            <h1>Data Teknisi</h1>
            <p>Kelola akun teknisi KosKita.</p>
        </div>

        <a href="{{ route('teknisi.create') }}" class="btn btn-primary">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M12 5v14M5 12h14"/></svg>
            Tambah teknisi
        </a>
    </div>


    @if(session('success'))
        <div class="ui-alert ui-alert-success" role="status">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="ui-alert ui-alert-error" role="alert">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
            <div>{{ $errors->first() }}</div>
        </div>
    @endif


    <div class="ui-panel">
        <div class="ui-scroll">

            <table class="ui-table">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama teknisi</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th>Tanggal bergabung</th>
                        <th class="col-aksi">Aksi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($teknisis as $teknisi)

                        <tr>
                            <td class="col-no">{{ $loop->iteration }}</td>

                            <td class="col-strong">{{ $teknisi->name }}</td>

                            <td class="col-muted">{{ $teknisi->email }}</td>

                            <td><span class="badge badge-info">Teknisi</span></td>

                            <td class="col-muted col-nowrap">
                                {{ $teknisi->created_at->format('d-m-Y') }}
                            </td>

                            <td class="col-aksi">
                                <div class="ui-actions">

                                    <a href="{{ route('teknisi.edit', $teknisi->id) }}" class="btn btn-ghost btn-sm">
                                        <svg class="ui-icon" viewBox="0 0 24 24"><path d="M4 20h4L19 9a2.8 2.8 0 0 0-4-4L4 16v4Z"/><path d="m13.5 6.5 4 4"/></svg>
                                        Edit
                                    </a>

                                    <form action="{{ route('teknisi.destroy', $teknisi->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus akun teknisi ini?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger btn-sm">
                                            <svg class="ui-icon" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                <div class="ui-empty">
                                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                                    <strong>Belum ada akun teknisi</strong>
                                    Tambahkan teknisi pertama untuk menangani keluhan penghuni.
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
