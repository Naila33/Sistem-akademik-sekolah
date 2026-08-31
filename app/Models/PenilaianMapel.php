<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianMapel extends Model
{
    protected $table = 'penilaian_mapel';

    protected $primaryKey = 'id';

    public $incrementing = true;

    protected $keyType = 'int';

    public $timestamps = true;

    protected $fillable = [
        'jadwal_pelajaran_id',
        'siswa_id',
        'jenis_nilai',
        'nilai',
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', 'id');
    }

    public function jadwal()
    {
        return $this->belongsTo(Jadwal_Pelajaran::class, 'jadwal_pelajaran_id', 'id');
    }
}