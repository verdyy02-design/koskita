<?php

use App\Http\Controllers\AdminKeluhanController;
use App\Http\Controllers\KeluhanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KamarController;
use App\Http\Controllers\PenghuniController;
use App\Http\Controllers\PembayaranController;
use App\Http\Controllers\TeknisiTugasController;
use App\Http\Controllers\TeknisiController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\QrisSettingController;
use App\Http\Controllers\TeknisiProfilController;

/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.process');

Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard Admin
    Route::get('/admin/dashboard', [DashboardController::class, 'admin'])
    ->name('admin.dashboard');
    // Data Kamar
    Route::resource('/admin/kamar', KamarController::class)
        ->names('kamar');

    // Data Penghuni
    Route::resource('/admin/penghuni', PenghuniController::class)
        ->names('penghuni');

     // Laporan Keuangan
    Route::get('/admin/laporan-keuangan', [PembayaranController::class, 'laporan'])
    ->name('pembayaran.laporan');

    // Data Pembayaran
    Route::resource('/admin/pembayaran', PembayaranController::class)
    ->names('pembayaran');

    // Verifikasi Pembayaran
    Route::post('/admin/pembayaran/{id}/terima', [PembayaranController::class, 'approve'])
    ->name('pembayaran.approve');

    Route::post('/admin/pembayaran/{id}/tolak', [PembayaranController::class, 'reject'])
    ->name('pembayaran.reject');

    // Data Keluhan
    Route::get('/admin/keluhan', [AdminKeluhanController::class, 'index'])
        ->name('admin.keluhan.index');

    Route::post('/admin/keluhan/{id}/assign', [AdminKeluhanController::class, 'assign'])
        ->name('admin.keluhan.assign');

    Route::resource('/admin/teknisi', TeknisiController::class)
    ->names('teknisi');

    Route::get('/admin/activity-log', [ActivityLogController::class, 'index'])
    ->name('admin.activity-log.index');

    Route::get('/admin/qris', [QrisSettingController::class, 'index'])
    ->name('admin.qris.index');

    Route::post('/admin/qris', [QrisSettingController::class, 'update'])
    ->name('admin.qris.update');

    Route::delete('/admin/qris', [QrisSettingController::class, 'destroy'])
    ->name('admin.qris.destroy');

});


/*
|--------------------------------------------------------------------------
| PENGHUNI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:penghuni'])->group(function () {

    Route::get('/penghuni/dashboard', [DashboardController::class, 'penghuni'])
        ->name('penghuni.dashboard');

    Route::get('/penghuni/kamar', [DashboardController::class, 'kamar'])
        ->name('penghuni.kamar');

    Route::get('/penghuni/pembayaran', [DashboardController::class, 'pembayaran'])
        ->name('penghuni.pembayaran');

 // Proses Pembayaran Penghuni
    Route::get('/penghuni/pembayaran/{id}/bayar', [PembayaranController::class, 'showPayment'])
    ->name('penghuni.pembayaran.bayar');

    Route::post('/penghuni/pembayaran/{id}/bukti', [PembayaranController::class, 'uploadProof'])
    ->name('penghuni.pembayaran.bukti');

    Route::get('/penghuni/keluhan', [KeluhanController::class, 'index'])
        ->name('penghuni.keluhan');

    Route::get('/penghuni/keluhan/create', [KeluhanController::class, 'create'])
        ->name('penghuni.keluhan.create');

    Route::post('/penghuni/keluhan', [KeluhanController::class, 'store'])
        ->name('penghuni.keluhan.store');

    Route::get('/penghuni/profil', [DashboardController::class, 'profil'])
    ->name('penghuni.profil');

    Route::get('/penghuni/profil/edit', [DashboardController::class, 'editProfil'])
    ->name('penghuni.profil.edit');

    Route::put('/penghuni/profil', [DashboardController::class, 'updateProfil'])
    ->name('penghuni.profil.update');

    // Ganti Password
    Route::get('/penghuni/ganti-password', [DashboardController::class, 'gantiPassword'])
    ->name('penghuni.password.edit');

    Route::put('/penghuni/ganti-password', [DashboardController::class, 'updatePassword'])
    ->name('penghuni.password.update');

    // Notifikasi Penghuni
    Route::get('/penghuni/notifikasi', function (\Illuminate\Http\Request $request) {

    auth()->user()->unreadNotifications->markAsRead();

    $query = auth()->user()->notifications();

    if ($request->filter === 'belum_dibaca') {
        $query->whereNull('read_at');
    } elseif ($request->filter === 'sudah_dibaca') {
        $query->whereNotNull('read_at');
    }

    $notifications = $query->latest()->paginate(10)->withQueryString();

    return view('penghuni.notifikasi', compact('notifications'));

    })->name('penghuni.notifikasi');
});
/*
|--------------------------------------------------------------------------
| TEKNISI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:teknisi'])->group(function () {

    Route::get('/teknisi/dashboard', [DashboardController::class, 'teknisi'])
        ->name('teknisi.dashboard');

    Route::get('/teknisi/tugas', [TeknisiTugasController::class, 'index'])
        ->name('teknisi.tugas.index');

    Route::put('/teknisi/tugas/{id}/status', [TeknisiTugasController::class, 'updateStatus'])
        ->name('teknisi.tugas.status');

    Route::get('/teknisi/profil', [TeknisiProfilController::class, 'index'])
        ->name('teknisi.profil');

    Route::put('/teknisi/profil', [TeknisiProfilController::class, 'update'])
        ->name('teknisi.profil.update');
    Route::put('/teknisi/profil/password', [TeknisiProfilController::class, 'updatePassword'])
        ->name('teknisi.profil.password');

});