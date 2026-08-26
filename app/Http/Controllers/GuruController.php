<?php

namespace App\Http\Controllers;

use App\Models\Guru;
use App\Models\MataPelajaran;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = Guru::all();

        return view('admin.master-data.guru.index', compact('guru'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.master-data.guru.create', compact('mataPelajaran'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate($this->guruRules());

        DB::transaction(function () use ($data, &$guru, &$passwordAwal) {

            // Simpan data guru
            $guru = Guru::create($data);

            // Buat password acak
            $passwordAwal = Str::random(8);

            // Buat akun login guru
            User::create([
                'username' => $guru->nip,
                'password' => $passwordAwal,
                'role_id' => 2,
                'guru_id' => $guru->id,
            ]);
        });

        return redirect()
            ->route('guru.index')
            ->with('success', 'Data guru berhasil ditambahkan.')
            ->with('username', $guru->nip)
            ->with('password_awal', $passwordAwal);
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
        $guru = Guru::findOrFail($id);
        $mataPelajaran = MataPelajaran::orderBy('nama_mapel')->get();

        return view('admin.master-data.guru.edit', compact('guru', 'mataPelajaran'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate($this->guruRules($id));

        Guru::findOrFail($id)->update($data);

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Guru::findOrFail($id)->delete();

        return redirect()->route('guru.index')->with('success', 'Data guru berhasil dihapus.');
    }

    private function guruRules(?string $id = null): array
    {
        return [
            'nip' => 'required|max:30|unique:dataguru,nip' . ($id ? ',' . $id : ''),
            'nama' => 'required|max:255',
            'jk' => 'required|in:Laki-laki,Perempuan',
            'tgl_lahir' => 'required|date',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Budha,Konghucu',
            'alamat' => 'required',
            'no_hp' => 'required|max:30',
            'email' => 'required|email|max:255',
            'status_kepegawaian' => 'required|in:PNS,PPPK,Honorer,Guru_tetap,Guru_tidak_tetap',
            'jabatan' => 'required|in:Guru,Kepala_sekolah,Waka_sekolah',
            'tmt' => 'required|date',
            'mata_pelajaran_id' => 'required|exists:mata_pelajaran,id',
        ];
    }
}
