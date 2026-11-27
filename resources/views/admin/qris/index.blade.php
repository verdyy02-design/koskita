@extends('layouts.app')
@section('content')
@include('css.ui-style')

<style>
    .qris-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
        gap: 22px;
        align-items: start;
    }

    .card-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .card-title .ui-icon { width: 20px; height: 20px; color: var(--blue); }

    .qris-preview {
        display: grid;
        place-items: center;
        padding: 18px;
        margin-bottom: 18px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 14px;
    }

    .qris-preview img {
        display: block;
        width: 100%;
        max-width: 280px;
        height: auto;
        padding: 12px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .owner-label { color: var(--ink-soft); font-size: .82rem; font-weight: 500; }
    .owner-name { margin: 2px 0 18px; font-weight: 600; }

    .ui-alert-warn {
        background: var(--warn-bg);
        color: var(--warn-fg);
        border: 1px solid #f1dca8;
        border-left: 4px solid var(--warn-fg);
        margin-bottom: 0;
    }

    .field input[type="file"] {
        padding: 10px;
        border: 1px dashed #9db4e0;
        cursor: pointer;
    }

    .field input[type="file"]:hover { border-color: var(--blue); background: var(--mist); }

    .field input[type="file"]::file-selector-button {
        margin-right: 12px;
        padding: 8px 14px;
        background: var(--blue);
        border: 0;
        border-radius: 8px;
        color: #fff;
        font: inherit;
        font-size: .86rem;
        font-weight: 600;
        cursor: pointer;
    }

    .field input[type="file"]::file-selector-button:hover { background: var(--blue-dark); }

    @media (max-width: 900px) {
        .qris-grid { grid-template-columns: 1fr; }
    }
</style>

<div class="ui-page" style="--w: 1000px;">

    <div class="ui-head">
        <div>
            <h1>Pengaturan QRIS</h1>
            <p>Kelola QRIS yang akan ditampilkan pada halaman pembayaran penghuni.</p>
        </div>
    </div>


    @if(session('success'))
        <div class="ui-alert ui-alert-success" role="status">
            <svg class="ui-icon" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path d="m8 12.5 2.8 2.8L16 9.5"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

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


    <div class="qris-grid">

        <!-- QRIS AKTIF -->
        <div class="ui-panel ui-panel-pad">

            <h2 class="card-title">
                <svg class="ui-icon" viewBox="0 0 24 24"><rect x="3" y="3" width="5" height="5" rx="1"/><rect x="16" y="3" width="5" height="5" rx="1"/><rect x="3" y="16" width="5" height="5" rx="1"/><path d="M21 16h-3a2 2 0 0 0-2 2v3"/><path d="M21 21v.01"/><path d="M12 7v3a2 2 0 0 1-2 2H7"/><path d="M3 12h.01"/><path d="M12 3h.01"/><path d="M12 16v.01"/><path d="M16 12h1"/><path d="M21 12v.01"/><path d="M12 21v-1"/></svg>
                QRIS aktif
            </h2>

            @if($qris && $qris->gambar_qris)

                <div class="qris-preview">
                    <img
                        src="{{ asset('storage/' . $qris->gambar_qris) }}"
                        alt="QRIS KosKita"
                    >
                </div>

                <div class="owner-label">Nama pemilik</div>
                <p class="owner-name">{{ $qris->nama_pemilik ?? '-' }}</p>

                <form action="{{ route('admin.qris.destroy') }}"
                      method="POST"
                      onsubmit="return confirm('Yakin ingin menghapus QRIS ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-danger">
                        <svg class="ui-icon" viewBox="0 0 24 24"><path d="M4 7h16M10 11v6M14 11v6M6 7l1 12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2l1-12M9 7V4h6v3"/></svg>
                        Hapus QRIS
                    </button>
                </form>

            @else

                <div class="ui-alert ui-alert-warn" role="status">
                    <svg class="ui-icon" viewBox="0 0 24 24"><path d="M10.3 3.9 1.8 18a2 2 0 0 0 1.7 3h17a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0z"/><path d="M12 9v4"/><path d="M12 17h.01"/></svg>
                    <div>Belum ada gambar QRIS yang diunggah.</div>
                </div>

            @endif

        </div>


        <!-- UPLOAD / GANTI -->
        <div class="ui-panel ui-panel-pad">

            <h2 class="card-title">
                <svg class="ui-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m17 8-5-5-5 5"/><path d="M12 3v12"/></svg>
                {{ $qris && $qris->gambar_qris ? 'Ganti QRIS' : 'Upload QRIS' }}
            </h2>

            <form action="{{ route('admin.qris.update') }}"
                  method="POST"
                  enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="nama_pemilik">Nama pemilik QRIS</label>
                    <input
                        type="text"
                        id="nama_pemilik"
                        name="nama_pemilik"
                        value="{{ old('nama_pemilik', $qris->nama_pemilik ?? '') }}"
                        placeholder="Masukkan nama pemilik"
                    >
                </div>

                <div class="field">
                    <label for="gambar_qris">Gambar QRIS</label>
                    <input
                        type="file"
                        id="gambar_qris"
                        name="gambar_qris"
                        accept="image/png,image/jpeg"
                    >
                    <div class="hint">
                        Format JPG, JPEG, PNG. Maksimal 2 MB.
                        Kosongkan jika hanya ingin mengubah nama pemilik.
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">
                        Simpan pengaturan QRIS
                    </button>
                </div>
            </form>

        </div>

    </div>

</div>

@endsection
