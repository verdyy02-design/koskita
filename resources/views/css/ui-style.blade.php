<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">

<style>
    .ui-page {
        --ink: #0f172a;
        --ink-soft: #64748b;
        --blue: #2563eb;
        --blue-dark: #1d4ed8;
        --page: #e8eefb;
        --card: #ffffff;
        --mist: #eef3fd;
        --line: #d3def3;
        --ok-bg: #dff3e8;    --ok-fg: #17663d;
        --warn-bg: #fdf0d2;  --warn-fg: #8a5a05;
        --busy-bg: #fde4e1;  --busy-fg: #a3281c;
        --info-bg: #dbe7fe;  --info-fg: #1d4ed8;
        --slate-bg: #e2e8f0; --slate-fg: #334155;

        font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
        color: var(--ink);
        background: var(--page);
        min-height: calc(100vh - 106px);
        padding: 32px max(20px, calc((100% - var(--w, 1000px)) / 2)) 56px;
    }

    .ui-page * { box-sizing: border-box; }

    .ui-icon {
        width: 16px;
        height: 16px;
        flex: none;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.9;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Header */
    .ui-head {
        display: flex;
        align-items: flex-end;
        justify-content: space-between;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
    }

    .ui-head h1 {
        margin: 0;
        font-size: 2rem;
        font-weight: 700;
        letter-spacing: -0.02em;
        line-height: 1.15;
    }

    .ui-head p { margin: 6px 0 0; color: var(--ink-soft); font-size: .95rem; }

    /* Panel */
    .ui-panel {
        background: var(--card);
        border: 1px solid var(--line);
        border-radius: 16px;
        box-shadow: 0 1px 2px rgba(15, 23, 42, .04), 0 8px 24px rgba(15, 23, 42, .06);
    }

    .ui-panel-pad { padding: 28px; }

    /* Tombol */
    .ui-page .btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 10px 18px;
        border: 1px solid transparent;
        border-radius: 10px;
        font: inherit;
        font-size: .9rem;
        font-weight: 600;
        line-height: 1;
        text-decoration: none;
        white-space: nowrap;
        cursor: pointer;
        transition: background-color .15s, border-color .15s, color .15s;
    }

    .ui-page .btn-sm { padding: 8px 12px; font-size: .84rem; border-radius: 8px; }
    .ui-page .btn-primary { background: var(--blue); color: #fff; }
    .ui-page .btn-primary:hover { background: var(--blue-dark); }
    .ui-page .btn-ghost { background: var(--card); border-color: var(--line); color: var(--ink); }
    .ui-page .btn-ghost:hover { border-color: var(--blue); color: var(--blue); }
    .ui-page .btn-danger { background: var(--card); border-color: var(--line); color: var(--busy-fg); }
    .ui-page .btn-danger:hover { background: var(--busy-bg); border-color: #f3b9b3; }

    .ui-page a:focus-visible,
    .ui-page button:focus-visible {
        outline: 3px solid rgba(37, 99, 235, .35);
        outline-offset: 2px;
    }

    /* Alert */
    .ui-alert {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 20px;
        padding: 14px 16px;
        border-radius: 10px;
        font-weight: 500;
    }

    .ui-alert .ui-icon { width: 20px; height: 20px; margin-top: 1px; }
    .ui-alert-success { background: var(--ok-bg); color: var(--ok-fg); border: 1px solid #bde3cd; border-left: 4px solid var(--ok-fg); }
    .ui-alert-error { background: var(--busy-bg); color: var(--busy-fg); border: 1px solid #f3b9b3; border-left: 4px solid var(--busy-fg); }
    .ui-alert ul { margin: 4px 0 0; padding-left: 18px; font-weight: 500; }

    /* Tabel */
    .ui-scroll { overflow-x: auto; }
    .ui-table { width: 100%; min-width: 720px; border-collapse: collapse; }

    .ui-table thead th {
        padding: 14px 20px;
        background: var(--mist);
        border-bottom: 1px solid var(--line);
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 600;
        text-align: left;
        white-space: nowrap;
    }

    .ui-table tbody td {
        padding: 15px 20px;
        border-bottom: 1px solid var(--line);
        font-size: .92rem;
        vertical-align: middle;
    }

    .ui-table tbody tr:last-child td { border-bottom: 0; }
    .ui-table tbody tr:hover { background: #f3f7ff; }

    .col-no { width: 56px; color: var(--ink-soft); }
    .col-aksi { width: 1%; white-space: nowrap; }
    .col-muted { color: var(--ink-soft); }
    .col-nowrap { white-space: nowrap; }
    .col-strong { font-weight: 600; }

    .ui-actions { display: flex; gap: 8px; }
    .ui-actions form { margin: 0; }

    /* Badge */
    .badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 5px 12px;
        border-radius: 999px;
        font-size: .82rem;
        font-weight: 600;
        white-space: nowrap;
    }

    .badge::before {
        content: '';
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background: currentColor;
    }

    .badge-ok { background: var(--ok-bg); color: var(--ok-fg); }
    .badge-warn { background: var(--warn-bg); color: var(--warn-fg); }
    .badge-info { background: var(--info-bg); color: var(--info-fg); }
    .badge-busy { background: var(--busy-bg); color: var(--busy-fg); }
    .badge-slate { background: var(--slate-bg); color: var(--slate-fg); }

    .chip {
        display: inline-block;
        min-width: 52px;
        padding: 6px 12px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--blue-dark);
        font-weight: 700;
        text-align: center;
    }

    .tag {
        display: inline-block;
        padding: 4px 10px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 8px;
        color: var(--ink-soft);
        font-size: .82rem;
        font-weight: 600;
    }

    /* Kosong */
    .ui-empty { padding: 56px 20px; text-align: center; color: var(--ink-soft); }
    .ui-empty .ui-icon { width: 44px; height: 44px; margin-bottom: 12px; color: var(--blue); opacity: .7; }
    .ui-empty strong { display: block; margin-bottom: 4px; color: var(--ink); font-size: 1.05rem; }

    /* Form */
    .form-section {
        display: flex;
        align-items: center;
        gap: 10px;
        margin: 0 0 18px;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .form-section .ui-icon { width: 20px; height: 20px; color: var(--blue); }

    .form-divider { margin: 28px 0; border: 0; border-top: 1px solid var(--line); }

    .form-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 18px; }

    .field { margin-bottom: 20px; }
    .field label { display: block; margin-bottom: 7px; font-size: .9rem; font-weight: 600; }
    .field .opt { color: var(--ink-soft); font-weight: 500; }
    .field .hint { margin-top: 6px; color: var(--ink-soft); font-size: .82rem; }
    .field .warn { margin-top: 6px; color: var(--busy-fg); font-size: .84rem; font-weight: 500; }

    .field input,
    .field select,
    .field textarea {
        width: 100%;
        padding: 11px 14px;
        background: #fff;
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
        border-color: var(--blue);
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .18);
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 8px;
        padding-top: 20px;
        border-top: 1px solid var(--line);
    }

    /* NOTIFIKASI */
    .notification-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 16px;
        padding: 20px 28px;
        border-bottom: 1px solid var(--line);
    }

    .notification-header h3 {
        margin: 0;
        font-size: 1.05rem;
        font-weight: 700;
    }

    .notification-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 12px;
    }

    .notification-filter {
        display: flex;
        align-items: center;
        gap: 4px;
        padding: 5px;
        background: var(--mist);
        border: 1px solid var(--line);
        border-radius: 10px;
    }

    .notification-filter a {
        padding: 9px 13px;
        border-radius: 7px;
        color: var(--ink-soft);
        font-size: .84rem;
        font-weight: 600;
        text-decoration: none;
        white-space: nowrap;
        transition: .2s ease;
    }

    .notification-filter a:hover {
        color: var(--blue);
        background: #fff;
    }

    .notification-filter a.active {
        color: #fff;
        background: var(--blue);
        box-shadow: 0 2px 5px rgba(37, 99, 235, .16);
    }

    .notification-item {
        margin: 16px 28px;
        padding: 18px 20px;
        border: 1px solid var(--line);
        border-radius: 12px;
        background: #fff;
        transition: .2s ease;
    }

    .notification-item:hover {
        border-color: #b7c9ed;
        box-shadow: 0 4px 12px rgba(15, 23, 42, .05);
    }

    .notification-item.unread {
        background: #f3f7ff;
        border-left: 4px solid var(--blue);
    }

    .notification-item p {
        color: var(--ink-soft);
        line-height: 1.5;
    }

    .notification-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        color: var(--ink-soft);
        font-size: .86rem;
    }

    .notification-meta strong {
        color: var(--ink);
    }

    .notification-time {
        margin-top: 12px;
        color: var(--ink-soft);
        font-size: .8rem;
    }

    .notification-read-all {
        border: none;
        cursor: pointer;
    }

    @media (max-width: 700px) {
        .notification-header {
            padding: 20px;
            align-items: flex-start;
        }

        .notification-actions {
            width: 100%;
            align-items: stretch;
            flex-direction: column;
        }

        .notification-filter {
            width: 100%;
            overflow-x: auto;
        }

        .notification-item {
            margin: 12px 16px;
            padding: 16px;
        }
    }

    @media (max-width: 700px) {
        .ui-page { padding: 20px 14px 40px; }
        .ui-head h1 { font-size: 1.6rem; }
        .ui-panel-pad { padding: 20px; }
        .form-grid { grid-template-columns: 1fr; }
        .form-actions { justify-content: stretch; }
        .form-actions .btn { flex: 1; justify-content: center; }
    }
</style>
