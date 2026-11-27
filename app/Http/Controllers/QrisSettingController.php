<?php

namespace App\Http\Controllers;

use App\Models\QrisSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QrisSettingController extends Controller
{
    public function index()
    {
        $qris = QrisSetting::first();

        return view('admin.qris.index', compact('qris'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_pemilik' => 'nullable|string|max:255',
            'gambar_qris' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'gambar_qris.image' => 'File harus berupa gambar.',
            'gambar_qris.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'gambar_qris.max' => 'Ukuran gambar maksimal 2 MB.',
        ]);

        $qris = QrisSetting::first();

        if (!$qris) {
            $qris = new QrisSetting();
        }

        $qris->nama_pemilik = $request->nama_pemilik;

        if ($request->hasFile('gambar_qris')) {
            if ($qris->gambar_qris) {
                Storage::disk('public')->delete($qris->gambar_qris);
            }

            $qris->gambar_qris = $request->file('gambar_qris')
                ->store('qris', 'public');
        }

        $qris->save();

        return back()->with('success', 'Pengaturan QRIS berhasil diperbarui!');
    }

    public function destroy()
    {
        $qris = QrisSetting::first();

        if ($qris && $qris->gambar_qris) {
            Storage::disk('public')->delete($qris->gambar_qris);

            $qris->gambar_qris = null;
            $qris->save();
        }

        return back()->with('success', 'Gambar QRIS berhasil dihapus!');
    }
}
