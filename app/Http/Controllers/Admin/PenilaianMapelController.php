<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Jadwal_Pelajaran;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\PenilaianMapel;
use App\Models\Siswa;
use Illuminate\Http\Request;

class PenilaianMapelController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX KELAS
    |--------------------------------------------------------------------------
    */

    public function index()
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])
        ->orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();

        return view(
            'admin.penilaian.mapel.index',
            compact('kelas')
        );
    }

    public function kelas($kelasId)
{
    $kelas = Kelas::with([
        'jurusan',
        'tahunAjaran'
    ])->findOrFail($kelasId);

    $mataPelajaran = MataPelajaran::whereHas('jadwal', function ($query) use ($kelasId) {
        $query->where('kelas_id', $kelasId);
    })
    ->orderBy('nama_mapel')
    ->get();

    return view(
        'admin.penilaian.mapel.kelas',
        compact('kelas', 'mataPelajaran')
    );
}


    /*
    |--------------------------------------------------------------------------
    | HALAMAN MAPEL BERDASARKAN KELAS
    |--------------------------------------------------------------------------
    */

    public function mapel(Request $request, $kelasId, $mapelId)
{
    $kelas = Kelas::with([
        'jurusan',
        'tahunAjaran'
    ])->findOrFail($kelasId);

    // SATU mata pelajaran
    $mataPelajaran = MataPelajaran::findOrFail($mapelId);

    $query = PenilaianMapel::with([
        'siswa',
        'jadwal.guru',
        'jadwal.mataPelajaran',
    ])
    ->whereHas('jadwal', function ($q) use ($kelasId, $mapelId) {

        $q->where('kelas_id', $kelasId)
          ->where('mata_pelajaran_id', $mapelId);

    });

    // SEARCH SISWA
    if ($request->filled('search')) {

        $search = $request->search;

        $query->whereHas('siswa', function ($q) use ($search) {

            $q->where('nama', 'like', "%{$search}%")
              ->orWhere('nis', 'like', "%{$search}%")
              ->orWhere('nisn', 'like', "%{$search}%");

        });
    }

    // FILTER JENIS NILAI
    if ($request->filled('jenis_nilai')) {

        $query->where(
            'jenis_nilai',
            $request->jenis_nilai
        );

    }

    $penilaian = $query
        ->latest()
        ->get();

    return view(
        'admin.penilaian.mapel.mapel',
        compact(
            'kelas',
            'mataPelajaran',
            'penilaian'
        )
    );
}


    /*
    |--------------------------------------------------------------------------
    | TABEL PENILAIAN BERDASARKAN KELAS + MAPEL
    |--------------------------------------------------------------------------
    */

    public function nilai(Request $request, $kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $query = PenilaianMapel::with([
            'siswa',
            'jadwal.mataPelajaran',
            'jadwal.kelas',
            'jadwal.guru'
        ])
        ->whereHas('jadwal', function ($q) use (
            $kelasId,
            $mapelId
        ) {

            $q->where('kelas_id', $kelasId)
              ->where(
                  'mata_pelajaran_id',
                  $mapelId
              );

        });


        /*
        |----------------------------------------------------------------------
        | SEARCH SISWA
        |----------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {

                $q->where('nama', 'like', '%' . $search . '%')
                  ->orWhere('nis', 'like', '%' . $search . '%')
                  ->orWhere('nisn', 'like', '%' . $search . '%');

            });

        }


        /*
        |----------------------------------------------------------------------
        | FILTER JENIS NILAI
        |----------------------------------------------------------------------
        */

        if ($request->filled('jenis_nilai')) {

            $query->where(
                'jenis_nilai',
                $request->jenis_nilai
            );

        }


        $penilaian = $query
            ->latest()
            ->get();


        return view(
            'admin.penilaian.mapel.nilai',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create($kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);


        /*
        | Ambil jadwal mapel pada kelas tersebut
        */

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])
        ->where('kelas_id', $kelasId)
        ->where(
            'mata_pelajaran_id',
            $mapelId
        )
        ->get();


        return view(
            'admin.penilaian.mapel.create',
            compact(
                'kelas',
                'mataPelajaran',
                'jadwal'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SEARCH SISWA VIA AJAX
    |--------------------------------------------------------------------------
    */

    public function searchSiswa(Request $request, $kelasId)
    {
        $search = trim(
            $request->get('search', '')
        );


        /*
        | Jangan query kalau kurang dari 2 karakter
        */

        if (strlen($search) < 2) {

            return response()->json([]);

        }


        /*
        | Cari siswa yang terdaftar pada kelas tersebut
        */

        $siswa = Siswa::whereHas(
            'siswaKelas',
            function ($query) use ($kelasId) {

                $query->where(
                    'kelas_id',
                    $kelasId
                );

            }
        )
        ->where(function ($query) use ($search) {

            $query->where(
                'nama',
                'like',
                '%' . $search . '%'
            )
            ->orWhere(
                'nis',
                'like',
                '%' . $search . '%'
            )
            ->orWhere(
                'nisn',
                'like',
                '%' . $search . '%'
            );

        })
        ->orderBy('nama')
        ->limit(20)
        ->get([
            'id',
            'nis',
            'nisn',
            'nama'
        ]);


        return response()->json($siswa);
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(
        Request $request,
        $kelasId,
        $mapelId
    ) {

        $request->validate([

            'jadwal_pelajaran_id' =>
                'required|exists:jadwal_pelajaran,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'jenis_nilai' =>
                'required|in:harian,ujian',

            'nilai' =>
                'required|numeric|min:0|max:100',

        ]);


        PenilaianMapel::create([

            'jadwal_pelajaran_id' =>
                $request->jadwal_pelajaran_id,

            'siswa_id' =>
                $request->siswa_id,

            'jenis_nilai' =>
                $request->jenis_nilai,

            'nilai' =>
                $request->nilai,

        ]);


        return redirect()
            ->route(
                'admin.penilaian.mapel.mapel',
                [
                    'kelasId' => $kelasId,
                    'mapelId' => $mapelId
                ]
            )
            ->with(
                'success',
                'Penilaian berhasil ditambahkan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */

    public function edit(
        $kelasId,
        $mapelId,
        $id
    ) {

        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $mataPelajaran =
            MataPelajaran::findOrFail($mapelId);


        $penilaian =
            PenilaianMapel::with([
                'siswa',
                'jadwal.guru',
                'jadwal.mataPelajaran',
                'jadwal.kelas'
            ])->findOrFail($id);


        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])
        ->where('kelas_id', $kelasId)
        ->where(
            'mata_pelajaran_id',
            $mapelId
        )
        ->get();


        return view(
            'admin.penilaian.mapel.edit',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian',
                'jadwal'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        $kelasId,
        $mapelId,
        $id
    ) {

        $penilaian =
            PenilaianMapel::findOrFail($id);


        $request->validate([

            'jadwal_pelajaran_id' =>
                'required|exists:jadwal_pelajaran,id',

            'siswa_id' =>
                'required|exists:datasiswa,id',

            'jenis_nilai' =>
                'required|in:harian,ujian',

            'nilai' =>
                'required|numeric|min:0|max:100',

        ]);


        $penilaian->update([

            'jadwal_pelajaran_id' =>
                $request->jadwal_pelajaran_id,

            'siswa_id' =>
                $request->siswa_id,

            'jenis_nilai' =>
                $request->jenis_nilai,

            'nilai' =>
                $request->nilai,

        ]);


        return redirect()
            ->route(
                'admin.penilaian.mapel.mapel',
                [
                    'kelasId' => $kelasId,
                    'mapelId' => $mapelId
                ]
            )
            ->with(
                'success',
                'Penilaian berhasil diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | DESTROY
    |--------------------------------------------------------------------------
    */

    public function destroy(
        $kelasId,
        $mapelId,
        $id
    ) {

        $penilaian =
            PenilaianMapel::findOrFail($id);

        $penilaian->delete();


        return redirect()
            ->route(
                'admin.penilaian.mapel.mapel',
                [
                    'kelasId' => $kelasId,
                    'mapelId' => $mapelId
                ]
            )
            ->with(
                'success',
                'Penilaian berhasil dihapus.'
            );
    }
}