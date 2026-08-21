<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    // Menghubungkan ke nama tabel yang ada di phpMyAdmin
    protected $table = 'datasiswa';

    // Sesuaikan kolom ini dengan nama kolom di tabel datasiswa kamu
    protected $fillable = [
        'nisn',
        'nik',
        'nama',
        'jenis_kelamin',
        'alamat',
        'nama_orang_tua',
        'status',
    ];

    // Tambahkan ini jika tabel kamu TIDAK memiliki kolom created_at dan updated_at
    public $timestamps = false;
}