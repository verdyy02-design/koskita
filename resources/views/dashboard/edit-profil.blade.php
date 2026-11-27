@extends('layouts.penghuni')

@section('content')

<div class="profil-container">
    <div class="profil-header">
        <h1>Edit Profil</h1>
        <p>Perbarui informasi pribadi akun Anda.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('penghuni.profil.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input type="text" name="name"
                value="{{ old('name', $penghuni->user->name) }}"
                required>
        </div>

        <div class="form-group">
            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email', $penghuni->user->email) }}"
                required>
        </div>

        <div class="form-group">
            <label>Nomor HP</label>
            <input type="text" name="no_hp"
                value="{{ old('no_hp', $penghuni->no_hp) }}"
                required>
        </div>

        <div class="form-group">
            <label>Alamat</label>
            <textarea name="alamat" rows="4">{{ old('alamat', $penghuni->alamat) }}</textarea>
        </div>

        <div class="form-actions">
            <a href="{{ route('penghuni.profil') }}" class="btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn-save">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>

@endsection
