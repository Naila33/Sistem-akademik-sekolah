<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CalonSiswa;
use App\Models\DokumenCalonSiswa;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class SpmbController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | DAFTAR CALON SISWA
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $query = CalonSiswa::with('jurusan');

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('nama_lengkap', 'like', "%{$search}%")
                    ->orWhere('nisn', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('no_pendaftaran', 'like', "%{$search}%");
            });
        }

        if ($request->filled('jurusan_id')) {
            $query->where(
                'jurusan_id',
                $request->jurusan_id
            );
        }

        if ($request->filled('jalur_pendaftaran')) {
            $query->where(
                'jalur_pendaftaran',
                $request->jalur_pendaftaran
            );
        }

        if ($request->filled('status_daftar_ulang')) {
            $query->where(
                'status_daftar_ulang',
                $request->status_daftar_ulang
            );
        }

        $calonSiswa = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view(
            'admin.spmb.index',
            compact('calonSiswa', 'jurusan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM TAMBAH
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $jurusan = Jurusan::orderBy('nama_jurusan')->get();

        return view(
            'admin.spmb.create',
            compact('jurusan')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN CALON SISWA
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:calon_siswa,nik',
            'nisn' => 'nullable|digits:10|unique:calon_siswa,nisn',

            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',

            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',

            'alamat' => 'required|string',

            'asal_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'nullable|integer|min:2000|max:2100',

            'jurusan_id' => 'required|exists:jurusan,id',

            'jalur_pendaftaran' => 'required|string|max:100',

            'no_kk' => 'required|digits:16',

            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',

            'status_penerimaan' => 'required|in:diterima,tidak_diterima',

            'tanggal_daftar_ulang' => 'nullable|date',

            'dokumen.*' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        DB::transaction(function () use ($request, &$validated) {

            do {
                $noPendaftaran =
                    'SPMB-' .
                    date('Y') .
                    '-' .
                    strtoupper(Str::random(6));
            } while (
                CalonSiswa::where(
                    'no_pendaftaran',
                    $noPendaftaran
                )->exists()
            );

            $validated['no_pendaftaran'] = $noPendaftaran;

            $validated['status_daftar_ulang'] =
                $request->filled('tanggal_daftar_ulang')
                    ? 'menunggu_verifikasi'
                    : 'belum_daftar_ulang';

            $calonSiswa = CalonSiswa::create(
                collect($validated)
                    ->except('dokumen')
                    ->toArray()
            );

            if ($request->hasFile('dokumen')) {

                foreach (
                    $request->file('dokumen')
                    as $jenis => $file
                ) {

                    if (!$file) {
                        continue;
                    }

                    $path = $file->store(
                        'dokumen-spmb/' . $calonSiswa->id,
                        'public'
                    );

                    DokumenCalonSiswa::create([
    'calon_siswa_id' => $calonSiswa->id,
    'jenis_dokumen' => $jenis,
    'nama_file' => $file->getClientOriginalName(),
    'path_file' => $path,
    'mime_type' => $file->getMimeType(),
    'ukuran_file' => $file->getSize(),
    'status' => 'Belum Diverifikasi',
    'catatan' => null,
    'verifikator_id' => null,
    'tanggal_verifikasi' => null,
]);
                }
            }
        });

        return redirect()
            ->route('admin.spmb.index')
            ->with(
                'success',
                'Data calon siswa berhasil ditambahkan.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $calonSiswa = CalonSiswa::with([
            'jurusan',
            'dokumen',
        ])->findOrFail($id);

        return view(
            'admin.spmb.show',
            compact('calonSiswa')
        );
    }

    /*
    |--------------------------------------------------------------------------
    | FORM EDIT
    |--------------------------------------------------------------------------
    */

    public function edit($id)
{
    $calonSiswa = CalonSiswa::with('jurusan')
        ->findOrFail($id);

    $jurusan = Jurusan::orderBy('nama_jurusan')
        ->get();

    return view('admin.spmb.edit', compact(
        'calonSiswa',
        'jurusan'
    ));
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, $id)
    {
        $calonSiswa = CalonSiswa::findOrFail($id);

        $validated = $request->validate([
            'nik' => 'required|digits:16|unique:calon_siswa,nik,' . $id,
            'nisn' => 'nullable|digits:10|unique:calon_siswa,nisn,' . $id,

            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',

            'tempat_lahir' => 'required|string|max:100',
            'tanggal_lahir' => 'required|date',

            'alamat' => 'required|string',

            'asal_sekolah' => 'required|string|max:255',
            'tahun_lulus' => 'nullable|integer|min:2000|max:2100',

            'jurusan_id' => 'required|exists:jurusan,id',

            'jalur_pendaftaran' => 'required|string|max:100',

            'no_kk' => 'required|digits:16',

            'nama_ayah' => 'required|string|max:255',
            'nama_ibu' => 'required|string|max:255',
            'no_hp_ortu' => 'required|string|max:20',

            'status_penerimaan' => 'required|in:diterima,tidak_diterima',

            'tanggal_daftar_ulang' => 'nullable|date',

            'dokumen.*' => [
                'nullable',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],
        ]);

        DB::transaction(function () use (
            $request,
            $calonSiswa,
            $validated
        ) {

            $calonSiswa->update(
                collect($validated)
                    ->except('dokumen')
                    ->toArray()
            );

            if ($request->hasFile('dokumen')) {

                foreach (
                    $request->file('dokumen')
                    as $jenis => $file
                ) {

                    if (!$file) {
                        continue;
                    }

                    $dokumenLama = DokumenCalonSiswa::where(
                        'calon_siswa_id',
                        $calonSiswa->id
                    )
                        ->where(
                            'jenis_dokumen',
                            $jenis
                        )
                        ->first();

                    if ($dokumenLama) {

                        if (
                            $dokumenLama->path_file &&
                            Storage::disk('public')->exists(
                                $dokumenLama->path_file
                            )
                        ) {
                            Storage::disk('public')->delete(
                                $dokumenLama->path_file
                            );
                        }

                        $dokumenLama->delete();
                    }

                    $path = $file->store(
                        'dokumen-spmb/' . $calonSiswa->id,
                        'public'
                    );

                    DokumenCalonSiswa::create([
    'calon_siswa_id' => $calonSiswa->id,
    'jenis_dokumen' => $jenis,
    'nama_file' => $file->getClientOriginalName(),
    'path_file' => $path,
    'mime_type' => $file->getMimeType(),
    'ukuran_file' => $file->getSize(),
    'status' => 'Belum Diverifikasi',
    'catatan' => null,
    'verifikator_id' => null,
    'tanggal_verifikasi' => null,
]);
                }
            }
        });

        return redirect()
            ->route(
                'admin.spmb.show',
                $id
            )
            ->with(
                'success',
                'Data calon siswa berhasil diperbarui.'
            );
    }

    /*
    |--------------------------------------------------------------------------
    | HAPUS
    |--------------------------------------------------------------------------
    */

    public function destroy($id)
    {
        $calonSiswa = CalonSiswa::with('dokumen')
            ->findOrFail($id);

        foreach ($calonSiswa->dokumen as $dokumen) {

            if (
                $dokumen->path_file &&
                Storage::disk('public')->exists(
                    $dokumen->path_file
                )
            ) {
                Storage::disk('public')->delete(
                    $dokumen->path_file
                );
            }
        }

        $calonSiswa->delete();

        return redirect()
            ->route('admin.spmb.index')
            ->with(
                'success',
                'Data calon siswa berhasil dihapus.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI DOKUMEN
    |--------------------------------------------------------------------------
    */

    public function verifikasiDokumen(
    Request $request,
    $id,
    $dokumenId
) {
    $request->validate([
        'status_verifikasi' => 'required|in:Belum Diverifikasi,Valid,Tidak Valid',
        'catatan' => 'nullable|string|max:1000',
    ]);

    $calonSiswa = CalonSiswa::findOrFail($id);

    $dokumen = DokumenCalonSiswa::where(
        'calon_siswa_id',
        $calonSiswa->id
    )->findOrFail($dokumenId);

    $dokumen->update([
        'status' => $request->status_verifikasi,
        'catatan' => $request->catatan,
        'verifikator_id' => auth()->id(),
        'tanggal_verifikasi' => now(),
    ]);

    $this->updateStatusDaftarUlang($calonSiswa);

    return back()->with(
        'success',
        'Status dokumen berhasil diperbarui.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | VERIFIKASI DAFTAR ULANG
    |--------------------------------------------------------------------------
    */

    public function verifikasiDaftarUlang($id)
{
    $calonSiswa = CalonSiswa::with('dokumen')
        ->findOrFail($id);

    if ($calonSiswa->status_penerimaan !== 'diterima') {
        return back()->with(
            'error',
            'Calon siswa belum berstatus diterima.'
        );
    }

    $jumlahDokumenWajib = 7;

    $dokumenValid = $calonSiswa
        ->dokumen
        ->where('status', 'Valid')
        ->count();

    if ($dokumenValid < $jumlahDokumenWajib) {
        return back()->with(
            'error',
            'Semua dokumen wajib harus berstatus Valid terlebih dahulu.'
        );
    }

    $calonSiswa->update([
        'status_daftar_ulang' => 'terverifikasi',
        'catatan_revisi' => null,
    ]);

    return back()->with(
        'success',
        'Daftar ulang berhasil diverifikasi.'
    );
}

    /*
    |--------------------------------------------------------------------------
    | UPDATE STATUS DAFTAR ULANG
    |--------------------------------------------------------------------------
    */

    private function updateStatusDaftarUlang(
    CalonSiswa $calonSiswa
) {
    $dokumen = $calonSiswa->dokumen()->get();

    if ($dokumen->isEmpty()) {
        $calonSiswa->update([
            'status_daftar_ulang' => 'menunggu_verifikasi',
        ]);

        return;
    }

    $adaTidakValid = $dokumen
        ->where('status', 'Tidak Valid')
        ->count();

    if ($adaTidakValid > 0) {
        $calonSiswa->update([
            'status_daftar_ulang' => 'revisi',
        ]);

        return;
    }

    $semuaValid =
        $dokumen->count() === 7 &&
        $dokumen
            ->where('status', 'Valid')
            ->count() === 7;

    if ($semuaValid) {
        $calonSiswa->update([
            'status_daftar_ulang' => 'terverifikasi',
        ]);

        return;
    }

    $calonSiswa->update([
        'status_daftar_ulang' => 'menunggu_verifikasi',
    ]);
}
}