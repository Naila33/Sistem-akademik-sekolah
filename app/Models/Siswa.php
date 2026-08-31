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
        'nis',
        'nisn',
        'nama',
        'jk',
        'tempat_lahir',
        'tgl_lahir',
        'agama',
        'nik',
        'no_kk',
        'alamat',
        'no_hp',
        'email',
    ];

    protected $casts = [
        'tgl_lahir' => 'date:Y-m-d',
    ];

    public $timestamps = false;

    public function pembagianKelas()
{
    return $this->hasMany(PembagianKelas::class);
}
}