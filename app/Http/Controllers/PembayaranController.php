<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Support\ActivityLogger;

class PembayaranController extends Controller
{
    // ==============================
    // ADMIN: DAFTAR TAGIHAN
    // ==============================
    public function index()
    {
        $pembayarans = Pembayaran::with('penghuni.user', 'penghuni.kamar')
            ->latest()
            ->get();

        return view('pembayaran.index', compact('pembayarans'));
    }

    // ==============================
    // ADMIN: FORM BUAT TAGIHAN
    // ==============================
    public function create()
    {
        $penghunis = Penghuni::with('user', 'kamar')
            ->latest()
            ->get();

        return view('pembayaran.create', compact('penghunis'));
    }

    // ==============================
    // ADMIN: SIMPAN TAGIHAN
    // ==============================
    public function store(Request $request)
    {
        $request->validate([
            'penghuni_id' => 'required|exists:penghuni,id',
            'bulan' => 'required|string|max:50',
            'jumlah' => 'required|numeric|min:1',
            'tanggal_jatuh_tempo' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        $pembayaran = Pembayaran::create([
            'penghuni_id' => $request->penghuni_id,
            'bulan' => $request->bulan,
            'periode' => $request->bulan,
            'jumlah' => $request->jumlah,
            'tanggal_jatuh_tempo' => $request->tanggal_jatuh_tempo,
            'tanggal_bayar' => null,
            'bukti_pembayaran' => null,
            'status' => 'belum_lunas',
            'keterangan' => $request->keterangan,
        ]);

        $namaPenghuni = Penghuni::with('user')
            ->find($request->penghuni_id);

        ActivityLogger::log(
            'Membuat Tagihan Pembayaran',
            'Admin membuat tagihan untuk ' .
            ($namaPenghuni->user->name ?? '-') .
            ' periode ' . $request->bulan .
            ' sebesar Rp' . number_format($request->jumlah, 0, ',', '.')
        );

        return redirect()
            ->route('pembayaran.index')
            ->with('success', 'Tagihan pembayaran berhasil dibuat!');
    }

    // ==============================
    // PENGHUNI: HALAMAN PEMBAYARAN
    // ==============================
    public function showPayment($id)
    {
        $penghuni = Penghuni::where('user_id', Auth::id())
            ->firstOrFail();

        $pembayaran = Pembayaran::where('penghuni_id', $penghuni->id)
            ->findOrFail($id);

        if (in_array($pembayaran->status, ['lunas', 'menunggu_verifikasi'])) {
            return redirect()
                ->route('penghuni.pembayaran')
                ->with('error', 'Tagihan ini tidak dapat dibayar saat ini.');
        }

        return view('dashboard.pembayaran-upload', compact('pembayaran'));
    }

    // ==============================
    // PENGHUNI: UPLOAD BUKTI
    // ==============================
    public function uploadProof(Request $request, $id)
    {
        $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'bukti_pembayaran.required' => 'Bukti transfer wajib diunggah.',
            'bukti_pembayaran.image' => 'File harus berupa gambar.',
            'bukti_pembayaran.mimes' => 'Format bukti harus JPG atau PNG.',
            'bukti_pembayaran.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $penghuni = Penghuni::where('user_id', Auth::id())
            ->firstOrFail();

        $pembayaran = Pembayaran::where('penghuni_id', $penghuni->id)
            ->findOrFail($id);

        if (!in_array($pembayaran->status, ['belum_lunas', 'ditolak'])) {
            return redirect()
                ->route('penghuni.pembayaran')
                ->with('error', 'Tagihan ini tidak dapat menerima bukti pembayaran baru.');
        }

        if ($pembayaran->bukti_pembayaran) {
            Storage::disk('public')->delete($pembayaran->bukti_pembayaran);
        }

        $path = $request->file('bukti_pembayaran')
            ->store('bukti-pembayaran', 'public');

        $pembayaran->update([
            'bukti_pembayaran' => $path,
            'status' => 'menunggu_verifikasi',
        ]);

        ActivityLogger::log(
            'Mengunggah Bukti Pembayaran',
            'Penghuni mengunggah bukti pembayaran periode ' .
            ($pembayaran->bulan ?? $pembayaran->periode)
        );

        return redirect()
            ->route('penghuni.pembayaran')
            ->with('success', 'Bukti pembayaran berhasil dikirim dan sedang menunggu verifikasi admin.');
    }

    // ==============================
    // ADMIN: TERIMA PEMBAYARAN
    // ==============================
    public function approve($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->status !== 'menunggu_verifikasi') {
            return back()->with('error', 'Pembayaran ini tidak sedang menunggu verifikasi.');
        }

        $pembayaran->update([
            'status' => 'lunas',
            'tanggal_bayar' => now()->toDateString(),
        ]);

        ActivityLogger::log(
            'Memverifikasi Pembayaran',
            'Admin menerima pembayaran periode ' .
            ($pembayaran->bulan ?? $pembayaran->periode)
        );

        return back()->with('success', 'Pembayaran berhasil diterima. Tagihan sekarang berstatus lunas.');
    }

    // ==============================
    // ADMIN: TOLAK PEMBAYARAN
    // ==============================
    public function reject($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);

        if ($pembayaran->status !== 'menunggu_verifikasi') {
            return back()->with('error', 'Pembayaran ini tidak sedang menunggu verifikasi.');
        }

        $pembayaran->update([
            'status' => 'ditolak',
            'tanggal_bayar' => null,
        ]);

        ActivityLogger::log(
            'Menolak Bukti Pembayaran',
            'Admin menolak bukti pembayaran periode ' .
            ($pembayaran->bulan ?? $pembayaran->periode)
        );

        return back()->with('success', 'Bukti pembayaran ditolak. Penghuni dapat mengunggah ulang bukti pembayaran.');
    }

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
