<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran;
use Illuminate\Http\Request;

class TahunAjaranController extends Controller
{
    public function index()
    {
        $tahunAjaran = TahunAjaran::all();
        return view('tahun_ajaran.index', compact('tahunAjaran'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        TahunAjaran::create([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Data tahun ajaran berhasil ditambahkan');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran' => 'required|string|max:9',
            'semester'     => 'required|in:Ganjil,Genap',
        ]);

        $tahun = TahunAjaran::findOrFail($id);
        $tahun->update([
            'tahun_ajaran' => $request->tahun_ajaran,
            'semester'     => $request->semester,
            'status'       => $request->has('status') ? true : false,
        ]);

        return redirect()->back()->with('success', 'Data tahun ajaran berhasil diperbarui');
    }

    public function destroy($id)
    {
        $tahun = TahunAjaran::findOrFail($id);
        $tahun->delete();

        return redirect()->back()->with('success', 'Data tahun ajaran berhasil dihapus');
    }
}