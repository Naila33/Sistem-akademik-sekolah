<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Menghubungkan ke nama tabel yang ada di phpMyAdmin
    protected $table = 'dataguru';

    // Sesuaikan kolom ini dengan nama kolom di tabel dataguru kamu
    protected $fillable = [
        'nip',
        'nama',
        'jenis_kelamin',
        'kontak',
        'alamat',
        'status',
        'kode_guru',
    ];

    // Tambahkan ini jika tabel kamu TIDAK memiliki kolom created_at dan updated_at
    public $timestamps = false;
}