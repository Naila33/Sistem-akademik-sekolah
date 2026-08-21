<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;

class PembagianKelasController extends Controller
{
    public function index()
    {
        $kelas = Kelas::all();

        $pembagian = SiswaKelas::with(['siswa', 'kelas'])
            ->paginate(10);

        return view('admin.pembagian_kelas.index', compact('kelas', 'pembagian')
        );
    }

    public function edit($id)
    {
        $pembagian = SiswaKelas::findOrFail($id);
        $kelas = Kelas::all();

        return view('admin.pembagian_kelas.edit',compact('pembagian', 'kelas')
        );
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $pembagian = SiswaKelas::findOrFail($id);

        $pembagian->update([
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('pembagian-kelas.index')
            ->with('success', 'Pembagian kelas berhasil diperbarui.');
    }

    public function destroy($id)
    {
        $pembagian = SiswaKelas::findOrFail($id);

        $pembagian->delete();

        return redirect()
            ->route('pembagian-kelas.index')
            ->with('success', 'Siswa berhasil dikeluarkan dari kelas.');
    }
}