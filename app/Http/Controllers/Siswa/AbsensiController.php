<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SesiAbsensi;
use App\Models\Absensi;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    // Menampilkan halaman absensi siswa
    public function index()
    {
        return view('siswa.absensi.index');
    }

    // Memproses kode absensi
    public function store(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
        ]);

        $sesi = SesiAbsensi::where('token', $request->token)
            ->where('status', 'Dibuka')
            ->first();

        if (!$sesi) {
            return back()->with('error', 'Kode absensi tidak ditemukan atau sudah ditutup.');
        }

        // Ambil siswa yang sedang login
        $siswa = auth()->user()->siswa;

        // Cek apakah siswa sudah absen di sesi ini
        $sudahAbsen = Absensi::where('sesi_absensi_id', $sesi->id)
            ->where('siswa_id', $siswa->id)
            ->exists();

        if ($sudahAbsen) {
            return back()->with('error', 'Kamu sudah melakukan absensi.');
        }

        // Waktu sekarang
        $sekarang = Carbon::now();

        // Untuk sementara, status hadir
        // Nanti kita sambungkan dengan jam mulai jadwal
        // untuk menentukan hadir / terlambat.
        $status = 'hadir';

        Absensi::create([
            'sesi_absensi_id' => $sesi->id,
            'siswa_id' => $siswa->id,
            'tanggal' => $sekarang->toDateString(),
            'jam_masuk' => $sekarang->format('H:i:s'),
            'status' => $status,
        ]);

        return back()->with('success', 'Absensi berhasil dicatat.');
    }
}