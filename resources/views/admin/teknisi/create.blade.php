@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 800px;">

    <div class="ui-head">
        <div>
            <h1>Tambah Teknisi</h1>
            <p>Tambahkan akun teknisi baru KosKita.</p>
        </div>

        <a href="{{ route('teknisi.index') }}" class="btn btn-ghost">
            <svg class="ui-icon" viewBox="0 0 24 24">
                <path d="m12 19-7-7 7-7"/>
                <path d="M19 12H5"/>
            </svg>
            Kembali
        </a>
    </div>

<div class="card">

    @if($errors->any())
        <div class="alert alert-danger">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('teknisi.store') }}" method="POST">
        @csrf

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name" class="form-control"
                   value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email" class="form-control"
                   value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label>Password</label>
            <input type="password" name="password"
                   class="form-control" required minlength="8">
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Teknisi
        </button>

        <a href="{{ route('teknisi.index') }}" class="btn btn-danger">
            Batal
        </a>
    </form>

</div>

@endsection
