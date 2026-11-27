<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QrisSetting extends Model
{
    protected $fillable = [
        'nama_pemilik',
        'gambar_qris',
    ];
}
