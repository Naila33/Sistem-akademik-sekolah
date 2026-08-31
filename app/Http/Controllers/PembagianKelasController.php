<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\CalonSiswa;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\PembagianKelasImport;

class PembagianKelasController extends Controller
{
    /**
     * Menampilkan daftar pembagian kelas
     */
    public function index()
    {
        $pembagian = SiswaKelas::with(['siswa', 'kelas.jurusan'])
            ->paginate(10);

        return view(
            'admin.pembagian_kelas.index',
            compact('pembagian')
        );
    }


    /**
     * Form tambah pembagian kelas secara manual
     */
    public function create()
    {
        /*
         * Hanya mengambil siswa yang belum
         * mempunyai pembagian kelas.
         */
        $siswa = CalonSiswa::whereDoesntHave('pembagianKelas')
            ->orderBy('nama_lengkap')
            ->get();

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view(
            'admin.pembagian_kelas.create',
            compact('siswa', 'kelas')
        );
    }


    /**
     * Menyimpan pembagian kelas secara manual
     */
    public function store(Request $request)
    {
        $request->validate([
            'siswa_id' => 'required|exists:calon_siswa,id',
            'kelas_id' => 'required|exists:kelas,id',
        ]);

        $calonSiswa = CalonSiswa::findOrFail($request->siswa_id);
       
        $sudahAda = SiswaKelas::where(
            'siswa_id',
            $request->siswa_id
        )->exists();

        if ($sudahAda) {
            return back()
                ->withInput()
                ->with('error', 'Siswa tersebut sudah memiliki kelas.');
        }

        $siswa = Siswa::firstOrCreate(
            ['nisn' => $calonSiswa->nisn],
            [
                'nis' => Siswa::generateNis(),
                'nik' => $calonSiswa->nik,
                'nama' => $calonSiswa->nama_lengkap,
                'tempat_lahir' => $calonSiswa->tempat_lahir,
                'tanggal_lahir' => $calonSiswa->tanggal_lahir,
                'jk' => $calonSiswa->jenis_kelamin,
                'alamat' => $calonSiswa->alamat,
                'nama_orang_tua' => $calonSiswa->nama_ayah,
                
            ]
        );

        SiswaKelas::create([
            'siswa_id' => $siswa->id,
            'kelas_id' => $request->kelas_id,
        ]);

        return redirect()
            ->route('pembagian_kelas.index')
            ->with('success', 'Siswa berhasil dimasukkan ke kelas dan data siswa telah dibuat.');
    }


    /**
     * Form edit pembagian kelas
     */
    public function edit($id)
    {
        $pembagian = SiswaKelas::with(['siswa', 'kelas'])
            ->findOrFail($id);

        $kelas = Kelas::with('jurusan')
            ->orderBy('tingkat')
            ->orderBy('nama_kelas')
            ->get();

        return view(
            'admin.pembagian_kelas.edit',
            compact('pembagian', 'kelas')
        );
    }


    /**
     * Mengubah kelas siswa
     */
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
            ->route('pembagian_kelas.index')
            ->with(
                'success',
                'Pembagian kelas berhasil diperbarui.'
            );
    }


    /**
     * Import pembagian kelas dari Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => [
                'required',
                'file',
                'mimes:xlsx,xls,csv',
            ],
        ]);

        $import = new PembagianKelasImport();

        try {

            Excel::import(
                $import,
                $request->file('file')
            );

            return redirect()
                ->route('pembagian_kelas.index')
                ->with('success', "Import selesai. {$import->berhasil} siswa berhasil dimasukkan ke kelas.")
                ->with('gagal_import', $import->gagal);
        } catch (\Exception $e) {

            return back()
                ->with(
                    'error',
                    'Import gagal: ' . $e->getMessage()
                );
        }
    }


    /**
     * Mengeluarkan siswa dari kelas
     */
    public function destroy($id)
    {
        $pembagian = SiswaKelas::findOrFail($id);

        $pembagian->delete();

        return redirect()
            ->route('pembagian_kelas.index')
            ->with(
                'success',
                'Siswa berhasil dikeluarkan dari kelas.'
            );
    }
}
