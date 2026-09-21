<?php

namespace App\Http\Controllers\Guru;

use Illuminate\Http\Request;
use App\Models\Jadwal_pelajaran;
use App\Models\SesiAbsensi;
use App\Http\Controllers\Controller;
use App\Models\JamPelajaran;
use Carbon\Carbon;
use Illuminate\Support\Str;

class SesiAbsensiController extends Controller
{
    private function guruOrFail()
    {
        $guru = auth()->user()?->guru;

        if (!$guru) {
            abort(403, 'Akun Anda belum terhubung dengan data guru.');
        }

        return $guru;
    }

    
    public function index()
    {
        $guru = $this->guruOrFail();

        $jadwal = Jadwal_pelajaran::with([
            'mapel',
            'kelas.jurusan',
            'jamPelajaran',
        ])
            ->where('guru_id', $guru->id)
            ->get()
            ->unique(function ($item) {
                return $item->kelas_id . '-' . $item->mata_pelajaran_id;
            })
            ->values();

        return view('guru.absen.index', compact('jadwal'));
    }

    
    public function show($jadwal)
    {
        $jadwal = Jadwal_pelajaran::with(['jamPelajaran', 'mapel', 'kelas'])->findOrFail($jadwal);

        $tanggal = Carbon::today();

        $sesi = SesiAbsensi::with(['absensi.siswa'])->where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tgl', $tanggal)
            ->first();

        return view('guru.absen.show', compact('jadwal', 'sesi'));
    }

    
    public function buka($jadwal)
    {
        
        $jadwal = Jadwal_pelajaran::findOrFail($jadwal);

        
        $jamPelajaran = JamPelajaran::findOrFail(
            $jadwal->jam_pelajaran_id
        );
        
        if (!$jamPelajaran->jam_mulai || !$jamPelajaran->jam_selesai) {
            return redirect()->route('absensi.show', ['jadwal' => $jadwal->id])
                ->with('success', 'Sesi absensi berhasil dibuka.');
        }

        $sekarang = Carbon::now();

        
        $jamMulai = Carbon::today()->setTimeFromTimeString(
            $jamPelajaran->jam_mulai
        );

        
        $jamSelesai = Carbon::today()->setTimeFromTimeString(
            $jamPelajaran->jam_selesai
        );

        
        if ($sekarang->lt($jamMulai)) {
            return back()->with(
                'error',
                'Belum masuk jam pelajaran.'
            );
        }

        
        if ($sekarang->gt($jamSelesai)) {
            return back()->with(
                'error',
                'Jam pelajaran sudah selesai.'
            );
        }

        
        $sesi = SesiAbsensi::where('jadwal_pelajaran_id', $jadwal->id)
            ->whereDate('tgl', Carbon::today())
            ->first();

        if ($sesi) {
            return redirect()
                ->route('absensi.show', $jadwal->id)
                ->with('success', 'Sesi absensi sudah dibuka.');
        }

        
        $token = strtoupper(Str::random(6));

        $sesi = SesiAbsensi::create([
            'jadwal_pelajaran_id' => $jadwal->id,
            'tgl' => Carbon::today(),
            'token' => $token,
        ]);

        return redirect()
            ->route('absensi.show', $jadwal->id)
            ->with('success', 'Sesi absensi berhasil dibuka.');
    }
}
