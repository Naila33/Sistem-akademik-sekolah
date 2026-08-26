<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Kelas;
use App\Models\CalonSiswa;

class SiswaKelas extends Model
{
    protected $table = 'siswa_kelas';

    protected $fillable = [
        'siswa_id',
        'kelas_id',
    ];

    public function siswa()
    {
        return $this->belongsTo(CalonSiswa::class, 'siswa_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }
}
