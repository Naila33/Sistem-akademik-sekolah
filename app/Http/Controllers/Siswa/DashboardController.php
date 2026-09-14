<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;
        $kelas = $siswa?->siswaKelas?->first()?->kelas;
        $jadwal = $kelas?->jadwal?->load('mapel', 'guru', 'ruangan') ?? new Collection();

        return view('siswa.dashboard', compact('siswa', 'kelas', 'jadwal'));
    }
}
