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
        'jk',
        'alamat',
        'nama_orang_tua',
        'status',
    ];

    public function pembagianKelas()
{
    return $this->hasMany(PembagianKelas::class);
}
}