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
        'periode',
        'tanggal',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function tahunAjaran()
    {
        return $this->belongsTo(TahunAjaran::class);
    }

    public function penguji()
    {
        return $this->hasMany(PjblPenguji::class);
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianPjbl::class);
    }
}