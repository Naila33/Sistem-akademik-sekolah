<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Guru;
use App\Models\Jurusan;
use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelases = Kelas::with(['jurusan', 'waliKelas', 'tahunAjaran'])->get();

        return view('admin.master-data.kelas.index', compact('kelases'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gurus = Guru::all();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjarans = TahunAjaran::all();

        return view('admin.master-data.kelas.create', compact('gurus', 'jurusans', 'tahunAjarans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|in:A,B,C,D,E,F,G,H',
            'wali_kelas_id' => 'required|exists:dataguru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        Kelas::create($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $kelas = Kelas::findOrFail($id);
        $gurus = Guru::all();
        $jurusans = Jurusan::orderBy('nama_jurusan')->get();
        $tahunAjarans = TahunAjaran::all();

        return view('admin.master-data.kelas.edit', compact('kelas', 'gurus', 'jurusans', 'tahunAjarans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'tingkat' => 'required|in:X,XI,XII',
            'jurusan_id' => 'required|exists:jurusan,id',
            'nama_kelas' => 'required|in:A,B,C,D,E,F,G,H',
            'wali_kelas_id' => 'required|exists:dataguru,id',
            'tahun_ajaran_id' => 'required|exists:tahun_ajaran,id',
        ]);

        Kelas::findOrFail($id)->update($data);

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Kelas::findOrFail($id)->delete();

        return redirect()->route('kelas.index')->with('success', 'Data kelas berhasil dihapus.');
    }
}
