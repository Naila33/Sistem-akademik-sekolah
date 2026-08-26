<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PjblPenguji extends Model
{
    use HasFactory;

    protected $table = 'pjbl_penguji';

    protected $fillable = [
        'pjbl_id',
        'guru_id',
        'jenis_penguji',
    ];

    public function pjbl()
    {
        return $this->belongsTo(Pjbl::class);
    }

    public function guru()
    {
        return $this->belongsTo(Guru::class);
    }

    public function penilaian()
    {
        return $this->hasMany(PenilaianPjbl::class);
    }
}