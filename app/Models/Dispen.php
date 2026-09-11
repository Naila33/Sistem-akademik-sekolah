<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dispen extends Model
{
    protected $table = 'dispen';

    protected $fillable = [
        'siswa_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'dokumen',
        'status_kesiswaan',
        'catatan_kesiswaan',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function siswa()
    {
        return $this->belongsTo(
            DataSiswa::class,
            'siswa_id'
        );
    }
}