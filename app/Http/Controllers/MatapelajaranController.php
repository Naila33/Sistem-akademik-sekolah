<?php

namespace App\Http\Controllers;

use App\Models\matapelajaran;
use Illuminate\Http\Request;

class MatapelajaranController extends Controller
{
    public function index()
    {
        $mata_pelajaran = MataPelajaran::paginate(10);

        return view('admin.mata_pelajaran.index', compact('mata_pelajaran'));
    }

    public function create()
    {
        return view('admin.mata_pelajaran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
            'warna' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        MataPelajaran::create([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'warna' => $request->warna,
        ]);

        return redirect('/admin/mata_pelajaran')
            ->with('success', 'Mata pelajaran berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);

        return view('admin.mata_pelajaran.edit', compact('mata_pelajaran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kode_mapel' => 'required',
            'nama_mapel' => 'required',
            'warna' => ['required', 'regex:/^#[0-9A-Fa-f]{6}$/'],
        ]);

        $mata_pelajaran = MataPelajaran::findOrFail($id);

        $mata_pelajaran->update([
            'kode_mapel' => $request->kode_mapel,
            'nama_mapel' => $request->nama_mapel,
            'warna' => $request->warna,
        ]);

        return redirect('/admin/mata_pelajaran')
            ->with('success', 'Mata pelajaran berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);

        $mata_pelajaran->delete();

        return redirect('/admin/mata_pelajaran')
            ->with('success', 'Mata pelajaran berhasil dihapus.');
    }
}
