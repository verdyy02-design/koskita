<?php

namespace App\Http\Controllers;

use App\Models\Laporan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\ActivityLogger;

class LaporanController extends Controller
{
        // ==============================
    // ADMIN: LAPORAN KEUANGAN
    // ==============================
    public function laporan(Request $request)
    {
        $request->validate([
            'bulan' => 'nullable|integer|between:1,12',
            'tahun' => 'nullable|integer|min:2020|max:2100',
        ]);

        $bulan = $request->input('bulan');
        $tahun = $request->input('tahun', now()->year);

        // Query dasar berdasarkan waktu tagihan dibuat
        $baseQuery = Pembayaran::query()
            ->when($bulan, function ($query) use ($bulan) {
                $query->whereMonth('created_at', $bulan);
            })
            ->whereYear('created_at', $tahun);

        // Riwayat transaksi
        $pembayarans = (clone $baseQuery)
            ->with('penghuni.user', 'penghuni.kamar')
            ->latest()
            ->get();

        // Ringkasan keuangan sesuai filter
        $totalPemasukan = (clone $baseQuery)
            ->where('status', 'lunas')
            ->sum('jumlah');

        $totalNominalBelumLunas = (clone $baseQuery)
            ->whereIn('status', ['belum_lunas', 'ditolak'])
            ->sum('jumlah');

        $totalMenungguVerifikasi = (clone $baseQuery)
            ->where('status', 'menunggu_verifikasi')
            ->sum('jumlah');

        $jumlahTransaksi = $pembayarans->count();

        return view('pembayaran.laporan', compact(
            'pembayarans',
            'bulan',
            'tahun',
            'totalPemasukan',
            'totalNominalBelumLunas',
            'totalMenungguVerifikasi',
            'jumlahTransaksi'
        ));
    }
}
