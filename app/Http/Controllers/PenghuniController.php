<?php

namespace App\Http\Controllers;

use App\Models\Penghuni;
use App\Models\Kamar;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Support\ActivityLogger;

class PenghuniController extends Controller
{
    public function index()
    {
        $penghunis = Penghuni::with(['user', 'kamar'])
            ->latest()
            ->get();

        return view('penghuni.index', compact('penghunis'));
    }

    public function create()
    {
        $kamars = Kamar::where('status', 'kosong')
            ->orderBy('nomor_kamar')
            ->get();

        return view('penghuni.create', compact('kamars'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|string|min:6',

            'nik' => 'required|digits:16|unique:penghuni,nik',

            'no_hp' => 'required|string|max:20',

            'alamat' => 'nullable|string',

            'kamar_id' => 'nullable|exists:kamar,id',

            'tanggal_masuk' => 'required|date',

            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
        ]);


        /*
        |--------------------------------------------------------------------------
        | 1. Buat akun user
        |--------------------------------------------------------------------------
        */

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'penghuni',
        ]);

        /*
        |--------------------------------------------------------------------------
        | 2. Buat data penghuni
        |--------------------------------------------------------------------------
        */

        Penghuni::create([
            'user_id' => $user->id,
            'kamar_id' => $request->kamar_id,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        /*
        |--------------------------------------------------------------------------
        | 3. Kalau memilih kamar, ubah status kamar menjadi terisi
        |--------------------------------------------------------------------------
        */

        if ($request->kamar_id) {
            Kamar::where('id', $request->kamar_id)
                ->update([
                    'status' => 'terisi'
                ]);
        }
        ActivityLogger::log(
            'Menambahkan Penghuni',
            'Admin menambahkan penghuni: ' . $request->name
        );
        return redirect()
            ->route('penghuni.index')
            ->with('success', 'Penghuni dan akun login berhasil dibuat!');
    }

    public function edit(Penghuni $penghuni)
    {
        $kamars = Kamar::where('status', 'kosong')
            ->orWhere('id', $penghuni->kamar_id)
            ->orderBy('nomor_kamar')
            ->get();

        return view('penghuni.edit', compact('penghuni', 'kamars'));
    }

    public function update(Request $request, Penghuni $penghuni)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',

            'kamar_id' => 'nullable|exists:kamar,id',

            'nik' => 'required|digits:16|unique:penghuni,nik,' . $penghuni->id,

            'no_hp' => 'required|string|max:20',

            'alamat' => 'nullable|string',

            'tanggal_masuk' => 'required|date',

            'tanggal_keluar' => 'nullable|date|after_or_equal:tanggal_masuk',
        ]);

        $kamarLama = $penghuni->kamar_id;

        $penghuni->update([
            'user_id' => $request->user_id,
            'kamar_id' => $request->kamar_id,
            'nik' => $request->nik,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'tanggal_masuk' => $request->tanggal_masuk,
            'tanggal_keluar' => $request->tanggal_keluar,
        ]);

        if ($kamarLama && $kamarLama != $request->kamar_id) {
            Kamar::where('id', $kamarLama)
                ->update([
                    'status' => 'kosong'
                ]);
        }

        if ($request->kamar_id) {
            Kamar::where('id', $request->kamar_id)
                ->update([
                    'status' => 'terisi'
                ]);
        }
        ActivityLogger::log(
            'Mengubah Data Penghuni',
            'Admin memperbarui data penghuni: ' . $penghuni->user->name
        );
        return redirect()
            ->route('penghuni.index')
            ->with('success', 'Data penghuni berhasil diperbarui!');
    }

    public function destroy(Penghuni $penghuni)
    {
    $namaPenghuni = $penghuni->user->name;
    $kamarId = $penghuni->kamar_id;

    $penghuni->delete();

    if ($kamarId) {
        Kamar::where('id', $kamarId)
            ->update([
                'status' => 'kosong'
            ]);
        }

    ActivityLogger::log(
        'Menghapus Penghuni',
        'Admin menghapus data penghuni: ' . $namaPenghuni
        );

    return redirect()
        ->route('penghuni.index')
        ->with('success', 'Data penghuni berhasil dihapus!');
    }
}