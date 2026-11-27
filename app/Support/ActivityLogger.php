<?php

namespace App\Support;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    public static function log($aktivitas, $deskripsi = null)
    {
        $user = Auth::user();

        ActivityLog::create([
            'user_id' => $user?->id,
            'nama_pengguna' => $user?->name ?? 'System',
            'role' => $user?->role ?? 'system',
            'aktivitas' => $aktivitas,
            'deskripsi' => $deskripsi,
        ]);
    }
}