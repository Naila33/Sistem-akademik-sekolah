<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswas = Siswa::all();

        return view('admin.master-data.siswa.index', compact('siswas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.master-data.siswa.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Konghucu',
            'nik' => 'nullable|max:20',
            'no_kk' => 'nullable|max:20',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Siswa::create($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil ditambahkan.');
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
        $siswa = Siswa::findOrFail($id);

        return view('admin.master-data.siswa.edit', compact('siswa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'nis' => 'required|max:20',
            'nisn' => 'nullable|max:20',
            'nama' => 'required|max:255',
            'jk' => 'required|in:Perempuan,Laki-laki',
            'tempat_lahir' => 'required|max:100',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Budha,Hindu,Konghucu',
            'nik' => 'nullable|max:20',
            'no_kk' => 'nullable|max:20',
            'alamat' => 'required',
            'no_hp' => 'nullable|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Siswa::findOrFail($id)->update($data);

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Siswa::findOrFail($id)->delete();

        return redirect()->route('siswa.index')->with('success', 'Data siswa berhasil dihapus.');
    }
}
