<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - KosKita</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<noscript><link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap"></noscript>

    <style>
        :root {
            /* Ganti --accent untuk mengubah warna utama (contoh ungu: #7c3aed) */
            --accent: #2563eb;
            --accent-dark: #1d4ed8;
            --accent-soft: #8fb0ff;
            --bg-top: #0b1230;
            --bg-bottom: #05070f;
            --field: #0f1426;
            --field-line: rgba(255, 255, 255, .08);
            --text: #f1f5ff;
            --muted: #8b95b0;
            --error-bg: rgba(239, 68, 68, .12);
            --error-line: rgba(239, 68, 68, .4);
            --error-fg: #fca5a5;
        }

        * { box-sizing: border-box; }

        html, body { height: 100%; margin: 0; }

        body {
            position: relative;
            display: grid;
            place-items: center;
            min-height: 100vh;
            min-height: 100dvh;
            padding: 32px 20px;
            overflow-x: hidden;
            font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
            color: var(--text);
            background:
                radial-gradient(900px 520px at 50% -8%, rgba(37, 99, 235, .55), transparent 70%),
                linear-gradient(180deg, var(--bg-top), var(--bg-bottom) 70%);
            background-color: var(--bg-bottom);
        }

        /* Lingkaran dekoratif di belakang logo */
        .rings {
            position: fixed;
            top: -260px;
            left: 50%;
            width: 0;
            height: 0;
            pointer-events: none;
        }

        .rings span {
            position: absolute;
            top: 50%;
            left: 50%;
            border: 1px solid rgba(255, 255, 255, .06);
            border-radius: 50%;
            transform: translate(-50%, -50%);
        }

        .rings span:nth-child(1) { width: 560px; height: 560px; }
        .rings span:nth-child(2) { width: 820px; height: 820px; }
        .rings span:nth-child(3) { width: 1080px; height: 1080px; }

        .login {
            position: relative;
            width: 100%;
            max-width: 420px;
        }

        /* Logo */
        .brand {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 28px;
            color: var(--accent-soft);
            font-size: 1.7rem;
            font-weight: 700;
            letter-spacing: -0.02em;
        }

        .brand svg {
            width: 34px;
            height: 34px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.7;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .heading { margin-bottom: 30px; text-align: center; }

        .heading h1 {
            margin: 0 0 8px;
            font-size: 1.6rem;
            font-weight: 600;
            letter-spacing: -0.01em;
        }

        .heading p {
            margin: 0 auto;
            max-width: 300px;
            color: var(--muted);
            font-size: .9rem;
            line-height: 1.55;
        }

        /* Error */
        .error-box {
            margin-bottom: 20px;
            padding: 13px 16px;
            background: var(--error-bg);
            border: 1px solid var(--error-line);
            border-radius: 14px;
            color: var(--error-fg);
            font-size: .9rem;
            font-weight: 500;
        }

        /* Form */
        .field { margin-bottom: 20px; }

        .field label {
            display: block;
            margin-bottom: 9px;
            font-size: .88rem;
            font-weight: 500;
        }

        .input-wrap { position: relative; }

        .input-wrap input {
            width: 100%;
            height: 54px;
            padding: 0 22px;
            background: var(--field);
            border: 1px solid var(--field-line);
            border-radius: 999px;
            color: var(--text);
            font: inherit;
            font-size: .95rem;
            transition: border-color .15s, box-shadow .15s;
        }

        .input-wrap input::placeholder { color: #5d6786; }

        .input-wrap input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .22);
        }

        .input-wrap input.has-error { border-color: var(--error-line); }

        /* Autofill browser jangan putih */
        .input-wrap input:-webkit-autofill {
            -webkit-text-fill-color: var(--text);
            box-shadow: 0 0 0 1000px var(--field) inset;
            caret-color: var(--text);
        }

        .input-wrap.has-toggle input { padding-right: 56px; }

        .toggle {
            position: absolute;
            top: 50%;
            right: 10px;
            display: grid;
            place-items: center;
            width: 36px;
            height: 36px;
            padding: 0;
            transform: translateY(-50%);
            background: none;
            border: 0;
            border-radius: 50%;
            color: var(--muted);
            cursor: pointer;
            transition: color .15s, background-color .15s;
        }

        .toggle:hover { color: var(--text); background: rgba(255, 255, 255, .06); }

        .toggle svg {
            width: 19px;
            height: 19px;
            fill: none;
            stroke: currentColor;
            stroke-width: 1.8;
            stroke-linecap: round;
            stroke-linejoin: round;
        }

        .toggle .icon-hide { display: none; }
        .toggle[aria-pressed="true"] .icon-show { display: none; }
        .toggle[aria-pressed="true"] .icon-hide { display: block; }

        /* Tombol */
        .btn-login {
            width: 100%;
            height: 54px;
            margin-top: 6px;
            background: var(--accent);
            border: 0;
            border-radius: 999px;
            box-shadow: 0 10px 30px rgba(37, 99, 235, .35);
            color: #fff;
            font: inherit;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color .15s, transform .15s, opacity .15s;
        }

        .btn-login:hover { background: var(--accent-dark); }
        .btn-login:active { transform: translateY(1px); }
        .btn-login:disabled { opacity: .7; cursor: wait; }


        /* Remember me */
        .options {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .remember {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--muted);
            font-size: .88rem;
            cursor: pointer;
            user-select: none;
        }

        .remember input {
            position: absolute;
            opacity: 0;
            pointer-events: none;
        }

        .remember .box {
            display: grid;
            place-items: center;
            width: 18px;
            height: 18px;
            border: 1.5px solid #4a5472;
            border-radius: 50%;
            transition: background-color .15s, border-color .15s;
        }

        .remember .box::after {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #fff;
            transform: scale(0);
            transition: transform .15s;
        }

        .remember input:checked + .box { background: var(--accent); border-color: var(--accent); }
        .remember input:checked + .box::after { transform: scale(1); }
        .remember input:focus-visible + .box { outline: 3px solid rgba(37, 99, 235, .45); outline-offset: 2px; }

        .footer {
            margin-top: 44px;
            color: #5d6786;
            font-size: .82rem;
            text-align: center;
        }

        .toggle:focus-visible,
        .btn-login:focus-visible {
            outline: 3px solid rgba(143, 176, 255, .6);
            outline-offset: 2px;
        }

        @media (max-width: 480px) {
            body { padding: 24px 18px; align-items: start; }
            .login { margin-top: 24px; }
            .heading h1 { font-size: 1.4rem; }
        }

        @media (prefers-reduced-motion: reduce) {
            * { transition: none !important; }
        }
    </style>
</head>

<body>

    <div class="rings" aria-hidden="true">
        <span></span><span></span><span></span>
    </div>

    <main class="login">

        <div class="brand">
            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><path d="M9 22V12h6v10"/></svg>
            KosKita
        </div>

        <div class="heading">
            <h1>Masuk ke Akun Anda.</h1>
            <p>Masuk untuk mengelola kamar, pembayaran, dan keluhan di KosKita.</p>
        </div>


        @if ($errors->any())
            <div class="error-box" role="alert">
                {{ $errors->first() }}
            </div>
        @endif


        <form action="{{ route('login.process') }}" method="POST" id="loginForm">
            @csrf

            <div class="field">
                <label for="email">Email</label>

                <div class="input-wrap">
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Masukkan email"
                        autocomplete="username"
                        class="{{ $errors->has('email') ? 'has-error' : '' }}"
                        required
                        autofocus
                    >
                </div>
            </div>

            <div class="field">
                <label for="password">Password</label>

                <div class="input-wrap has-toggle">
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Masukkan password"
                        autocomplete="current-password"
                        required
                    >

                    <button type="button" class="toggle" id="togglePassword"
                            aria-label="Tampilkan password" aria-pressed="false">
                        <svg class="icon-show" viewBox="0 0 24 24" aria-hidden="true"><path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"/><circle cx="12" cy="12" r="3"/></svg>
                        <svg class="icon-hide" viewBox="0 0 24 24" aria-hidden="true"><path d="M9.9 4.2A10 10 0 0 1 12 5c6.5 0 10 7 10 7a17 17 0 0 1-2.9 3.8"/><path d="M6.6 6.6A16.6 16.6 0 0 0 2 12s3.5 7 10 7a9.7 9.7 0 0 0 5.4-1.6"/><path d="M9.9 9.9a3 3 0 0 0 4.2 4.2"/><path d="m2 2 20 20"/></svg>
                    </button>
                </div>
            </div>

            <button type="submit" class="btn-login" id="btnLogin">Login</button>

            <div class="options">
                <label class="remember">
                    <input type="checkbox" name="remember" value="1" {{ old('remember') ? 'checked' : '' }}>
                    <span class="box" aria-hidden="true"></span>
                    Ingat saya
                </label>
            </div>
        </form>


        <div class="footer">
            KosKita &middot; Sistem Manajemen Kos
        </div>

    </main>
@vite('resources/js/app.js')

</body>
</html>
