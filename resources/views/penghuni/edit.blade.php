@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 800px;">

    <div class="ui-head">
        <div>
            <h1>Edit Penghuni</h1>
            <p>Perbarui informasi penghuni KosKita.</p>
        </div>

        <a href="{{ route('penghuni.index') }}" class="btn btn-ghost">
            <svg class="ui-icon" viewBox="0 0 24 24">
                <path d="m12 19-7-7 7-7"/>
                <path d="M19 12H5"/>
            </svg>
            Kembali
        </a>
    </div>

    <div class="ui-panel ui-panel-pad">

        @if ($errors->any())
            <div class="ui-alert ui-alert-error" role="alert">
                <svg class="ui-icon" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="9"/>
                    <path d="M12 8v4"/>
                    <path d="M12 16h.01"/>
                </svg>
                <div>
                    Terjadi kesalahan:
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('penghuni.update', $penghuni->id) }}" method="POST">
            @csrf
            @method('PUT')

            <h3 class="form-section">
                <svg class="ui-icon" viewBox="0 0 24 24">
                    <rect x="3" y="11" width="18" height="11" rx="2"/>
                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                </svg>
                Akun Login
            </h3>

            <div class="field">
                <label>Nama Penghuni</label>
                <input type="text"
                       value="{{ $penghuni->user->name ?? '-' }}"
                       disabled>
            </div>

            <div class="field">
                <label>Email Login</label>
                <input type="email"
                       value="{{ $penghuni->user->email ?? '-' }}"
                       disabled>
            </div>

            <input type="hidden" name="user_id"
                   value="{{ old('user_id', $penghuni->user_id) }}">

            <hr class="form-divider">

            <h3 class="form-section">
                <svg class="ui-icon" viewBox="0 0 24 24">
                    <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                    <circle cx="9" cy="7" r="4"/>
                </svg>
                Data Penghuni
            </h3>

            <div class="form-grid">
                <div class="field">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik"
                           value="{{ old('nik', $penghuni->nik) }}"
                           maxlength="16" required>
                </div>

                <div class="field">
                    <label for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp"
                           value="{{ old('no_hp', $penghuni->no_hp) }}"
                           required>
                </div>
            </div>

            <div class="field">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3">{{ old('alamat', $penghuni->alamat) }}</textarea>
            </div>

            <div class="field">
                <label for="kamar_id">Kamar</label>

                <select id="kamar_id" name="kamar_id">
                    <option value="">-- Tidak memilih kamar --</option>

                    @foreach ($kamars as $kamar)
                        <option value="{{ $kamar->id }}"
                            {{ (string) old('kamar_id', $penghuni->kamar_id) === (string) $kamar->id ? 'selected' : '' }}>
                            Kamar {{ $kamar->nomor_kamar }}
                            - Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="tanggal_masuk">Tanggal Masuk</label>
                    <input type="date" id="tanggal_masuk"
                           name="tanggal_masuk"
                           value="{{ old('tanggal_masuk', $penghuni->tanggal_masuk ? \Carbon\Carbon::parse($penghuni->tanggal_masuk)->format('Y-m-d') : '') }}"
                           required>
                </div>

                <div class="field">
                    <label for="tanggal_keluar">
                        Tanggal Keluar <span class="opt">(opsional)</span>
                    </label>
                    <input type="date" id="tanggal_keluar"
                           name="tanggal_keluar"
                           value="{{ old('tanggal_keluar', $penghuni->tanggal_keluar ? \Carbon\Carbon::parse($penghuni->tanggal_keluar)->format('Y-m-d') : '') }}">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('penghuni.index') }}" class="btn btn-ghost">
                    Batal
                </a>

                <button type="submit" class="btn btn-primary">
                    Simpan Perubahan
                </button>
            </div>

        </form>
    </div>
</div>

@endsection
