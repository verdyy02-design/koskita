@extends('layouts.penghuni')
@section('content')
@include('css.ui-style')

<div class="ui-page" style="--w: 760px;">

    <div class="ui-head">
        <div>
            <h1>Buat Keluhan</h1>
            <p>Sampaikan masalah atau kerusakan yang terjadi di kos.</p>
        </div>
    </div>


    <div class="ui-panel ui-panel-pad">

        @if($errors->any())
            <div class="ui-alert ui-alert-error" role="alert">
                <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                <div>
                    <ul style="margin-top: 0;">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <form action="{{ route('penghuni.keluhan.store') }}" method="POST">
            @csrf

            <div class="field">
                <label for="judul">Judul keluhan</label>
                <input type="text" id="judul" name="judul" value="{{ old('judul') }}"
                       placeholder="Contoh: AC kamar tidak dingin" required>
            </div>

            <div class="field">
                <label for="kategori">Kategori keluhan</label>
                <select id="kategori" name="kategori" required>
                    <option value="">-- Pilih kategori --</option>
                    @foreach(['Listrik', 'Air', 'AC', 'Fasilitas Kamar', 'Kebersihan', 'Lainnya'] as $kategori)
                        <option value="{{ $kategori }}" {{ old('kategori') == $kategori ? 'selected' : '' }}>
                            {{ $kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="field">
                <label for="deskripsi">Deskripsi keluhan</label>
                <textarea id="deskripsi" name="deskripsi" rows="5"
                          placeholder="Jelaskan masalah yang kamu alami..." required>{{ old('deskripsi') }}</textarea>
                <div class="hint">Sebutkan lokasi dan sejak kapan masalah terjadi supaya teknisi lebih mudah menangani.</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('penghuni.keluhan') }}" class="btn btn-ghost">Batal</a>

                <button type="submit" class="btn btn-primary">Kirim keluhan</button>
            </div>

        </form>

    </div>

</div>

@endsection
