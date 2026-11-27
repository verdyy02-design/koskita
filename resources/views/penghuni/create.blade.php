@extends('layouts.app')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 800px;">

    <div class="ui-head">
        <div>
            <h1>Tambah Penghuni</h1>
            <p>Tambahkan penghuni baru ke KosKita.</p>
        </div>

        <a href="{{ route('penghuni.index') }}" class="btn btn-ghost">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Kembali
        </a>
    </div>


    <div class="ui-panel ui-panel-pad">

        @if ($errors->any())
            <div class="ui-alert ui-alert-error" role="alert">
                <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
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

        <form action="{{ route('penghuni.store') }}" method="POST">
            @csrf

            <h3 class="form-section">
                <svg class="ui-icon" viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                Akun login
            </h3>

            <div class="field">
                <label for="name">Nama lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}"
                       placeholder="Contoh: Budi Santoso" required>
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="email">Email login</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}"
                           placeholder="Contoh: budi@gmail.com" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                           placeholder="Minimal 6 karakter" required>
                </div>
            </div>

            <hr class="form-divider">

            <h3 class="form-section">
                <svg class="ui-icon" viewBox="0 0 24 24"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Data penghuni
            </h3>

            <div class="form-grid">
                <div class="field">
                    <label for="nik">NIK</label>
                    <input type="text" id="nik" name="nik" value="{{ old('nik') }}"
                           maxlength="16" placeholder="Masukkan 16 digit NIK" required>
                </div>

                <div class="field">
                    <label for="no_hp">No. HP</label>
                    <input type="text" id="no_hp" name="no_hp" value="{{ old('no_hp') }}"
                           placeholder="Contoh: 081234567890" required>
                </div>
            </div>

            <div class="field">
                <label for="alamat">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3"
                          placeholder="Masukkan alamat lengkap">{{ old('alamat') }}</textarea>
            </div>

            <div class="field">
                <label for="kamar_id">Kamar</label>

                <select id="kamar_id" name="kamar_id">
                    <option value="">-- Tidak memilih kamar --</option>

                    @foreach ($kamars as $kamar)
                        <option value="{{ $kamar->id }}" {{ old('kamar_id') == $kamar->id ? 'selected' : '' }}>
                            Kamar {{ $kamar->nomor_kamar }}
                            - Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                        </option>
                    @endforeach
                </select>

                @if ($kamars->count() == 0)
                    <div class="warn">Tidak ada kamar kosong saat ini.</div>
                @endif
            </div>

            <div class="form-grid">
                <div class="field">
                    <label for="tanggal_masuk">Tanggal masuk</label>
                    <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                           value="{{ old('tanggal_masuk', date('Y-m-d')) }}" required>
                </div>

                <div class="field">
                    <label for="tanggal_keluar">Tanggal keluar <span class="opt">(opsional)</span></label>
                    <input type="date" id="tanggal_keluar" name="tanggal_keluar"
                           value="{{ old('tanggal_keluar') }}">
                </div>
            </div>

            <div class="form-actions">
                <a href="{{ route('penghuni.index') }}" class="btn btn-ghost">Batal</a>

                <button type="submit" class="btn btn-primary">Simpan penghuni</button>
            </div>

        </form>

    </div>

</div>

@endsection
