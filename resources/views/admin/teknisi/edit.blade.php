@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 800px;">

    <div class="ui-head">
        <div>
            <h1>Edit Teknisi</h1>
            <p>Perbarui informasi akun teknisi KosKita.</p>
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

    <form action="{{ route('teknisi.update', $teknisi->id) }}"
          method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text"
                   name="name"
                   class="form-control"
                   value="{{ old('name', $teknisi->name) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $teknisi->email) }}"
                   required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password"
                   name="password"
                   class="form-control"
                   placeholder="Kosongkan jika tidak ingin mengganti password">
        </div>

        <button type="submit" class="btn btn-primary">
            Simpan Perubahan
        </button>

        <a href="{{ route('teknisi.index') }}" class="btn btn-danger">
            Batal
        </a>

    </form>

</div>

@endsection
