<?php

namespace App\Models;

<<<<<<< Updated upstream
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
=======
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
>>>>>>> Stashed changes

class Jurusan extends Model
{
    use HasFactory;

    protected $table = 'jurusan';

    protected $fillable = [
        'nama_jurusan',
        'kode_jurusan',
    ];

<<<<<<< Updated upstream
    public $timestamps = false;
=======
    public function calonSiswa()
    {
        return $this->hasMany(
            CalonSiswa::class,
            'jurusan_id'
        );
    }
>>>>>>> Stashed changes
}