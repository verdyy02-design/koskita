<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use App\Support\ActivityLogger;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::latest()->get();

        return view('kamar.index', compact('kamars'));
    }

    public function create()
    {
        return view('kamar.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar',
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:kosong,terisi,perbaikan',
        ]);

        Kamar::create($request->all());
        ActivityLogger::log(
            'Menambahkan Kamar',
            'Admin menambahkan kamar nomor ' . $request->nomor_kamar
        );

        return redirect()
            ->route('kamar.index')
            ->with('success', 'Kamar berhasil ditambahkan!');
    }

    public function edit(Kamar $kamar)
    {
        return view('kamar.edit', compact('kamar'));
    }

    public function update(Request $request, Kamar $kamar)
    {
        $request->validate([
            'nomor_kamar' => 'required|unique:kamar,nomor_kamar,' . $kamar->id,
            'harga' => 'required|numeric',
            'fasilitas' => 'nullable|string',
            'status' => 'required|in:kosong,terisi,perbaikan',
        ]);

        $kamar->update($request->all());
        ActivityLogger::log(
            'Mengubah Data Kamar',
            'Admin memperbarui data kamar nomor ' . $kamar->nomor_kamar
        );

        return redirect()
            ->route('kamar.index')
            ->with('success', 'Data kamar berhasil diperbarui!');
    }

    public function destroy(Kamar $kamar)
    {
    $nomorKamar = $kamar->nomor_kamar;

    $kamar->delete();

    ActivityLogger::log(
        'Menghapus Kamar',
        'Admin menghapus kamar nomor ' . $nomorKamar
        );

    return redirect()
        ->route('kamar.index')
        ->with('success', 'Kamar berhasil dihapus!');
    }
}