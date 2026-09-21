<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\Guru;
use App\Models\Kelas;
use App\Models\MataPelajaran;
use App\Models\Absensi;
use App\Models\Sakit;
use App\Models\IzinKeluar;
use App\Models\IzinPulang;
use App\Models\Dispen;
use App\Models\TahunAjaran;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
  
    public function index()
    {

        $totalSiswa = Siswa::count();

        $totalGuru = Guru::count();

        $totalKelas = Kelas::count();

        $totalMapel = MataPelajaran::count();


        $tahunAjaran = TahunAjaran::where('status', 1)
            ->orderByDesc('id')
            ->first();

        if ($tahunAjaran) {
            $tahunAjaranAktif =
                $tahunAjaran->tahun_ajaran .
                ' - ' .
                $tahunAjaran->semester;
        } else {
            $tahunAjaranAktif = '-';
        }

        $hariIni = Carbon::today();


        $absensiHadir = Absensi::whereDate('tanggal', $hariIni)
            ->where('status', 'hadir')
            ->count();


        $absensiTerlambat = Absensi::whereDate('tanggal', $hariIni)
            ->where('status', 'terlambat')
            ->count();


        $absensiIzin = Absensi::whereDate('tanggal', $hariIni)
            ->where('status', 'izin')
            ->count();


        $absensiSakit = Absensi::whereDate('tanggal', $hariIni)
            ->where('status', 'sakit')
            ->count();


        $absensiAlpha = Absensi::whereDate('tanggal', $hariIni)
            ->where('status', 'alpha')
            ->count();



        $totalPengajuanSakit = Sakit::count();

        $totalIzinKeluar = IzinKeluar::count();

        $totalIzinPulang = IzinPulang::count();

        $totalDispen = Dispen::count();




        $dispenDenganSurat = Dispen::whereNotNull('surat')
            ->where('surat', '!=', '')
            ->count();


        $dispenHariIni = Dispen::whereDate(
            'created_at',
            $hariIni
        )->count();


        $pengajuanSakit = Sakit::with('siswa')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Sakit',
                    'siswa' => $item->siswa->nama ?? '-',
                    'tanggal' => $item->tanggal,
                    'status' => $item->status ?? $item->status_walikelas ?? 'menunggu',
                    'created_at' => $item->created_at,
                ];
            });


        $pengajuanIzinKeluar = IzinKeluar::with('siswa')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Izin Keluar',
                    'siswa' => $item->siswa->nama ?? '-',
                    'tanggal' => $item->tanggal,
                    'status' => $item->status ?? 'menunggu',
                    'created_at' => $item->created_at,
                ];
            });


        $pengajuanIzinPulang = IzinPulang::with('siswa')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Izin Pulang',
                    'siswa' => $item->siswa->nama ?? '-',
                    'tanggal' => $item->tanggal,
                    'status' => $item->status ?? 'menunggu',
                    'created_at' => $item->created_at,
                ];
            });


        $pengajuanDispen = Dispen::with('siswa')
            ->latest('created_at')
            ->take(5)
            ->get()
            ->map(function ($item) {
                return (object) [
                    'jenis' => 'Dispensasi',
                    'siswa' => $item->siswa->nama ?? '-',
                    'tanggal' => $item->tanggal_mulai,
                    'status' => $item->status,
                    'created_at' => $item->created_at,
                ];
            });


        $pengajuanTerbaru = $pengajuanSakit
            ->concat($pengajuanIzinKeluar)
            ->concat($pengajuanIzinPulang)
            ->concat($pengajuanDispen)
            ->sortByDesc('created_at')
            ->take(8)
            ->values();




        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'totalMapel',

            'tahunAjaranAktif',

            'absensiHadir',
            'absensiTerlambat',
            'absensiIzin',
            'absensiSakit',
            'absensiAlpha',

            'totalPengajuanSakit',
            'totalIzinKeluar',
            'totalIzinPulang',
            'totalDispen',

            'dispenDenganSurat',
            'dispenHariIni',

            'pengajuanTerbaru'
        ));
    }
}