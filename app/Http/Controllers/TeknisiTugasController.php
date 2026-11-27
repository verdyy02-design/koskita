<?php

namespace App\Http\Controllers;

use App\Models\Keluhan;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;

class TeknisiTugasController extends Controller
{
    // Menampilkan tugas teknisi
    public function index()
    {
        $keluhans = Keluhan::with([
            'penghuni.user',
            'kamar'
        ])
        ->where('teknisi_id', auth()->id())
        ->latest()
        ->get();

        return view('teknisi.tugas.index', compact('keluhans'));
    }

    // Memperbarui status tugas
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:diproses,selesai',
        ]);

        $keluhan = Keluhan::where('teknisi_id', auth()->id())
            ->findOrFail($id);

        $keluhan->status = $request->status;

        if ($request->status === 'selesai') {
            $keluhan->tanggal_selesai = now();
        } else {
            $keluhan->tanggal_selesai = null;
        }

        $keluhan->save();

        $aktivitas = $request->status === 'selesai'
            ? 'Menyelesaikan Tugas'
            : 'Memproses Tugas';

        ActivityLogger::log(
            $aktivitas,
            'Teknisi memperbarui status keluhan "' . $keluhan->judul .
            '" menjadi ' . $request->status
        );

        return back()->with('success', 'Status tugas berhasil diperbarui.');
    }
}