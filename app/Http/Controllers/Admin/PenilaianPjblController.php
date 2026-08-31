<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PenilaianPjbl;
use App\Models\Pjbl;
use App\Models\PjblPenguji;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenilaianPjblController extends Controller
{
   public function index(Request $request)
{
    $query = PenilaianPjbl::with([
        'siswa',
        'pjbl.kelas',
        'pjbl.tahunAjaran',
        'pjbl.penguji.guru',
        'pjblPenguji.guru',
    ]);

    if ($request->filled('search')) {

        $search = $request->search;

        $query->whereHas('siswa', function ($q) use ($search) {
            $q->where('nama', 'like', '%' . $search . '%');
        });
    }

    if ($request->filled('kelas_id')) {

        $kelasId = $request->kelas_id;

        $query->whereHas('pjbl', function ($q) use ($kelasId) {
            $q->where('kelas_id', $kelasId);
        });
    }

    $penilaian = $query
        ->latest()
        ->get();

    $kelas = \App\Models\Kelas::orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();

    $penilaianPerKelas = $penilaian->groupBy(function ($item) {
        return $item->pjbl?->kelas?->id ?? 0;
    });

    return view(
        'admin.penilaian.pjbl.index',
        compact(
            'penilaian',
            'kelas',
            'penilaianPerKelas'
        )
    );
}

    public function create()
{
    $pjbl = Pjbl::with([
        'kelas',
        'tahunAjaran',
    ])->get();

    $siswa = Siswa::orderBy('nama')->get();

    $penguji = PjblPenguji::with('guru')->get();

    $kelas = \App\Models\Kelas::orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();

    return view('admin.penilaian.pjbl.create', compact(
        'pjbl',
        'siswa',
        'penguji',
        'kelas'
    ));
}

    public function edit($id)
    {
        $penilaian = PenilaianPjbl::findOrFail($id);

        $pjbl = Pjbl::with([
            'kelas',
            'tahunAjaran',
        ])->get();

        $siswa = Siswa::orderBy('nama')->get();

        $penguji = PjblPenguji::with('guru')->get();

        return view('admin.penilaian.pjbl.edit', compact(
            'penilaian',
            'pjbl',
            'siswa',
            'penguji'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pjbl_id' => 'required|exists:pjbl,id',
            'pjbl_penguji_id' => 'required|exists:pjbl_penguji,id',
            'siswa_id' => 'required|exists:datasiswa,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        PenilaianPjbl::create([
            'pjbl_id' => $request->pjbl_id,
            'pjbl_penguji_id' => $request->pjbl_penguji_id,
            'siswa_id' => $request->siswa_id,
            'nilai' => $request->nilai,
        ]);

        return redirect()
            ->route('admin.penilaian.pjbl.index')
            ->with('success', 'Penilaian PJBL berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $penilaian = PenilaianPjbl::findOrFail($id);

        $request->validate([
            'pjbl_id' => 'required|exists:pjbl,id',
            'pjbl_penguji_id' => 'required|exists:pjbl_penguji,id',
            'siswa_id' => 'required|exists:datasiswa,id',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $penilaian->update([
            'pjbl_id' => $request->pjbl_id,
            'pjbl_penguji_id' => $request->pjbl_penguji_id,
            'siswa_id' => $request->siswa_id,
            'nilai' => $request->nilai,
        ]);

        return redirect()
            ->route('admin.penilaian.pjbl.index')
            ->with('success', 'Penilaian PJBL berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penilaian = PenilaianPjbl::findOrFail($id);

        $penilaian->delete();

        return redirect()
            ->route('admin.penilaian.pjbl.index')
            ->with('success', 'Penilaian PJBL berhasil dihapus.');
    }
}