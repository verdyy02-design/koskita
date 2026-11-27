@extends('layouts.penghuni')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .pb-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --busy-bg: #fde4e1;
        --busy-fg: #a3281c;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 720px) / 2)) 56px;
    }

    .pb-page * { box-sizing: border-box; }

    .pb-icon {
        width: 20px;
        height: 20px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    .pb-head { margin-bottom: 24px; }
    .pb-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }
    .pb-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    .panel {
        margin-bottom: 20px;
        padding: 26px;
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    .panel-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 4px;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .panel-title .pb-icon { color: var(--blue); }
    .panel-sub { margin: 0 0 18px; color: var(--ink-soft); font-size: .9rem; }

    /* Alert error */
    .pb-alert {
        margin-bottom: 20px;
        padding: 14px 16px;
        background: var(--busy-bg);
        color: var(--busy-fg);
        border: 1px solid #f3b9b3;
        border-left: 4px solid var(--busy-fg);
        border-radius: 10px;
        font-size: .92rem;
        font-weight: 500;
    }

    .pb-alert div + div { margin-top: 4px; }

    /* Detail tagihan */
    .detail-list { margin: 14px 0 0; }

    .detail-row {
        display: flex;
        justify-content: space-between;
        align-items: baseline;
        gap: 16px;
        padding: 13px 0;
        border-bottom: 1px solid var(--line);
    }

    .detail-row:last-child { border-bottom: 0; padding-bottom: 0; }
    .detail-row dt { color: var(--ink-soft); font-size: .9rem; }
    .detail-row dd { margin: 0; font-weight: 600; text-align: right; }

    .amount {
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        color: var(--blue);
        font-variant-numeric: tabular-nums;
    }

    /* Info DANA */
    .transfer-box {
        padding: 18px 20px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 12px;
    }

    .transfer-label { color: var(--ink-soft); font-size: .84rem; font-weight: 500; }

    .transfer-number-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        margin: 4px 0 14px;
    }

    .transfer-number {
        margin: 0;
        font-size: 1.6rem;
        font-weight: 700;
        letter-spacing: .02em;
        font-variant-numeric: tabular-nums;
    }

    .transfer-name { margin: 2px 0 0; font-weight: 600; }

    .transfer-note { margin: 16px 0 0; color: var(--ink-soft); font-size: .9rem; }

    /* Form */
    .field { margin-bottom: 20px; }
    .field label { display: block; margin-bottom: 8px; font-size: .9rem; font-weight: 600; }
    .field .hint { margin-top: 6px; color: var(--ink-soft); font-size: .82rem; }

    .field input[type="file"] {
        width: 100%;
        padding: 10px;
        background: var(--card);
        border: 1px dashed #9db4e0;
        border-radius: 10px;
        color: var(--ink);
        font: inherit;
        font-size: .92rem;
        cursor: pointer;
        transition: border-color .15s, background-color .15s;
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

    .form-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }

    .pb-page .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 11px 18px;
        border: 1px solid transparent;
        border-radius: 10px;
        font: inherit;
        font-size: .92rem;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        cursor: pointer;
        transition: background-color .15s, border-color .15s, color .15s;
    }

    .pb-page .btn .pb-icon { width: 16px; height: 16px; }
    .pb-page .btn-primary { background: var(--blue); color: #fff; }
    .pb-page .btn-primary:hover { background: var(--blue-dark); }
    .pb-page .btn-ghost { background: var(--card); border-color: var(--line); color: var(--ink); }
    .pb-page .btn-ghost:hover { border-color: var(--blue); color: var(--blue); }

    .pb-page a:focus-visible,
    .pb-page button:focus-visible,
    .pb-page input:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    @media (max-width: 600px) {
        .pb-page { padding: 20px 14px 40px; }
        .pb-head h1 { font-size: 1.6rem; }
        .panel { padding: 20px; }
    }
</style>

<div class="pb-page">

    <div class="pb-head">
        <h1>Pembayaran Tagihan Kos</h1>
        <p>Silakan transfer sesuai nominal tagihan berikut.</p>
    </div>


    @if($errors->any())
        <div class="pb-alert" role="alert">
            @foreach($errors->all() as $error)
                <div>{{ $error }}</div>
            @endforeach
        </div>
    @endif


    <!-- DETAIL TAGIHAN -->
    <div class="panel">

        <h2 class="panel-title">
            <svg class="pb-icon" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><path d="M14 2v6h6"/><path d="M16 13H8"/><path d="M16 17H8"/><path d="M10 9H8"/></svg>
            Detail tagihan
        </h2>

        <dl class="detail-list">

            <div class="detail-row">
                <dt>Periode</dt>
                <dd>{{ $pembayaran->bulan ?? $pembayaran->periode }}</dd>
            </div>

            <div class="detail-row">
                <dt>Jumlah</dt>
                <dd class="amount">Rp{{ number_format($pembayaran->jumlah, 0, ',', '.') }}</dd>
            </div>

            <div class="detail-row">
                <dt>Jatuh tempo</dt>
                <dd>{{ $pembayaran->tanggal_jatuh_tempo?->format('d-m-Y') ?? '-' }}</dd>
            </div>

        </dl>

    </div>


    <!-- INFORMASI TRANSFER DANA -->
    <div class="panel">

        <h2 class="panel-title">
            <svg class="pb-icon" viewBox="0 0 24 24"><path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/></svg>
            Informasi transfer DANA
        </h2>
        <p class="panel-sub">Silakan transfer ke akun DANA berikut.</p>

        <div class="transfer-box">

            <div class="transfer-label">Nomor DANA</div>

            <div class="transfer-number-row">
                <p class="transfer-number" id="nomorDana">082250746645</p>

                <button type="button" class="btn btn-ghost" id="salinNomor">
                    <svg class="pb-icon" viewBox="0 0 24 24"><rect x="9" y="9" width="13" height="13" rx="2"/><path d="M5 15H4a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2h9a2 2 0 0 1 2 2v1"/></svg>
                    <span>Salin nomor</span>
                </button>
            </div>

            <div class="transfer-label">Nama pemilik</div>
            <p class="transfer-name">Muhammad Vierdian Aguina</p>

        </div>

        <p class="transfer-note">
            Pastikan nominal transfer sesuai dengan jumlah tagihan.
        </p>

    </div>


    <!-- UPLOAD BUKTI -->
    <div class="panel">

        <h2 class="panel-title">
            <svg class="pb-icon" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><path d="m17 8-5-5-5 5"/><path d="M12 3v12"/></svg>
            Upload bukti transfer
        </h2>
        <p class="panel-sub">Kirim foto bukti supaya pembayaran bisa diverifikasi.</p>

        <form
            action="{{ route('penghuni.pembayaran.bukti', $pembayaran->id) }}"
            method="POST"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="field">
                <label for="bukti_pembayaran">Foto bukti transfer</label>

                <input
                    type="file"
                    id="bukti_pembayaran"
                    name="bukti_pembayaran"
                    accept="image/jpeg,image/png"
                    required
                >

                <div class="hint">Format JPG atau PNG, maksimal 2 MB.</div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    Kirim bukti pembayaran
                </button>

                <a href="{{ route('penghuni.pembayaran') }}" class="btn btn-ghost">
                    Kembali
                </a>
            </div>

        </form>

    </div>

</div>

<script>
    (function () {
        var tombol = document.getElementById('salinNomor');
        var nomor = document.getElementById('nomorDana');
        if (!tombol || !nomor || !navigator.clipboard) return;

        tombol.addEventListener('click', function () {
            navigator.clipboard.writeText(nomor.textContent.trim()).then(function () {
                var label = tombol.querySelector('span');
                label.textContent = 'Tersalin';
                setTimeout(function () { label.textContent = 'Salin nomor'; }, 1800);
            });
        });
    })();
</script>

@endsection
