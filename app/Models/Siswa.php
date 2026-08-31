<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    use HasFactory;

    protected $table = 'datasiswa';

    protected $fillable = [
        'nis',
        'nisn',
        'nama',
        'tempat_lahir',
        'tanggal_lahir',
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
        'tanggal_lahir' => 'date:Y-m-d',
    ];

    public $timestamps = false;


    public static function generateNis()
    {
        $lastSiswa = self::orderBy('nis', 'desc')->first();

        if (!$lastSiswa) {
            return '0001';
        }

        $lastNis = (int) $lastSiswa->nis;
        $newNis = $lastNis + 1;

        return str_pad($newNis, 4, '0', STR_PAD_LEFT);
    }

    public function siswaKelas()
    {
        return $this->hasMany(SiswaKelas::class, 'siswa_id');
    }

    public function pembagianKelas()
    {
        return $this->hasMany(PembagianKelas::class);
    }
}
