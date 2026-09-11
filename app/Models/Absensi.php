<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Absensi extends Model
{
    protected $table = 'absensi';

    protected $fillable = [
        'sesi_absensi_id',
        'siswa_id',
        'waktu_absen',
        'status',
        'keterangan',
    ];

    protected $casts = [
        'waktu_absen' => 'datetime',
    ];

    public function sesi()
    {
        return $this->belongsTo(
            SesiAbsensi::class,
            'sesi_absensi_id'
        );
    }

    public function siswa()
    {
        return $this->belongsTo(
            DataSiswa::class,
            'siswa_id'
        );
    }
}