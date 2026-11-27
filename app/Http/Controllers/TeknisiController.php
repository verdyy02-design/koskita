<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Support\ActivityLogger;

class TeknisiController extends Controller
{
    // Menampilkan daftar teknisi
    public function index()
    {
        $teknisis = User::where('role', 'teknisi')
            ->latest()
            ->get();

        return view('admin.teknisi.index', compact('teknisis'));
    }

    // Menampilkan form tambah teknisi
    public function create()
    {
        return view('admin.teknisi.create');
    }

    // Menyimpan teknisi baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'teknisi',
        ]);

        ActivityLogger::log(
            'Menambahkan Teknisi',
            'Admin menambahkan akun teknisi: ' . $request->name
            );

        return redirect()->route('teknisi.index')
            ->with('success', 'Akun teknisi berhasil ditambahkan.');
    }

    // Menampilkan form edit teknisi
    public function edit($id)
    {
        $teknisi = User::where('role', 'teknisi')
            ->findOrFail($id);

        return view('admin.teknisi.edit', compact('teknisi'));
    }

    // Memperbarui data teknisi
    public function update(Request $request, $id)
    {
        $teknisi = User::where('role', 'teknisi')
            ->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($teknisi->id),
            ],
            'password' => 'nullable|string|min:8',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $teknisi->update($data);

        ActivityLogger::log(
            'Mengubah Data Teknisi',
            'Admin memperbarui data teknisi: ' . $teknisi->name
            );

        return redirect()->route('teknisi.index')
            ->with('success', 'Data teknisi berhasil diperbarui.');
    }

    // Menghapus akun teknisi
    public function destroy($id)
    {
        $teknisi = User::where('role', 'teknisi')
            ->findOrFail($id);

        ActivityLogger::log(
            'Menghapus Teknisi',
            'Admin menghapus akun teknisi: ' . $teknisi->name
            );

        $teknisi->delete();

        return redirect()->route('teknisi.index')
            ->with('success', 'Akun teknisi berhasil dihapus.');
    }
}