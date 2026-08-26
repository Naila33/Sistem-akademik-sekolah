<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_pelajaran;
use App\Models\Penilaian;
use Illuminate\Http\Request;

class PenilaianController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.penilaian.index', compact('jadwal'));
    }

    public function create($jadwalId)
    {
        $guru = auth()->user()->guru;

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'kelas.siswaKelas.siswa'
        ])
            ->where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $siswa = $jadwal->kelas?->siswaKelas
            ->pluck('siswa')
            ->filter()
            ->values() ?? collect();

        return view('guru.penilaian.create', compact(
            'jadwal',
            'siswa'
        ));
    }

    public function store(Request $request, $jadwalId)
    {
        $guru = auth()->user()->guru;

        $jadwal = Jadwal_pelajaran::where('id', $jadwalId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $request->validate([
            'jenis_nilai' => 'required|in:harian,ujian',
            'nilai' => 'required|array',
            'nilai.*' => 'nullable|numeric|min:0|max:100',
        ]);

        foreach ($request->nilai as $siswaId => $nilai) {

            if ($nilai === null || $nilai === '') {
                continue;
            }

            Penilaian::updateOrCreate(
                [
                    'jadwal_pelajaran_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'jenis_nilai' => $request->jenis_nilai,
                ],
                [
                    'nilai' => $nilai,
                ]
            );
        }

        return redirect()
            ->route('guru.penilaian.create', $jadwal->id)
            ->with('success', 'Nilai berhasil disimpan.');
    }
}
