<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use App\Models\PenilaianPjbl;
use App\Models\Pjbl;
use App\Models\PjblPenguji;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenilaianPjblController extends Controller
{
    /**
     * ============================================================
     * HALAMAN UTAMA
     * PILIH KELAS
     * ============================================================
     */
    public function index()
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])
        ->withCount('siswaKelas')
        ->orderBy('tingkat')
        ->orderBy('jurusan_id')
        ->orderBy('nama_kelas')
        ->get();

        return view(
            'admin.penilaian.pjbl.index',
            compact('kelas')
        );
    }


    /**
     * ============================================================
     * HALAMAN PJBL PER KELAS
     * ============================================================
     */
    public function kelas($kelasId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $pjbl = Pjbl::with([
            'tahunAjaran',
            'penguji.guru'
        ])
        ->where('kelas_id', $kelasId)
        ->latest('tanggal')
        ->get();

        return view(
            'admin.penilaian.pjbl.kelas',
            compact(
                'kelas',
                'pjbl'
            )
        );
    }


    /**
     * ============================================================
     * HALAMAN PENILAIAN PJBL
     * ============================================================
     */
    public function penilaian(Request $request, $kelasId, $pjblId)
{
    $kelas = \App\Models\Kelas::with('jurusan')
        ->findOrFail($kelasId);

    $pjbl = Pjbl::with([
        'kelas',
        'tahunAjaran',
        'penguji.guru',
    ])->findOrFail($pjblId);

    // Ambil maksimal 5 penguji
    $penguji = $pjbl->penguji
        ->take(5)
        ->values();

    // Query penilaian
    $query = PenilaianPjbl::with([
        'siswa',
        'pjblPenguji.guru',
    ])
    ->where('pjbl_id', $pjblId);

    // SEARCH SISWA
    if ($request->filled('search')) {

        $search = $request->search;

        $query->whereHas('siswa', function ($q) use ($search) {

            $q->where('nama', 'like', '%' . $search . '%')
              ->orWhere('nis', 'like', '%' . $search . '%')
              ->orWhere('nisn', 'like', '%' . $search . '%');

        });
    }

    $penilaian = $query
        ->orderBy('siswa_id')
        ->get();

    /*
    |--------------------------------------------------------------------------
    | KELOMPOKKAN BERDASARKAN SISWA
    |--------------------------------------------------------------------------
    */

    $penilaianPerSiswa = $penilaian
        ->groupBy('siswa_id');

    return view(
        'admin.penilaian.pjbl.penilaian',
        compact(
            'kelas',
            'pjbl',
            'penguji',
            'penilaian',
            'penilaianPerSiswa'
        )
    );
}


    /**
     * ============================================================
     * TAMBAH PENILAIAN
     * ============================================================
     */
    public function create($kelasId, $pjblId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $pjbl = Pjbl::with([
            'kelas',
            'tahunAjaran'
        ])
        ->where('id', $pjblId)
        ->where('kelas_id', $kelasId)
        ->firstOrFail();


        $penguji = PjblPenguji::with('guru')
            ->where('pjbl_id', $pjblId)
            ->get();


        /**
         * Siswa hanya dari kelas yang dipilih
         */
        $siswa = Siswa::whereHas('siswaKelas', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        })
        ->orderBy('nama')
        ->get();


        return view(
            'admin.penilaian.pjbl.create',
            compact(
                'kelas',
                'pjbl',
                'penguji',
                'siswa'
            )
        );
    }


    /**
     * ============================================================
     * SIMPAN PENILAIAN
     * ============================================================
     */
    public function store(Request $request, $kelasId, $pjblId)
    {
        $request->validate([

            'pjbl_penguji_id' =>
                'required|exists:pjbl_penguji,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'nilai' =>
                'required|numeric|min:0|max:100',

        ]);


        $pjbl = Pjbl::where('id', $pjblId)
            ->where('kelas_id', $kelasId)
            ->firstOrFail();


        PenilaianPjbl::create([

            'pjbl_id' =>
                $pjbl->id,

            'pjbl_penguji_id' =>
                $request->pjbl_penguji_id,

            'siswa_id' =>
                $request->siswa_id,

            'nilai' =>
                $request->nilai,

        ]);


        return redirect()
            ->route(
                'admin.penilaian.pjbl.penilaian',
                [
                    'kelasId' => $kelasId,
                    'pjblId' => $pjblId
                ]
            )
            ->with(
                'success',
                'Penilaian PJBL berhasil ditambahkan.'
            );
    }


    /**
     * ============================================================
     * EDIT
     * ============================================================
     */
    public function edit($kelasId, $pjblId, $id)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);


        $pjbl = Pjbl::with([
            'kelas',
            'tahunAjaran'
        ])
        ->where('id', $pjblId)
        ->where('kelas_id', $kelasId)
        ->firstOrFail();


        $penilaian = PenilaianPjbl::with([
            'siswa',
            'pjblPenguji'
        ])
        ->where('id', $id)
        ->where('pjbl_id', $pjblId)
        ->firstOrFail();


        $penguji = PjblPenguji::with('guru')
            ->where('pjbl_id', $pjblId)
            ->get();


        $siswa = Siswa::whereHas('siswaKelas', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        })
        ->orderBy('nama')
        ->get();


        return view(
            'admin.penilaian.pjbl.edit',
            compact(
                'kelas',
                'pjbl',
                'penilaian',
                'penguji',
                'siswa'
            )
        );
    }


    /**
     * ============================================================
     * UPDATE
     * ============================================================
     */
    public function update(
        Request $request,
        $kelasId,
        $pjblId,
        $id
    ) {

        $penilaian = PenilaianPjbl::where('id', $id)
            ->where('pjbl_id', $pjblId)
            ->firstOrFail();


        $request->validate([

            'pjbl_penguji_id' =>
                'required|exists:pjbl_penguji,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'nilai' =>
                'required|numeric|min:0|max:100',

        ]);


        $penilaian->update([

            'pjbl_penguji_id' =>
                $request->pjbl_penguji_id,

            'siswa_id' =>
                $request->siswa_id,

            'nilai' =>
                $request->nilai,

        ]);


        return redirect()
            ->route(
                'admin.penilaian.pjbl.penilaian',
                [
                    'kelasId' => $kelasId,
                    'pjblId' => $pjblId
                ]
            )
            ->with(
                'success',
                'Penilaian PJBL berhasil diperbarui.'
            );
    }


    /**
     * ============================================================
     * HAPUS
     * ============================================================
     */
    public function destroy($kelasId, $pjblId, $id)
    {
        $penilaian = PenilaianPjbl::where('id', $id)
            ->where('pjbl_id', $pjblId)
            ->firstOrFail();


        $penilaian->delete();


        return redirect()
            ->route(
                'admin.penilaian.pjbl.penilaian',
                [
                    'kelasId' => $kelasId,
                    'pjblId' => $pjblId
                ]
            )
            ->with(
                'success',
                'Penilaian PJBL berhasil dihapus.'
            );
    }
}