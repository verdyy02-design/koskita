@extends('layouts.app')

@section('content')

@include('kamar.form-style')

<div class="kamar-page">

    <div class="kamar-head">
        <h1>Edit Kamar</h1>
        <p>Perbarui data kamar {{ $kamar->nomor_kamar }}.</p>
    </div>

    <div class="kamar-card">
        <form action="{{ route('kamar.update', $kamar->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="field @error('nomor_kamar') has-error @enderror">
                <label for="nomor_kamar">Nomor kamar</label>
                <input type="text" id="nomor_kamar" name="nomor_kamar"
                       value="{{ old('nomor_kamar', $kamar->nomor_kamar) }}" required>
                @error('nomor_kamar') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field @error('harga') has-error @enderror">
                <label for="harga">Harga</label>
                <div class="input-prefix">
                    <span>Rp</span>
                    <input type="number" id="harga" name="harga" min="0"
                           value="{{ old('harga', $kamar->harga) }}" required>
                </div>
                @error('harga') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field @error('fasilitas') has-error @enderror">
                <label for="fasilitas">Fasilitas</label>
                <textarea id="fasilitas" name="fasilitas">{{ old('fasilitas', $kamar->fasilitas) }}</textarea>
                <div class="hint">Contoh: AC, kamar mandi dalam, WiFi.</div>
                @error('fasilitas') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="field @error('status') has-error @enderror">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    @foreach(['kosong' => 'Kosong', 'terisi' => 'Terisi', 'perbaikan' => 'Perbaikan'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('status', $kamar->status) === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('status') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan perubahan</button>
                <a href="{{ route('kamar.index') }}" class="btn btn-ghost">Batal</a>
            </div>
        </form>
    </div>

</div>

@endsection
