<?php

namespace App\Http\Controllers;
use App\Models\Keluhan;
use App\Models\User;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;

class AdminKeluhanController extends Controller
{
    // Menampilkan semua keluhan
    public function index()
    {
        $keluhans = Keluhan::with([
            'penghuni.user',
            'kamar',
            'teknisi'
        ])->latest()->get();

        // Mengambil akun yang memiliki role teknisi
        $teknisis = User::where('role', 'teknisi')->get();

        return view('admin.keluhan.index', compact(
            'keluhans',
            'teknisis'
        ));
    }

    // Menugaskan teknisi
    public function assign(Request $request, $id)
    {
        $request->validate([
            'teknisi_id' => 'required|exists:users,id',
        ]);

        $teknisi = User::where('id', $request->teknisi_id)
            ->where('role', 'teknisi')
            ->first();

        if (!$teknisi) {
            return back()->with('error', 'Akun yang dipilih bukan teknisi.');
        }

        $keluhan = Keluhan::findOrFail($id);

        $keluhan->update([
            'teknisi_id' => $teknisi->id,
            'status' => 'diproses',
        ]);

        ActivityLogger::log(
            'Menugaskan Teknisi',
            'Admin menugaskan teknisi ' . $teknisi->name .
            ' untuk menangani keluhan: ' . $keluhan->judul
        );

        return redirect()->route('admin.keluhan.index')
            ->with('success', 'Teknisi berhasil ditugaskan.');
    }
}
