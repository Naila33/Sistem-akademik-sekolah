<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use App\Models\SiswaKelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PerizinanController extends Controller
{
    /**
     * Menampilkan daftar pengajuan sakit siswa
     */
    public function sakit()
    {
        $siswa = Auth::user()->siswa;

        $dataSakit = Sakit::where('siswa_id', $siswa->id)
            ->orderByDesc('tanggal')
            ->orderByDesc('created_at')
            ->get();

        return view('siswa.perizinan.sakit', compact('dataSakit'));
    }

    /**
     * Menampilkan form pengajuan sakit
     */
    public function createSakit()
    {
        return view('siswa.perizinan.sakit-create');
    }

    /**
     * Menampilkan form edit pengajuan sakit.
     */
    public function editSakit($id)
    {
        $sakit = $this->pendingSakitForCurrentStudent($id);

        return view('siswa.perizinan.sakit-create', compact('sakit'));
    }

    /**
     * Menyimpan pengajuan sakit
     */
    public function storeSakit(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $siswa = Auth::user()->siswa;

        $siswaKelas = SiswaKelas::with('kelas')
            ->where('siswa_id', $siswa->id)
            ->latest('id')
            ->first();

        $waliKelasId = $siswaKelas?->kelas?->wali_kelas_id;

        if (!$waliKelasId) {
            return back()
                ->withInput()
                ->with('error', 'Data kelas atau wali kelas kamu belum tersedia.');
        }

        $dokumen = null;

        if ($request->hasFile('dokumen')) {
            $dokumen = $request->file('dokumen')->store(
                'dokumen-sakit',
                'public'
            );
        }

        Sakit::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $request->tanggal,
            'alasan' => $request->alasan,
            'dokumen' => $dokumen,
            'walikelas_id' => $waliKelasId,
            'status_walikelas' => 'menunggu',
            'status' => 'menunggu_walikelas',
        ]);

        return redirect()
            ->route('siswa.perizinan.sakit')
            ->with('success', 'Pengajuan sakit berhasil dikirim.');
    }

    /**
     * Memperbarui pengajuan sakit yang masih menunggu persetujuan.
     */
    public function updateSakit(Request $request, $id)
    {
        $sakit = $this->pendingSakitForCurrentStudent($id);

        $request->validate([
            'tanggal' => 'required|date',
            'alasan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $data = [
            'tanggal' => $request->tanggal,
            'alasan' => $request->alasan,
        ];

        if ($request->hasFile('dokumen')) {
            if ($sakit->dokumen) {
                Storage::disk('public')->delete($sakit->dokumen);
            }

            $data['dokumen'] = $request->file('dokumen')->store(
                'dokumen-sakit',
                'public'
            );
        }

        $sakit->update($data);

        return redirect()
            ->route('siswa.perizinan.sakit')
            ->with('success', 'Pengajuan sakit berhasil diperbarui.');
    }

    /**
     * Menghapus pengajuan sakit yang masih menunggu persetujuan.
     */
    public function destroySakit($id)
    {
        $sakit = $this->pendingSakitForCurrentStudent($id);

        if ($sakit->dokumen) {
            Storage::disk('public')->delete($sakit->dokumen);
        }

        $sakit->delete();

        return redirect()
            ->route('siswa.perizinan.sakit')
            ->with('success', 'Pengajuan sakit berhasil dihapus.');
    }

    private function pendingSakitForCurrentStudent($id): Sakit
    {
        return Sakit::where('id', $id)
            ->where('siswa_id', Auth::user()->siswa->id)
            ->where('status', 'menunggu_walikelas')
            ->firstOrFail();
    }
}
