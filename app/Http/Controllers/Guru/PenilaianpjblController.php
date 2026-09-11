<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;
use App\Models\PenilaianPjbl;
use App\Models\PjblPenguji;
use Illuminate\Http\Request;

class PenilaianPjblController extends Controller
{
    public function index()
    {
        
        // Ambil data guru yang sedang login
        $guru = auth()->user()?->guru;

        // Kalau akun belum terhubung ke data guru
        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        // Ambil PjBL yang ditugaskan kepada guru ini sebagai penguji
        $pjblPenguji = PjblPenguji::with([
            'pjbl.kelas',
            'pjbl.tahunAjaran',
        ])
            ->where('guru_id', $guru->id)
            ->get();

        return view('guru.penilaian.pjbl.index', compact(
            'pjblPenguji',
            'guru'
        ));
    }

    public function nilai($pjblId)
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        // Pastikan guru memang ditugaskan sebagai penguji PjBL ini
        $penguji = PjblPenguji::with([
            'pjbl.kelas',
            'pjbl.tahunAjaran',
        ])
            ->where('pjbl_id', $pjblId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $pjbl = $penguji->pjbl;
        $siswaKelas = $pjbl->kelas
            ->siswaKelas()
            ->with('siswa')
            ->get();

        return view('guru.penilaian.pjbl.nilai', compact(
            'pjbl',
            'penguji',
            'guru',
            'siswaKelas'
        ));
    }

    public function simpan(Request $request, $pjblId)
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        $penguji = PjblPenguji::with('pjbl.kelas')
            ->where('pjbl_id', $pjblId)
            ->where('guru_id', $guru->id)
            ->firstOrFail();

        $validated = $request->validate([
            'nilai' => 'required|array',
            'nilai.*' => 'required|numeric|min:0|max:100',
        ]);

        $siswaIds = $penguji->pjbl->kelas
            ->siswaKelas()
            ->pluck('siswa_id')
            ->all();

        foreach ($validated['nilai'] as $siswaId => $nilai) {
            if (!in_array((int) $siswaId, $siswaIds, true)) {
                abort(422, 'Siswa tidak terdaftar di kelas PJBL ini.');
            }

            PenilaianPjbl::updateOrCreate(
                [
                    'pjbl_id' => $pjblId,
                    'pjbl_penguji_id' => $penguji->id,
                    'siswa_id' => $siswaId,
                ],
                ['nilai' => $nilai]
            );
        }

        return redirect()
            ->route('guru.penilaian-pjbl.index')
            ->with('success', 'Penilaian PJBL berhasil disimpan.');
    }
}
