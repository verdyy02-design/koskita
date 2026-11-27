@extends('layouts.teknisi')
@section('title', 'Tugas Saya')
@section('content')
@include('css.ui-style')


<div class="ui-page" style="--w: 1000px;">

    <div class="ui-head">
        <h1 class="page-title">Daftar Tugas Keluhan</h1>
        <p class="page-subtitle">
        Kelola dan selesaikan keluhan penghuni yang ditugaskan kepada Anda.
        </p>
    </div>

    @if(session('success'))
        <div class="ui-alert ui-alert-success" role="status">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger" style="margin-top:20px;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="ui-panel">
        <div class="ui-scroll">

            <table class="ui-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Penghuni</th>
                        <th>Kamar</th>
                        <th>Judul Keluhan</th>
                        <th>Kategori</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($keluhans as $keluhan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $keluhan->penghuni->user->name ?? '-' }}
                            </td>

                            <td>
                                {{ $keluhan->kamar->nomor_kamar ?? '-' }}
                            </td>

                            <td>{{ $keluhan->judul }}</td>

                            <td>{{ $keluhan->kategori }}</td>

                            <td>{{ $keluhan->deskripsi }}</td>

                            <td>
                                {{ ucfirst($keluhan->status) }}
                            </td>

                            <td style="min-width:150px;">
                                <form action="{{ route('teknisi.tugas.status', $keluhan->id) }}"
                                      method="POST">
                                    @csrf
                                    @method('PUT')

                                    <select name="status" class="form-control" required>
                                        <option value="diproses"
                                            {{ $keluhan->status == 'diproses' ? 'selected' : '' }}>
                                            Diproses
                                        </option>

                                        <option value="selesai"
                                            {{ $keluhan->status == 'selesai' ? 'selected' : '' }}>
                                            Selesai
                                        </option>
                                    </select>

                                    <button type="submit"
                                            class="btn btn-primary"
                                            style="margin-top:8px; width:100%;">
                                        Update Status
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;">
                                Belum ada tugas keluhan yang ditugaskan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
@endsection