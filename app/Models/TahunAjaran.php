<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TahunAjaran extends Model
{
    use HasFactory;

    // Memberitahu Laravel nama tabel yang benar di database
    protected $table = 'tahun_ajaran';

    // Kolom yang diizinkan untuk diisi data
    protected $fillable = [
        'tahun_ajaran',
        'semester',
        'status',
    ];

    // Mengubah tipe data 'status' otomatis menjadi boolean saat dipanggil
    protected $casts = [
        'status' => 'boolean',
    ];
}