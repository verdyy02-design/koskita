<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    protected $fillable = [
        'user_id',
        'nama_pengguna',
        'role',
        'aktivitas',
        'deskripsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}