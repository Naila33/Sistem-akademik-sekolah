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
    public function index(Request $request)
{
    $query = PenilaianMapel::with([
        'siswa',
        'jadwal.mataPelajaran',
        'jadwal.kelas',
    ]);

    /*
    |--------------------------------------------------------------------------
    | SEARCH NAMA SISWA / TANGGAL
    |--------------------------------------------------------------------------
    */

    if ($request->filled('search')) {

        $search = $request->search;

        $query->where(function ($q) use ($search) {

            // Search nama siswa
            $q->whereHas('siswa', function ($siswa) use ($search) {

                $siswa->where('nama', 'like', '%' . $search . '%');

            })

            // Search tanggal
            ->orWhereDate('created_at', $search);

        });
    }


    /*
    |--------------------------------------------------------------------------
    | FILTER SISWA
    |--------------------------------------------------------------------------
    */

    if ($request->filled('siswa_id')) {

        $query->where('siswa_id', $request->siswa_id);

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER MAPEL
    |--------------------------------------------------------------------------
    */

    if ($request->filled('mata_pelajaran_id')) {

        $query->whereHas('jadwal', function ($q) use ($request) {

            $q->where('mata_pelajaran_id', $request->mata_pelajaran_id);

        });

    }


    /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

    if ($request->filled('kelas_id')) {

        $query->whereHas('jadwal', function ($q) use ($request) {

            $q->where('kelas_id', $request->kelas_id);

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
    | DATA PENILAIAN
    |--------------------------------------------------------------------------
    */

    $penilaian = $query
        ->latest()
        ->get();


    /*
    |--------------------------------------------------------------------------
    | DATA UNTUK FILTER
    |--------------------------------------------------------------------------
    */

    $siswa = Siswa::orderBy('nama')->get();

    $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

    $kelas = Kelas::orderBy('tingkat')
        ->orderBy('nama_kelas')
        ->get();


    return view(
        'admin.penilaian.mapel.index',
        compact(
            'penilaian',
            'siswa',
            'mataPelajaran',
            'kelas'
        )
    );
}

    public function create()
    {
        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])->get();

        $siswa = Siswa::orderBy('nama')->get();

        return view('admin.penilaian.mapel.create', compact(
            'jadwal',
            'siswa'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'siswa_id' => 'required|exists:Siswa,id',
            'jenis_nilai' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        PenilaianMapel::create([
            'jadwal_pelajaran_id' => $request->jadwal_pelajaran_id,
            'siswa_id' => $request->siswa_id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
        ]);

        return redirect()
            ->route('admin.penilaian.mapel.index')
            ->with('success', 'Penilaian berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $penilaian = PenilaianMapel::findOrFail($id);

        $jadwal = Jadwal_Pelajaran::with([
            'kelas',
            'mataPelajaran',
            'guru'
        ])->get();

        $siswa = Siswa::orderBy('nama')->get();

        return view('admin.penilaian.mapel.edit', compact(
            'penilaian',
            'jadwal',
            'siswa'
        ));
    }

    public function update(Request $request, $id)
    {
        $penilaian = PenilaianMapel::findOrFail($id);

        $request->validate([
            'jadwal_pelajaran_id' => 'required|exists:jadwal_pelajaran,id',
            'siswa_id' => 'required|exists:datasiswa,id',
            'jenis_nilai' => 'required|in:harian,ujian',
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $penilaian->update([
            'jadwal_pelajaran_id' => $request->jadwal_pelajaran_id,
            'siswa_id' => $request->siswa_id,
            'jenis_nilai' => $request->jenis_nilai,
            'nilai' => $request->nilai,
        ]);

        return redirect()
            ->route('admin.penilaian.mapel.index')
            ->with('success', 'Penilaian berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $penilaian = PenilaianMapel::findOrFail($id);

        $penilaian->delete();

        return redirect()
            ->route('admin.penilaian.mapel.index')
            ->with('success', 'Penilaian berhasil dihapus.');
    }
}