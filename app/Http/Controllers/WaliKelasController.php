<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\SiswaKelas;
use App\Models\WaliKelas;
use App\Models\Jadwal_pelajaran;
use App\Models\PenilaianMapel;
use App\Models\IzinKeluar;
use App\Models\IzinPulang;
use Illuminate\Http\Request;

class WaliKelasController extends Controller
{
    public function dashboard()
    {
        $guruId = auth()->user()->guru_id;

        $guru = auth()->user()->guru;

        $waliKelas = WaliKelas::with([
            'kelas.jurusan',
            'kelas.tahunAjaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        return view('wali-kelas.dashboard', compact(
            'guru',
            'waliKelas',
            'jadwalMengajar'
        ));
    }

    public function index()
    {
        $guruId = auth()->user()->guru_id;

        // Kelas yang dia walikan
        $waliKelas = WaliKelas::with([
            'kelas.jurusan',
            'kelas.tahunAjaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        // Jadwal yang dia ajar
        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->get();

        $isMengajar = $jadwalMengajar->isNotEmpty();

        return view('wali-kelas.index', compact(
            'waliKelas',
            'jadwalMengajar',
            'isMengajar'
        ));
    }

    public function siswa(Kelas $kelas)
    {
        $guruId = auth()->user()->guru_id;

        // Hanya wali kelas dari kelas tersebut yang boleh melihat
        $waliKelas = WaliKelas::where('guru_id', $guruId)
            ->where('kelas_id', $kelas->id)
            ->firstOrFail();

        $kelas->load([
            'waliKelas',
            'jurusan',
            'tahunAjaran'
        ]);

        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $kelas->id)
            ->get();

        return view('wali-kelas.siswa', compact(
            'kelas',
            'siswa'
        ));
    }

    public function nilai(Siswa $siswa)
    {
        return view('wali-kelas.nilai', compact('siswa'));
    }

    public function rapor(Siswa $siswa)
    {
        return view('wali-kelas.rapor', compact('siswa'));
    }

    public function kelasMengajar()
    {
        $guruId = auth()->user()->guru_id;

        $jadwalMengajar = Jadwal_pelajaran::with([
            'kelas.jurusan',
            'mataPelajaran'
        ])
            ->where('guru_id', $guruId)
            ->orderBy('hari')
            ->orderBy('jam_mulai')
            ->get();

        // Hitung JP mulai dan selesai
        $jpBerjalan = [];

        foreach ($jadwalMengajar as $jadwal) {

            $key = $jadwal->kelas_id . '-' . $jadwal->hari;

            if (!isset($jpBerjalan[$key])) {
                $jpBerjalan[$key] = 1;
            }

            $mulai = $jpBerjalan[$key];

            $selesai = $mulai + (int) $jadwal->jumlah_jp - 1;

            $jadwal->jp_mulai = $mulai;
            $jadwal->jp_selesai = $selesai;

            $jpBerjalan[$key] = $selesai + 1;
        }

        return view('wali-kelas.kelas-mengajar', compact(
            'jadwalMengajar'
        ));
    }

    public function inputNilai(Jadwal_pelajaran $jadwal)
    {
        $guruId = auth()->user()->guru_id;

        // Pastikan jadwal memang milik guru yang login
        if ($jadwal->guru_id != $guruId) {
            abort(403);
        }

        $jadwal->load([
            'kelas.jurusan',
            'mataPelajaran'
        ]);

        /*
        |--------------------------------------------------------------------------
        | Hitung JP mulai dan selesai
        |--------------------------------------------------------------------------
        */

        $jadwalSebelumnya = Jadwal_pelajaran::where('guru_id', $guruId)
            ->where('kelas_id', $jadwal->kelas_id)
            ->where('hari', $jadwal->hari)
            ->where('id', '!=', $jadwal->id)
            ->orderBy('jam_mulai')
            ->get();

        $jpBerjalan = 1;

        foreach ($jadwalSebelumnya as $jadwalLain) {
            $jpBerjalan += (int) $jadwalLain->jumlah_jp;
        }

        $jadwal->jp_mulai = $jpBerjalan;

        $jadwal->jp_selesai =
            $jpBerjalan + (int) $jadwal->jumlah_jp - 1;

        /*
        |--------------------------------------------------------------------------
        | Ambil siswa berdasarkan kelas
        |--------------------------------------------------------------------------
        */

        $siswa = SiswaKelas::with('siswa')
            ->where('kelas_id', $jadwal->kelas_id)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Ambil nilai harian yang sudah tersimpan
        |--------------------------------------------------------------------------
        */

        $nilai = PenilaianMapel::where(
            'jadwal_pelajaran_id',
            $jadwal->id
        )
            ->where('jenis_nilai', 'harian')
            ->get()
            ->keyBy('siswa_id');

        return view('wali-kelas.input-nilai', compact(
            'jadwal',
            'siswa',
            'nilai'
        ));
    }

    public function simpanNilai(
        Request $request,
        Jadwal_pelajaran $jadwal
    ) {
        $guruId = auth()->user()->guru_id;

        // Jangan izinkan guru memasukkan nilai ke jadwal guru lain
        if ($jadwal->guru_id != $guruId) {
            abort(403);
        }

        /*
        |--------------------------------------------------------------------------
        | Validasi nilai
        |--------------------------------------------------------------------------
        */

        $request->validate([
            'nilai' => ['required', 'array'],
            'nilai.*' => [
                'nullable',
                'numeric',
                'min:0',
                'max:100'
            ],
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan nilai setiap siswa
        |--------------------------------------------------------------------------
        */

        foreach ($request->nilai as $siswaId => $nilaiSiswa) {

            // Kalau kosong, jangan disimpan
            if ($nilaiSiswa === null || $nilaiSiswa === '') {
                continue;
            }

            // Pastikan siswa memang berada di kelas jadwal ini
            $siswaValid = SiswaKelas::where('kelas_id', $jadwal->kelas_id)
                ->where('siswa_id', $siswaId)
                ->exists();

            if (!$siswaValid) {
                continue;
            }

            /*
            |--------------------------------------------------------------------------
            | Update jika sudah ada, buat baru jika belum ada
            |--------------------------------------------------------------------------
            */

            PenilaianMapel::updateOrCreate(
                [
                    'jadwal_pelajaran_id' => $jadwal->id,
                    'siswa_id' => $siswaId,
                    'jenis_nilai' => 'harian',
                ],
                [
                    'nilai' => $nilaiSiswa,
                ]
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman input nilai
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route(
                'wali-kelas.input-nilai',
                $jadwal->id
            )
            ->with(
                'success',
                'Nilai harian berhasil disimpan.'
            );
    }

    private function kelasYangDiajar()
    {
        return Jadwal_pelajaran::where('guru_id', auth()->user()->guru_id)
            ->pluck('kelas_id')->unique()->values();
    }

    public function izinKeluar()
    {
        $izinKeluar = IzinKeluar::with('siswa')
            ->whereHas('siswa.siswaKelas', fn ($query) => $query->whereIn('kelas_id', $this->kelasYangDiajar()))
            ->latest('id')->paginate(20)->withQueryString();

        return view('wali-kelas.izin-keluar.index', compact('izinKeluar'));
    }

    public function verifikasiIzinKeluar(Request $request, $id)
    {
        $validated = $request->validate([
            'status_wali_kelas' => 'required|in:diterima,ditolak',
            'catatan_wali_kelas' => 'nullable|string|max:1000',
        ]);

        $izin = IzinKeluar::whereKey($id)
            ->whereHas('siswa.siswaKelas', fn ($query) => $query->whereIn('kelas_id', $this->kelasYangDiajar()))
            ->firstOrFail();
        $izin->update([
            'status_wali_kelas' => $validated['status_wali_kelas'],
            'waktu_verifikasi_wali_kelas' => now(),
            'catatan_wali_kelas' => $validated['catatan_wali_kelas'] ?? null,
        ]);

        return back()->with('success', 'Izin keluar berhasil diverifikasi.');
    }

    public function izinPulang()
    {
        $izinPulang = IzinPulang::with('siswa')
            ->whereHas('siswa.siswaKelas', fn ($query) => $query->whereIn('kelas_id', $this->kelasYangDiajar()))
            ->latest('id')->paginate(20)->withQueryString();

        return view('wali-kelas.izin-pulang.index', compact('izinPulang'));
    }

    public function verifikasiIzinPulang(Request $request, $id)
    {
        $validated = $request->validate([
            'status_wali_kelas' => 'required|in:diterima,ditolak',
            'catatan_wali_kelas' => 'nullable|string|max:1000',
        ]);

        $izin = IzinPulang::whereKey($id)
            ->whereHas('siswa.siswaKelas', fn ($query) => $query->whereIn('kelas_id', $this->kelasYangDiajar()))
            ->firstOrFail();
        $izin->update([
            'status_wali_kelas' => $validated['status_wali_kelas'],
            'waktu_verifikasi_wali_kelas' => now(),
            'catatan_wali_kelas' => $validated['catatan_wali_kelas'] ?? null,
        ]);

        return back()->with('success', 'Izin pulang berhasil diverifikasi.');
    }
}