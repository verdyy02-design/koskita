<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .kamar-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --teal: #2563eb;
        --teal-dark: #1d4ed8;
        --mist: #e8eefb;
        --line: #d3def3;
        --surface: #ffffff;
        --page: #e8eefb;
        --card: #f3f7ff;
        --busy-bg: #fde4e1;
        --busy-fg: #a3281c;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - 640px) / 2)) 56px;
    }

    .kamar-page * { box-sizing: border-box; }

    .kamar-head { margin-bottom: 24px; }
    .kamar-head h1 { margin: 0; font-size: 2rem; font-weight: 700; letter-spacing: -0.02em; line-height: 1.15; }
    .kamar-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    .kamar-card {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .08);
        padding: 28px;
    }

    .field { margin-bottom: 20px; }

    .field label {
        display: block;
        margin-bottom: 7px;
        font-size: .9rem;
        font-weight: 600;
    }

    .field .hint { margin-top: 6px; color: var(--ink-soft); font-size: .82rem; }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        padding: 11px 14px;
        background: var(--surface);
        border: 1px solid var(--line);
        border-radius: 10px;
        color: var(--ink);
        font: inherit;
        font-size: .95rem;
        transition: border-color .15s, box-shadow .15s;
    }

    .field textarea { min-height: 96px; resize: vertical; line-height: 1.45; }

    .field input:focus,
    .field select:focus,
    .field textarea:focus {
        outline: none;
        border-color: var(--teal);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
    }

    .field.has-error input,
    .field.has-error select,
    .field.has-error textarea { border-color: #e07b70; }

    .field .error { margin-top: 6px; color: var(--busy-fg); font-size: .84rem; font-weight: 500; }

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

    .form-actions {
        display: flex;
        gap: 10px;
        margin-top: 28px;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }

    .kamar-page .btn {
        display: inline-flex;
        align-items: center;
        padding: 11px 20px;
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

    .kamar-page .btn-primary { background: var(--teal); color: #fff; }
    .kamar-page .btn-primary:hover { background: var(--teal-dark); }
    .kamar-page .btn-ghost { background: var(--surface); border-color: var(--line); color: var(--ink); }
    .kamar-page .btn-ghost:hover { border-color: var(--teal); color: var(--teal); }

    .kamar-page a:focus-visible,
    .kamar-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    @media (max-width: 600px) {
        .kamar-page { padding: 20px 14px 40px; }
        .kamar-card { padding: 20px; }
        .kamar-head h1 { font-size: 1.6rem; }
    }
</style>
