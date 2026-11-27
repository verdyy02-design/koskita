@extends('layouts.penghuni')

@section('content')

<div class="profil-container">
    <div class="profil-header">
        <h1>Ganti Password 🔐</h1>
        <p>Perbarui password untuk menjaga keamanan akun Anda.</p>
    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form action="{{ route('penghuni.password.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Password Lama</label>
            <input type="password" name="password_lama"
                placeholder="Masukkan password lama" required>
        </div>

        <div class="form-group">
            <label>Password Baru</label>
            <input type="password" name="password_baru"
                placeholder="Minimal 8 karakter" required>
        </div>

        <div class="form-group">
            <label>Konfirmasi Password Baru</label>
            <input type="password" name="password_baru_confirmation"
                placeholder="Ulangi password baru" required>
        </div>

        <div class="form-actions">
            <a href="{{ route('penghuni.profil') }}" class="btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn-save">
                Simpan Password
            </button>
        </div>
    </form>
</div>

@endsection
