<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;

class WaliKelasController extends Controller
{
    public function index()
    {
        $guruId = 1;

        $kelas = Kelas::where('wali_kelas_id', $guruId)->get();

        return view('wali-kelas.index', compact('kelas'));
    }

    public function siswa(Kelas $kelas)
    {
        $kelas->load(['waliKelas', 'jurusan', 'tahunAjaran']);
        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $kelas->id)
            ->get();

        return view('wali-kelas.siswa', compact('kelas', 'siswa'));
    }

    public function nilai(Siswa $siswa)
    {
        return view('wali-kelas.nilai', compact('siswa'));
    }

    public function rapor(Siswa $siswa)
    {
        return view('wali-kelas.rapor', compact('siswa'));
    }
}
