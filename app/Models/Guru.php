<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guru extends Model
{
    use HasFactory;

    // Menghubungkan ke nama tabel yang ada di phpMyAdmin
    protected $table = 'dataguru';

    // Sesuaikan kolom ini dengan nama kolom di tabel dataguru kamu
    protected $fillable = [
        'nip',
        'nama',
        'jk',
        'tgl_lahir',
        'agama',
        'alamat',
        'no_hp',
        'email',
        'status_kepegawaian',
        'jabatan',
        'tmt',
        'mata_pelajaran_id',
    ];

    protected $casts = [
        'tgl_lahir' => 'date:Y-m-d',
        'tmt' => 'date:Y-m-d',
    ];

    public function mataPelajaran()
    {
        return $this->belongsTo(MataPelajaran::class, 'mata_pelajaran_id');
    }

    // Tambahkan ini jika tabel kamu TIDAK memiliki kolom created_at dan updated_at
    public $timestamps = false;

    public function pjblPenguji()
{
    return $this->hasMany(
        PjblPenguji::class,
        'guru_id'
    );
}
}
