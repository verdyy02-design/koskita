<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Penghuni extends Model
{
    protected $table = 'penghuni';

    protected $fillable = [
        'user_id',
        'kamar_id',
        'nik',
        'no_hp',
        'alamat',
        'tanggal_masuk',
        'tanggal_keluar',
    ];

    public function keluhan(): HasMany
    {
    return $this->hasMany(Keluhan::class, 'penghuni_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class);
    }

    public function pembayaran(): HasMany
    {
    return $this->hasMany(Pembayaran::class, 'penghuni_id');
    }
}