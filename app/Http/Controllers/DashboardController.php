<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use App\Models\Penghuni;
use App\Models\Pembayaran;
use App\Models\Keluhan;
use App\Models\User;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use App\Support\ActivityLogger;
use Illuminate\Support\Facades\Hash;
use App\Models\QrisSetting;

class DashboardController extends Controller
{

public function admin()
{
    // Statistik kamar
    $totalKamar = Kamar::count();
    $kamarKosong = Kamar::where('status', 'kosong')->count();
    $kamarTerisi = Kamar::where('status', 'terisi')->count();
    $kamarPerbaikan = Kamar::where('status', 'perbaikan')->count();

    // Statistik penghuni
    $totalPenghuni = Penghuni::count();
    $penghuniAktif = Penghuni::whereNull('tanggal_keluar')->count();

    // Statistik pembayaran
    $totalTagihan = Pembayaran::count();
    $tagihanLunas = Pembayaran::where('status', 'lunas')->count();
    $tagihanBelumLunas = Pembayaran::where('status', 'belum_lunas')->count();

    $tagihanMenungguVerifikasi = Pembayaran::where(
        'status', 'menunggu_verifikasi'
    )->count();

    $tagihanDitolak = Pembayaran::where('status', 'ditolak')->count();

    // Laporan keuangan
    $totalPemasukan = Pembayaran::where('status', 'lunas')
        ->sum('jumlah');

    $totalNominalBelumLunas = Pembayaran::where('status', 'belum_lunas')
        ->sum('jumlah');

    $totalMenungguVerifikasi = Pembayaran::where(
        'status', 'menunggu_verifikasi'
    )->sum('jumlah');

    // Grafik pemasukan berdasarkan bulan pada tahun berjalan
    $tahunLaporan = now()->year;

    $dataPemasukan = Pembayaran::where('status', 'lunas')
        ->whereNotNull('tanggal_bayar')
        ->whereYear('tanggal_bayar', $tahunLaporan)
        ->selectRaw('MONTH(tanggal_bayar) as bulan, SUM(jumlah) as total')
        ->groupByRaw('MONTH(tanggal_bayar)')
        ->pluck('total', 'bulan');

    $namaBulan = [
        'Januari', 'Februari', 'Maret', 'April',
        'Mei', 'Juni', 'Juli', 'Agustus',
        'September', 'Oktober', 'November', 'Desember'
    ];

    $pemasukanBulanan = [];

    foreach ($namaBulan as $index => $bulan) {
        $nomorBulan = $index + 1;

        $pemasukanBulanan[] = [
            'bulan' => $bulan,
            'total' => (float) ($dataPemasukan[$nomorBulan] ?? 0),
        ];
    }

    // Statistik keluhan
    $totalKeluhan = Keluhan::count();
    $keluhanMenunggu = Keluhan::where('status', 'menunggu')->count();
    $keluhanDiproses = Keluhan::where('status', 'diproses')->count();
    $keluhanSelesai = Keluhan::where('status', 'selesai')->count();

    // Statistik teknisi
    $totalTeknisi = User::where('role', 'teknisi')->count();

    // Aktivitas terbaru
    $aktivitasTerbaru = ActivityLog::latest()
        ->take(5)
        ->get();

    return view('dashboard.admin', compact(
        'totalKamar',
        'kamarKosong',
        'kamarTerisi',
        'kamarPerbaikan',
        'totalPenghuni',
        'penghuniAktif',
        'totalTagihan',
        'tagihanLunas',
        'tagihanBelumLunas',
        'tagihanMenungguVerifikasi',
        'tagihanDitolak',
        'totalPemasukan',
        'totalNominalBelumLunas',
        'totalMenungguVerifikasi',
        'tahunLaporan',
        'pemasukanBulanan',
        'totalKeluhan',
        'keluhanMenunggu',
        'keluhanDiproses',
        'keluhanSelesai',
        'totalTeknisi',
        'aktivitasTerbaru'
    ));
}

    public function pembayaran()
{
    $penghuni = Penghuni::where('user_id', auth()->id())->first();

    $pembayarans = $penghuni
        ? $penghuni->pembayaran()->latest()->get()
        : collect();

    $qris = QrisSetting::first();

    return view('dashboard.pembayaran', compact(
        'penghuni',
        'pembayarans',
        'qris'
    ));
}

   public function penghuni()
    {
    $penghuni = \App\Models\Penghuni::with('kamar')
        ->where('user_id', auth()->id())
        ->first();

    return view('dashboard.penghuni', compact('penghuni'));
    }

    public function kamar()
        {
    $penghuni = \App\Models\Penghuni::with('kamar')
        ->where('user_id', auth()->id())
        ->first();

    return view('dashboard.kamar', compact('penghuni'));
    }
    public function teknisi()
    {
        $query = Keluhan::where('teknisi_id', auth()->id());

        $totalTugas = (clone $query)->count();

        $tugasMenunggu = (clone $query)
            ->where('status', 'menunggu')
            ->count();

        $tugasDiproses = (clone $query)
            ->where('status', 'diproses')
            ->count();

        $tugasSelesai = (clone $query)
            ->where('status', 'selesai')
            ->count();

        $tugasTerbaru = (clone $query)
            ->with(['penghuni.user', 'kamar'])
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard.teknisi', compact(
            'totalTugas',
            'tugasMenunggu',
            'tugasDiproses',
            'tugasSelesai',
            'tugasTerbaru'
        ));
    }

    public function profil()
    {
        $penghuni = \App\Models\Penghuni::with(['user', 'kamar'])
            ->where('user_id', auth()->id())
            ->first();

        if (!$penghuni) {
            return redirect()->route('penghuni.dashboard')
                ->with('error', 'Data penghuni tidak ditemukan.');
        }

        return view('dashboard.profil', compact('penghuni'));
    }

    public function editProfil()
    {
    $penghuni = \App\Models\Penghuni::with('user')
        ->where('user_id', auth()->id())
        ->firstOrFail();

    return view('dashboard.edit-profil', compact('penghuni'));
    }

public function updateProfil(Request $request)
{
    $penghuni = \App\Models\Penghuni::with('user')
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => [
            'required',
            'email',
            'max:255',
            Rule::unique('users', 'email')->ignore($penghuni->user_id),
        ],
        'no_hp' => 'required|string|max:20',
        'alamat' => 'nullable|string|max:500',
    ]);

    $penghuni->user->update([
        'name' => $validated['name'],
        'email' => $validated['email'],
    ]);

    $penghuni->update([
        'no_hp' => $validated['no_hp'],
        'alamat' => $validated['alamat'] ?? null,
    ]);

    ActivityLogger::log(
        'Memperbarui Profil',
        'Penghuni memperbarui informasi profil akun.'
    );

    return redirect()->route('penghuni.profil')
        ->with('success', 'Profil berhasil diperbarui!');
    }

    public function gantiPassword()
    {
    return view('dashboard.ganti-password');
    }

    public function updatePassword(Request $request)
    {
    $request->validate([
        'password_lama' => 'required',
        'password_baru' => 'required|string|min:8|confirmed',
    ], [
        'password_lama.required' => 'Password lama wajib diisi.',
        'password_baru.required' => 'Password baru wajib diisi.',
        'password_baru.min' => 'Password baru minimal 8 karakter.',
        'password_baru.confirmed' => 'Konfirmasi password baru tidak cocok.',
    ]);

    $user = Auth::user();

    if (!Hash::check($request->password_lama, $user->password)) {
        return back()
            ->withErrors(['password_lama' => 'Password lama yang dimasukkan salah.'])
            ->withInput();
    }

    $user->update([
        'password' => $request->password_baru,
    ]);

    ActivityLogger::log(
        'Mengganti Password',
        'Penghuni berhasil mengganti password akun.'
    );

    return redirect()->route('penghuni.profil')
        ->with('success', 'Password berhasil diperbarui!');
    }
}