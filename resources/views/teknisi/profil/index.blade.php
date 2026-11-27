@extends('layouts.teknisi')
@section('content')
@include('css.ui-style')

<div class="ui-page profile-page">

    <div class="ui-head">
        <div>
            <h2>Profil Saya</h2>
            <p>Kelola informasi akun Teknisi KosKita.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="profile-alert success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="profile-alert danger">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="profile-grid">

        {{-- Identitas Teknisi --}}
        <div class="profile-card profile-identity">

            <div class="profile-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h3>{{ $user->name }}</h3>
            <p class="profile-email">{{ $user->email }}</p>

            <span class="profile-role">Teknisi</span>

            <div class="profile-divider"></div>

            <div class="profile-information">
                <span>Status Akun</span>
                <strong>Aktif</strong>
            </div>

            <div class="profile-information">
                <span>Terdaftar Sejak</span>
                <strong>{{ $user->created_at->format('d M Y') }}</strong>
            </div>

        </div>

        {{-- Informasi Akun --}}
        <div class="profile-card">

            <div class="profile-form-heading">
                <h3>Informasi Akun</h3>
                <p>Perbarui nama dan alamat email akun Anda.</p>
            </div>

            <form action="{{ route('teknisi.profil.update') }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="profile-form-group">
                    <label for="name">Nama Lengkap</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name', $user->name) }}"
                        required
                        maxlength="255"
                        placeholder="Masukkan nama lengkap">
                </div>

                <div class="profile-form-group">
                    <label for="email">Alamat Email</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $user->email) }}"
                        required
                        maxlength="255"
                        placeholder="Masukkan alamat email">
                </div>

                <div class="profile-form-actions">
                    <button type="submit" class="btn btn-primary">
                        Simpan Perubahan
                    </button>
                </div>

            </form>
        </div>

        {{-- Ubah Kata Sandi --}}
        <div class="profile-card password-card">

            <div class="profile-form-heading">
                <h3>Ubah Kata Sandi</h3>
                <p>Pastikan kata sandi baru Anda sulit ditebak.</p>
            </div>

            @if(session('password_success'))
                <div class="profile-alert success">
                    {{ session('password_success') }}
                </div>
            @endif

            <form action="{{ route('teknisi.profil.password') }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="profile-form-group">
                    <label for="current_password">
                        Kata Sandi Saat Ini
                    </label>
                    <input
                        type="password"
                        id="current_password"
                        name="current_password"
                        required
                        autocomplete="current-password"
                        placeholder="Masukkan kata sandi saat ini">
                </div>

                <div class="profile-form-group">
                    <label for="password">Kata Sandi Baru</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Minimal 8 karakter">
                </div>

                <div class="profile-form-group">
                    <label for="password_confirmation">
                        Konfirmasi Kata Sandi Baru
                    </label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        required
                        minlength="8"
                        autocomplete="new-password"
                        placeholder="Ulangi kata sandi baru">
                </div>

                <div class="profile-form-actions">
                    <button type="submit" class="btn btn-primary">
                        Simpan Kata Sandi
                    </button>
                </div>

            </form>
        </div>

    </div>
</div>
@endsection
