<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PaymentDueNotification extends Notification
{
    use Queueable;

    protected $pembayaran;
    protected $jenis;

    public function __construct($pembayaran, $jenis)
    {
        $this->pembayaran = $pembayaran;
        $this->jenis = $jenis;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toArray($notifiable)
    {
        $pesan = match ($this->jenis) {
            'h3' => 'Tagihan pembayaran kos akan jatuh tempo dalam 3 hari.',
            'h1' => 'Tagihan pembayaran kos akan jatuh tempo besok.',
            'jatuh_tempo' => 'Hari ini adalah batas pembayaran tagihan kos.',
            'terlambat' => 'Tagihan pembayaran kos sudah melewati tanggal jatuh tempo.',
            default => 'Ada informasi terbaru mengenai tagihan pembayaran kos.',
        };

        return [
            'pembayaran_id' => $this->pembayaran->id,
            'judul' => 'Pengingat Pembayaran Kos',
            'pesan' => $pesan,
            'jenis' => $this->jenis,
            'bulan' => $this->pembayaran->bulan,
            'jumlah' => $this->pembayaran->jumlah,
            'tanggal_jatuh_tempo' => $this->pembayaran->tanggal_jatuh_tempo,
        ];
    }
}
