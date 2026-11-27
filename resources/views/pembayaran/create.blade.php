@extends('layouts.app')
@section('content')
@include('css.ui-style')

<style>
    .input-prefix { position: relative; }
    .input-prefix span {
        position: absolute;
        left: 14px;
        top: 50%;
        transform: translateY(-50%);
        color: var(--ink-soft);
        font-size: .95rem;
        font-weight: 600;
    }
    .input-prefix input { padding-left: 44px; }

    .info-note {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        background: var(--info-bg);
        color: var(--info-fg);
        border: 1px solid #bfd1f8;
        border-left: 4px solid var(--blue);
        border-radius: 10px;
        font-size: .9rem;
        line-height: 1.55;
    }

    .info-note .ui-icon { width: 20px; height: 20px; margin-top: 1px; }
    .info-note strong { font-weight: 700; }
</style>

<div class="ui-page" style="--w: 760px;">

    <div class="ui-head">
        <div>
            <h1>Buat Tagihan Pembayaran</h1>
            <p>Buat tagihan baru untuk penghuni.</p>
        </div>

        <a href="{{ route('pembayaran.index') }}" class="btn btn-ghost">
            <svg class="ui-icon" viewBox="0 0 24 24"><path d="m12 19-7-7 7-7"/><path d="M19 12H5"/></svg>
            Kembali
        </a>
    </div>


    <div class="ui-panel ui-panel-pad">

        @if($errors->any())
            <div class="ui-alert ui-alert-error" role="alert">
                <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="M12 8v4"/><path d="M12 16h.01"/></svg>
                <div>
                    Terjadi kesalahan:
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif


        <form action="{{ route('pembayaran.store') }}" method="POST">

            @csrf

            {{-- Penghuni --}}
            <div class="field">
                <label for="penghuni_id">Penghuni</label>

                <select id="penghuni_id" name="penghuni_id" required>
                    <option value="">-- Pilih penghuni --</option>

                    @foreach($penghunis as $penghuni)
                        <option value="{{ $penghuni->id }}"
                            {{ old('penghuni_id') == $penghuni->id ? 'selected' : '' }}>
                            {{ $penghuni->user->name ?? '-' }}
                            - Kamar {{ $penghuni->kamar->nomor_kamar ?? '-' }}
                        </option>
                    @endforeach
                </select>
            </div>


            <div class="form-grid">

                {{-- Bulan --}}
                <div class="field">
                    <label for="bulan">Bulan tagihan</label>
                    <input type="text" id="bulan" name="bulan"
                           placeholder="Contoh: Oktober 2026"
                           value="{{ old('bulan') }}" required>
                </div>

                {{-- Jatuh tempo --}}
                <div class="field">
                    <label for="tanggal_jatuh_tempo">Tanggal jatuh tempo</label>
                    <input type="date" id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo"
                           value="{{ old('tanggal_jatuh_tempo') }}" required>
                </div>

            </div>


            {{-- Jumlah --}}
            <div class="field">
                <label for="jumlah">Jumlah pembayaran</label>

                <div class="input-prefix">
                    <span>Rp</span>
                    <input type="number" id="jumlah" name="jumlah"
                           placeholder="Contoh: 800000"
                           value="{{ old('jumlah') }}" min="0" required>
                </div>
            </div>


            {{-- Keterangan --}}
            <div class="field">
                <label for="keterangan">Keterangan <span class="opt">(opsional)</span></label>
                <textarea id="keterangan" name="keterangan" rows="3"
                          placeholder="Contoh: Pembayaran kos bulan Oktober">{{ old('keterangan') }}</textarea>
            </div>


            {{-- Informasi --}}
            <div class="info-note">
                <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                <div>
                    <strong>Informasi:</strong>
                    Tagihan baru akan otomatis berstatus Belum Lunas.
                    Status akan diperbarui setelah admin memverifikasi bukti pembayaran penghuni.
                </div>
            </div>


            <div class="form-actions">
                <a href="{{ route('pembayaran.index') }}" class="btn btn-ghost">Batal</a>

                <button type="submit" class="btn btn-primary">Simpan tagihan</button>
            </div>

        </form>

    </div>

</div>

@endsection
