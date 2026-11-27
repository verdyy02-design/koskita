@extends('layouts.penghuni')
@section('title', 'Notifikasi')
@section('content')
@include('css.ui-style')

<div class="ui-page">

    {{-- HEADER HALAMAN --}}
    <div class="ui-head">
        <div>
            <h1>Notifikasi</h1>
            <p>Informasi dan pengingat pembayaran kos Anda.</p>
        </div>
    </div>

    {{-- PANEL NOTIFIKASI --}}
    <div class="ui-panel">

        <div class="notification-header">
            <h3>Semua Notifikasi</h3>

            <div class="notification-actions">

                {{-- FILTER --}}
                <div class="notification-filter">

                    <a href="{{ route('penghuni.notifikasi') }}"
                       class="{{ !request('filter') ? 'active' : '' }}">
                        Semua
                    </a>

                    <a href="{{ route('penghuni.notifikasi', ['filter' => 'belum_dibaca']) }}"
                       class="{{ request('filter') === 'belum_dibaca' ? 'active' : '' }}">
                        Belum Dibaca
                    </a>

                    <a href="{{ route('penghuni.notifikasi', ['filter' => 'sudah_dibaca']) }}"
                       class="{{ request('filter') === 'sudah_dibaca' ? 'active' : '' }}">
                        Sudah Dibaca
                    </a>

                </div>

                {{-- TANDAI SEMUA DIBACA --}}
                @if (auth()->user()->unreadNotifications()->exists())
                    <form action="{{ route('penghuni.notifikasi.baca-semua') }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary btn-sm notification-read-all">
                            Tandai Semua Dibaca
                        </button>
                    </form>
                @endif

            </div>
        </div>

        {{-- DAFTAR NOTIFIKASI --}}
        <div class="notification-list">

            @forelse ($notifications as $notification)

                <div class="notification-item {{ !$notification->read_at ? 'unread' : '' }}">

                    <div style="display:flex; justify-content:space-between; align-items:center; gap:12px; flex-wrap:wrap;">

                        <strong>
                            {{ $notification->data['judul'] ?? 'Notifikasi KosKita' }}
                        </strong>

                        @if (!$notification->read_at)
                            <span class="badge badge-info">
                                Belum dibaca
                            </span>
                        @else
                            <span class="badge badge-slate">
                                Sudah dibaca
                            </span>
                        @endif

                    </div>

                    <p style="margin:10px 0;">
                        {{ $notification->data['pesan'] ?? '-' }}
                    </p>

                    {{-- INFORMASI TAGIHAN --}}
                    <div class="notification-meta">

                        @if (!empty($notification->data['bulan']))
                            <div>
                                Periode Tagihan:
                                <strong>{{ $notification->data['bulan'] }}</strong>
                            </div>
                        @endif

                        @if (!empty($notification->data['jumlah']))
                            <div>
                                Nominal:
                                <strong>
                                    Rp{{ number_format($notification->data['jumlah'], 0, ',', '.') }}
                                </strong>
                            </div>
                        @endif

                        @if (!empty($notification->data['tanggal_jatuh_tempo']))
                            <div>
                                Jatuh Tempo:
                                <strong>
                                    {{ \Carbon\Carbon::parse($notification->data['tanggal_jatuh_tempo'])->format('d-m-Y') }}
                                </strong>
                            </div>
                        @endif

                    </div>

                    {{-- LINK TAGIHAN --}}
                    @if (!empty($notification->data['pembayaran_id']))
                        <div style="margin-top:15px;">
                            <a href="{{ route('penghuni.pembayaran.bayar', $notification->data['pembayaran_id']) }}"
                               class="btn btn-primary btn-sm">
                                Lihat Tagihan →
                            </a>
                        </div>
                    @endif

                    <div class="notification-time">
                        {{ $notification->created_at->format('d-m-Y H:i') }}
                    </div>

                </div>

            @empty

                <div class="ui-empty">
                    <strong>Belum Ada Notifikasi</strong>
                    <p>Notifikasi pembayaran akan muncul di sini.</p>
                </div>

            @endforelse

        </div>

        {{-- PAGINATION --}}
        @if ($notifications->hasPages())
            <div style="padding:20px 28px; border-top:1px solid var(--line);">
                {{ $notifications->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
