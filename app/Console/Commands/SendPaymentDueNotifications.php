<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Pembayaran;
use App\Notifications\PaymentDueNotification;
use Carbon\Carbon;

class SendPaymentDueNotifications extends Command
{
    protected $signature = 'payments:send-due-notifications';

    protected $description = 'Mengirim pengingat jatuh tempo pembayaran kos';

    public function handle()
    {
        $today = Carbon::today();

        $pembayarans = Pembayaran::with('penghuni.user')
            ->whereIn('status', ['belum_lunas', 'ditolak'])
            ->whereNotNull('tanggal_jatuh_tempo')
            ->get();

        foreach ($pembayarans as $pembayaran) {
            $penghuni = $pembayaran->penghuni;

            if (!$penghuni || !$penghuni->user) {
                continue;
            }

            $dueDate = Carbon::parse($pembayaran->tanggal_jatuh_tempo);

            $jenis = null;

            if ($today->equalTo($dueDate->copy()->subDays(3))) {
                $jenis = 'h3';
            } elseif ($today->equalTo($dueDate->copy()->subDay())) {
                $jenis = 'h1';
            } elseif ($today->equalTo($dueDate)) {
                $jenis = 'jatuh_tempo';
            } elseif ($today->greaterThan($dueDate)) {
                $jenis = 'terlambat';
            }

            if (!$jenis) {
                continue;
            }

            $sudahDikirim = $penghuni->user
                ->notifications()
                ->where('type', PaymentDueNotification::class)
                ->where('data->pembayaran_id', $pembayaran->id)
                ->where('data->jenis', $jenis)
                ->exists();

            if ($sudahDikirim) {
                continue;
            }

            $penghuni->user->notify(
                new PaymentDueNotification($pembayaran, $jenis)
            );
        }

        $this->info('Pemeriksaan dan pengiriman notifikasi pembayaran selesai.');

        return self::SUCCESS;
    }
}
