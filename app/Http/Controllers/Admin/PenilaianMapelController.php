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
    /**
     * =========================================================
     * HALAMAN 1
     * PILIH KELAS
     * =========================================================
     */
    public function index(Request $request)
    {
        $query = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])
        ->withCount('siswaKelas');

        /*
        |--------------------------------------------------------------------------
        | SEARCH KELAS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('tingkat', 'like', "%{$search}%")
                    ->orWhere('nama_kelas', 'like', "%{$search}%")
                    ->orWhereHas('jurusan', function ($jurusan) use ($search) {
                        $jurusan->where('nama_jurusan', 'like', "%{$search}%");
                    });

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JENJANG
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tingkat')) {
            $query->where('tingkat', $request->tingkat);
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JURUSAN
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jurusan_id')) {
            $query->where('jurusan_id', $request->jurusan_id);
        }

        $kelas = $query
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA FILTER
        |--------------------------------------------------------------------------
        */

        $jurusan = \App\Models\Jurusan::orderBy('nama_jurusan')->get();

        $tingkat = Kelas::select('tingkat')
            ->distinct()
            ->orderBy('tingkat')
            ->pluck('tingkat');

        return view(
            'admin.penilaian.mapel.index',
            compact(
                'kelas',
                'jurusan',
                'tingkat'
            )
        );
    }


    /**
     * =========================================================
     * HALAMAN 2
     * PILIH MATA PELAJARAN
     * =========================================================
     */
    public function kelas(Request $request, $kelasId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        /*
        |--------------------------------------------------------------------------
        | MAPEL YANG ADA DI JADWAL KELAS
        |--------------------------------------------------------------------------
        */

        $query = MataPelajaran::whereHas('jadwal', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        });

        /*
        |--------------------------------------------------------------------------
        | SEARCH MAPEL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('nama_mapel', 'like', "%{$search}%")
                    ->orWhere('kode_mapel', 'like', "%{$search}%");

            });
        }

        $mataPelajaran = $query
            ->withCount([
                'jadwal as jumlah_jadwal' => function ($q) use ($kelasId) {
                    $q->where('kelas_id', $kelasId);
                }
            ])
            ->orderBy('nama_mapel')
            ->get();

        /*
        |--------------------------------------------------------------------------
        | HITUNG JUMLAH PENILAIAN
        |--------------------------------------------------------------------------
        */

        foreach ($mataPelajaran as $mapel) {

            $mapel->jumlah_penilaian = PenilaianMapel::whereHas(
                'jadwal',
                function ($q) use ($kelasId, $mapel) {

                    $q->where('kelas_id', $kelasId)
                        ->where('mata_pelajaran_id', $mapel->id);

                }
            )->count();

        }

        return view(
            'admin.penilaian.mapel.kelas',
            compact(
                'kelas',
                'mataPelajaran'
            )
        );
    }


    /**
     * =========================================================
     * HALAMAN 3
     * TABEL PENILAIAN
     * =========================================================
     */
    public function mapel(Request $request, $kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan',
            'tahunAjaran'
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN MAPEL MEMANG ADA DI KELAS
        |--------------------------------------------------------------------------
        */

        $adaJadwal = Jadwal_Pelajaran::where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mapelId)
            ->exists();

        if (!$adaJadwal) {
            abort(404);
        }

        /*
        |--------------------------------------------------------------------------
        | QUERY NILAI
        |--------------------------------------------------------------------------
        */

        $query = PenilaianMapel::with([
            'siswa',
            'jadwal.guru'
        ])
        ->whereHas('jadwal', function ($q) use ($kelasId, $mapelId) {

            $q->where('kelas_id', $kelasId)
                ->where('mata_pelajaran_id', $mapelId);

        });

        /*
        |--------------------------------------------------------------------------
        | SEARCH NAMA SISWA
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {

                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('nis', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%");

            });
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER JENIS NILAI
        |--------------------------------------------------------------------------
        */

        if ($request->filled('jenis_nilai')) {

            $query->where(
                'jenis_nilai',
                $request->jenis_nilai
            );
        }

        /*
        |--------------------------------------------------------------------------
        | FILTER TANGGAL
        |--------------------------------------------------------------------------
        */

        if ($request->filled('tanggal')) {

            $query->whereDate(
                'created_at',
                $request->tanggal
            );
        }

        $penilaian = $query
            ->latest()
            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA UNTUK TAMBAH NILAI
        |--------------------------------------------------------------------------
        */

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])
        ->where('kelas_id', $kelasId)
        ->where('mata_pelajaran_id', $mapelId)
        ->get();

        /*
        |--------------------------------------------------------------------------
        | SISWA DI KELAS
        |--------------------------------------------------------------------------
        */

        $siswa = Siswa::whereHas('siswaKelas', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        })
        ->orderBy('nama')
        ->get();

        return view(
            'admin.penilaian.mapel.mapel',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian',
                'jadwal',
                'siswa'
            )
        );
    }


    /**
     * =========================================================
     * CREATE
     * =========================================================
     */
    public function create($kelasId, $mapelId)
    {
        $kelas = Kelas::with([
            'jurusan'
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])
        ->where('kelas_id', $kelasId)
        ->where('mata_pelajaran_id', $mapelId)
        ->get();

        $siswa = Siswa::whereHas('siswaKelas', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        })
        ->orderBy('nama')
        ->get();

        return view(
            'admin.penilaian.mapel.create',
            compact(
                'kelas',
                'mataPelajaran',
                'jadwal',
                'siswa'
            )
        );
    }


    /**
     * =========================================================
     * STORE
     * =========================================================
     */
    public function store(Request $request, $kelasId, $mapelId)
    {
        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'siswa_id' => 'required|exists:datasiswa,id',
            'jenis_nilai' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        /*
        |--------------------------------------------------------------------------
        | PASTIKAN JADWAL MILIK KELAS + MAPEL
        |--------------------------------------------------------------------------
        */

        $jadwal = Jadwal_Pelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mapelId)
            ->firstOrFail();

        PenilaianMapel::create([
            'jadwal_pelajaran_id' => $jadwal->id,
            'siswa_id' => $request->siswa_id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
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


    /**
     * =========================================================
     * EDIT
     * =========================================================
     */
    public function edit($kelasId, $mapelId, $id)
    {
        $kelas = Kelas::with([
            'jurusan'
        ])->findOrFail($kelasId);

        $mataPelajaran = MataPelajaran::findOrFail($mapelId);

        $penilaian = PenilaianMapel::with([
            'siswa',
            'jadwal'
        ])->where('id', $id)
            ->whereHas('jadwal', function ($q) use ($kelasId, $mapelId) {

                $q->where('kelas_id', $kelasId)
                    ->where('mata_pelajaran_id', $mapelId);

            })
            ->firstOrFail();

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])
        ->where('kelas_id', $kelasId)
        ->where('mata_pelajaran_id', $mapelId)
        ->get();

        $siswa = Siswa::whereHas('siswaKelas', function ($q) use ($kelasId) {

            $q->where('kelas_id', $kelasId);

        })
        ->orderBy('nama')
        ->get();

        return view(
            'admin.penilaian.mapel.edit',
            compact(
                'kelas',
                'mataPelajaran',
                'penilaian',
                'jadwal',
                'siswa'
            )
        );
    }


    /**
     * =========================================================
     * UPDATE
     * =========================================================
     */
    public function update(
        Request $request,
        $kelasId,
        $mapelId,
        $id
    ) {

        $penilaian = PenilaianMapel::where('id', $id)
            ->whereHas('jadwal', function ($q) use ($kelasId, $mapelId) {

                $q->where('kelas_id', $kelasId)
                    ->where('mata_pelajaran_id', $mapelId);

            })
            ->firstOrFail();

        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'siswa_id' => 'required|exists:datasiswa,id',
            'jenis_nilai' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $jadwal = Jadwal_Pelajaran::where('id', $request->jadwal_pelajaran_id)
            ->where('kelas_id', $kelasId)
            ->where('mata_pelajaran_id', $mapelId)
            ->firstOrFail();

        $penilaian->update([
            'jadwal_pelajaran_id' => $jadwal->id,
            'siswa_id' => $request->siswa_id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
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


    /**
     * =========================================================
     * DELETE
     * =========================================================
     */
    public function destroy($kelasId, $mapelId, $id)
    {
        $penilaian = PenilaianMapel::where('id', $id)
            ->whereHas('jadwal', function ($q) use ($kelasId, $mapelId) {

                $q->where('kelas_id', $kelasId)
                    ->where('mata_pelajaran_id', $mapelId);

            })
            ->firstOrFail();

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