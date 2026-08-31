<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pjbl extends Model
{
    use HasFactory;

    protected $table = 'pjbl';

    protected $fillable = [
        'kelas_id',
        'tahun_ajaran_id',
        'tanggal',
        'periode',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    public function tahunAjaran()
{
    return $this->belongsTo(
        TahunAjaran::class,
        'tahun_ajaran_id',
        'id'
    );
}

    /**
     * Penguji PJBL
     */
    public function penguji()
    {
        return $this->hasMany(PjblPenguji::class, 'pjbl_id');
    }
}