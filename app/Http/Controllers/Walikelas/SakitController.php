<?php

namespace App\Http\Controllers\WaliKelas;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SakitController extends Controller
{
    public function index()
    {
        $guruId = Auth::user()->guru_id;

        $data = Sakit::with('siswa')
            ->where('walikelas_id', $guruId)
            ->where('status_walikelas', 'menunggu')
            ->latest()
            ->get();

        return view(
            'wali-kelas.sakit.index',
            compact('data')
        );
    }

    public function setujui(Sakit $sakit)
    {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakit->walikelas_id == $guruId,
            403
        );

        $sakit->update([
            'status_walikelas' => 'disetujui',
            'status' => 'menunggu_guru',
            'waktu_verifikasi_walikelas' => now(),
            'catatan_walikelas' => null,
        ]);

        return back()->with(
            'success',
            'Pengajuan sakit disetujui.'
        );
    }

    public function tolak(
        Request $request,
        Sakit $sakit
    ) {
        $guruId = Auth::user()->guru_id;

        abort_unless(
            $sakit->walikelas_id == $guruId,
            403
        );

        $request->validate([
            'catatan' => 'required|string',
        ]);

        $sakit->update([
            'status_walikelas' => 'ditolak',
            'status' => 'ditolak',
            'waktu_verifikasi_walikelas' => now(),
            'catatan_walikelas' => $request->catatan,
        ]);

        return back()->with(
            'success',
            'Pengajuan sakit ditolak.'
        );
    }
}