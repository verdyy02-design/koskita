<?php

namespace App\Http\Controllers;
use App\Models\Keluhan;
use App\Models\Penghuni;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;

class KeluhanController extends Controller
{
    public function index()
    {
        $penghuni = Penghuni::where('user_id', auth()->id())->first();

        if (!$penghuni) {
            return redirect()->route('penghuni.dashboard')
                ->with('error', 'Data penghuni tidak ditemukan.');
        }

        $keluhans = Keluhan::where('penghuni_id', $penghuni->id)
            ->latest()
            ->get();

        return view('penghuni.keluhan.index', compact('keluhans'));
    }

    public function create()
    {
        return view('penghuni.keluhan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'deskripsi' => 'required|string',
        ]);

        $penghuni = Penghuni::where('user_id', auth()->id())->first();

        if (!$penghuni) {
            return back()->with('error', 'Data penghuni tidak ditemukan.');
        }

       Keluhan::create([
        'penghuni_id' => $penghuni->id,
        'kamar_id' => $penghuni->kamar_id,
        'judul' => $request->judul,
        'kategori' => $request->kategori,
        'deskripsi' => $request->deskripsi,
        'status' => 'menunggu',
       ]);
        ActivityLogger::log(
            'Mengirim Keluhan',
            'Penghuni mengirim keluhan: ' . $request->judul .
            ' (Kategori: ' . $request->kategori . ')'
        );
        return redirect()->route('penghuni.keluhan')
            ->with('success', 'Keluhan berhasil dikirim.');
    }
}
