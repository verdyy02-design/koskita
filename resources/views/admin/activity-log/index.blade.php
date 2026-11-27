@extends('layouts.app')
@section('content')
@include('css.ui-style')

<style>
    .ui-table.table-wide { min-width: 860px; }

    .pager {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        flex-wrap: wrap;
        padding: 16px 20px;
        border-top: 1px solid var(--line);
        background: var(--mist);
        border-radius: 0 0 16px 16px;
    }

    .pager-info { color: var(--ink-soft); font-size: .88rem; }
    .pager-info strong { color: var(--ink); font-weight: 600; }

    .pager-nav { display: flex; align-items: center; gap: 8px; }
    .pager-page { color: var(--ink-soft); font-size: .88rem; padding: 0 6px; }

    .ui-page .btn-disabled {
        opacity: .5;
        pointer-events: none;
    }
</style>

<div class="ui-page" style="--w: 1200px;">

    <div class="ui-head">
        <div>
            <h1>Activity Log</h1>
            <p>Riwayat aktivitas seluruh pengguna sistem KosKita.</p>
        </div>

        <span class="tag">Total {{ $activities->total() }} aktivitas</span>
    </div>


    <div class="ui-panel">

        <div class="ui-scroll">

            <table class="ui-table table-wide">

                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama pengguna</th>
                        <th>Role</th>
                        <th>Aktivitas</th>
                        <th>Deskripsi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($activities as $activity)

                        <tr>
                            <td class="col-no">{{ $activities->firstItem() + $loop->index }}</td>

                            <td class="col-strong">{{ $activity->nama_pengguna ?? '-' }}</td>

                            <td><span class="tag">{{ ucfirst($activity->role ?? '-') }}</span></td>

                            <td><span class="badge badge-info">{{ $activity->aktivitas }}</span></td>

                            <td>{{ $activity->deskripsi ?? '-' }}</td>

                            <td class="col-muted col-nowrap">
                                {{ $activity->created_at->format('d-m-Y H:i') }}
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                <div class="ui-empty">
                                    <svg class="ui-icon" viewBox="0 0 24 24"><rect x="8" y="2" width="8" height="4" rx="1"/><path d="M16 4h2a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V6a2 2 0 0 1 2-2h2"/><path d="M12 11h4"/><path d="M12 16h4"/><path d="M8 11h.01"/><path d="M8 16h.01"/></svg>
                                    <strong>Belum ada aktivitas</strong>
                                    Aktivitas pengguna akan tercatat di sini.
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($activities->count() > 0)
            <div class="pager">

                <div class="pager-info">
                    Menampilkan <strong>{{ $activities->firstItem() }}</strong>
                    sampai <strong>{{ $activities->lastItem() }}</strong>
                    dari <strong>{{ $activities->total() }}</strong> aktivitas
                </div>

                @if($activities->hasPages())
                    <div class="pager-nav">

                        <a href="{{ $activities->previousPageUrl() ?? '#' }}"
                           class="btn btn-ghost btn-sm {{ $activities->onFirstPage() ? 'btn-disabled' : '' }}"
                           @if($activities->onFirstPage()) aria-disabled="true" tabindex="-1" @endif>
                            <svg class="ui-icon" viewBox="0 0 24 24"><path d="m15 18-6-6 6-6"/></svg>
                            Sebelumnya
                        </a>

                        <span class="pager-page">
                            Halaman {{ $activities->currentPage() }} / {{ $activities->lastPage() }}
                        </span>

                        <a href="{{ $activities->nextPageUrl() ?? '#' }}"
                           class="btn btn-ghost btn-sm {{ $activities->hasMorePages() ? '' : 'btn-disabled' }}"
                           @if(! $activities->hasMorePages()) aria-disabled="true" tabindex="-1" @endif>
                            Berikutnya
                            <svg class="ui-icon" viewBox="0 0 24 24"><path d="m9 18 6-6-6-6"/></svg>
                        </a>

                    </div>
                @endif

            </div>
        @endif

    </div>

</div>

@endsection
