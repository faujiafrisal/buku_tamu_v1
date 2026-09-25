<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'asal_instansi',
        'bidang_orang_ditemui',
        'jenis_kelamin',
        'usia',
        'jumlah_rombongan',
        'bidang_tujuan',
        'keperluan',
        'no_whatsapp',
        'jawaban_tambahan',
    ];

    /**
     * Cast attributes if needed.
     */
    protected $casts = [
        'usia' => 'integer',
        'jawaban_tambahan' => 'array',
    ];
}
