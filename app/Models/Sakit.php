<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sakit extends Model
{
    protected $table = 'sakit';

    protected $fillable = [
        'siswa_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'alasan',
        'dokumen',
        'status_wali_kelas',
        'catatan_wali_kelas',
        'status',
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

    public function guru()
    {
        return $this->hasMany(
            SakitGuru::class,
            'sakit_id'
        );
    }
}