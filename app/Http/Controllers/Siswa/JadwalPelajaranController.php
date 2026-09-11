<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;
use App\Models\SiswaKelas;

class JadwalPelajaranController extends Controller
{
    public function index()
    {
        // Ambil data siswa yang sedang login
        $siswa = auth()->user()->siswa;
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu',
        ];
        $jumlahJpPerHari = [
            'Senin' => 10,
            'Selasa' => 12,
            'Rabu' => 10,
            'Kamis' => 12,
            'Jumat' => 6,
        ];

        // Pastikan akun sudah terhubung dengan data siswa
        if (!$siswa) {
            abort(403, 'Akun Anda belum terhubung dengan data siswa.');
        }

        // Cari kelas siswa melalui tabel siswa_kelas
        $siswaKelas = SiswaKelas::where('siswa_id', $siswa->id)
            ->first();

        // Kalau siswa belum memiliki kelas
        if (!$siswaKelas) {
            return view('siswa.jadwal.index', [
                'jadwal' => collect(),
                'hari' => $hari,
                'kelas' => null,
                'jumlahJpPerHari' => $jumlahJpPerHari,
            ]);
        }

        $kelas = $siswaKelas->kelas;
        // Ambil semua jadwal untuk kelas siswa
        // yang sudah diterbitkan oleh admin
        $jadwal = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mapel',
            'guru',
            'ruangan',
        ])
            ->where('kelas_id', $siswaKelas->kelas_id)
            ->where('is_published', 1)
            ->get();

        return view('siswa.jadwal.index', compact('jadwal', 'hari', 'kelas', 'jumlahJpPerHari'));
    }
}
