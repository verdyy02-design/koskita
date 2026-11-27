<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenugasanTeknisi extends Model
{
   protected $table = 'penugasan_teknisi';

    protected $fillable = [
        'keluhan_id',
        'teknisi_id',
        'tanggal_penugasan',
        'catatan',
        'status',
        'selesai_at',
    ];

    public function keluhan(): BelongsTo
    {
        return $this->belongsTo(Keluhan::class);
    }

    public function teknisi(): BelongsTo
    {
        return $this->belongsTo(Teknisi::class);
    }
}