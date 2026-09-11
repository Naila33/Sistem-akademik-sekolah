<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use App\Models\IzinKeluar;
use App\Models\IzinPulang;
use App\Models\Dispen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AbsensiPengajuanController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | SAKIT
    |--------------------------------------------------------------------------
    */

    public function sakitIndex()
    {
        $sakit = Sakit::with('guru.guru')
            ->where('siswa_id', $this->siswaId())
            ->latest()
            ->get();

        return view('siswa.absensi.sakit.index', compact('sakit'));
    }

    public function sakitCreate()
    {
        return view('siswa.absensi.sakit.create');
    }

    public function sakitStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'alasan' => 'required|string',
            'dokumen' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('dokumen')) {
            $validated['dokumen'] =
                $request->file('dokumen')
                    ->store('dokumen/sakit', 'public');
        }

        $validated['siswa_id'] = $this->siswaId();
        $validated['status'] = 'menunggu_walikelas';

        Sakit::create($validated);

        return redirect()
            ->route('siswa.sakit.index')
            ->with('success', 'Pengajuan sakit berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | IZIN KELUAR
    |--------------------------------------------------------------------------
    */

    public function izinKeluarIndex()
    {
        $izin = IzinKeluar::with(['guru', 'jadwal'])
            ->where('siswa_id', $this->siswaId())
            ->latest()
            ->get();

        return view(
            'siswa.absensi.izin-keluar.index',
            compact('izin')
        );
    }

    public function izinKeluarCreate()
    {
        return view('siswa.absensi.izin-keluar.create');
    }

    public function izinKeluarStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required|after:jam_mulai',
            'alasan' => 'required|string',
            'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['surat'] =
            $request->file('surat')
                ->store('dokumen/izin-keluar', 'public');

        $validated['siswa_id'] = $this->siswaId();

        $validated['status'] = 'menunggu_kesiswaan';
        $validated['status_kesiswaan'] = 'menunggu';
        $validated['status_guru'] = 'menunggu';

        IzinKeluar::create($validated);

        return redirect()
            ->route('siswa.izin-keluar.index')
            ->with('success', 'Pengajuan izin keluar berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | IZIN PULANG
    |--------------------------------------------------------------------------
    */

    public function izinPulangIndex()
    {
        $izin = IzinPulang::with(['guru', 'jadwal'])
            ->where('siswa_id', $this->siswaId())
            ->latest()
            ->get();

        return view(
            'siswa.absensi.izin-pulang.index',
            compact('izin')
        );
    }

    public function izinPulangCreate()
    {
        return view('siswa.absensi.izin-pulang.create');
    }

    public function izinPulangStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jam_pulang' => 'required',
            'alasan' => 'required|string',
            'surat' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        $validated['surat'] =
            $request->file('surat')
                ->store('dokumen/izin-pulang', 'public');

        $validated['siswa_id'] = $this->siswaId();

        $validated['status'] = 'menunggu_kesiswaan';
        $validated['status_kesiswaan'] = 'menunggu';
        $validated['status_guru'] = 'menunggu';

        IzinPulang::create($validated);

        return redirect()
            ->route('siswa.izin-pulang.index')
            ->with('success', 'Pengajuan izin pulang berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | DISPEN
    |--------------------------------------------------------------------------
    */

    public function dispenIndex()
    {
        $dispen = Dispen::where(
            'siswa_id',
            $this->siswaId()
        )
        ->latest()
        ->get();

        return view(
            'siswa.absensi.dispen.index',
            compact('dispen')
        );
    }

    public function dispenCreate()
    {
        return view('siswa.absensi.dispen.create');
    }

    public function dispenStore(Request $request)
    {
        $validated = $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date|after_or_equal:tanggal_mulai',
            'kegiatan' => 'required|string|max:255',
            'alasan' => 'required|string',
            'surat' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('surat')) {
            $validated['surat'] =
                $request->file('surat')
                    ->store('dokumen/dispen', 'public');
        }

        $validated['siswa_id'] = $this->siswaId();
        $validated['status'] = 'menunggu';

        Dispen::create($validated);

        return redirect()
            ->route('siswa.dispen.index')
            ->with('success', 'Pengajuan dispensasi berhasil dikirim.');
    }

    /*
    |--------------------------------------------------------------------------
    | ID SISWA
    |--------------------------------------------------------------------------
    */

    private function siswaId()
    {
        /*
         * Sesuaikan dengan sistem login siswa kamu.
         *
         * Jangan menggunakan users.id langsung karena
         * users.id bukan datasiswa.id.
         */

        return session('siswa_id');
    }
}