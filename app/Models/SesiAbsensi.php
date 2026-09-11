<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SesiAbsensi extends Model
{
    protected $table = 'sesi_absensi';

    protected $fillable = [
        'jadwal_pelajaran_id',
        'kode',
        'tanggal',
        'waktu_mulai',
        'waktu_selesai',
        'status',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function jadwal()
    {
        return $this->belongsTo(
            JadwalPelajaran::class,
            'jadwal_pelajaran_id'
        );
    }

    public function absensi()
    {
        return $this->hasMany(
            Absensi::class,
            'sesi_absensi_id'
        );
    }
}