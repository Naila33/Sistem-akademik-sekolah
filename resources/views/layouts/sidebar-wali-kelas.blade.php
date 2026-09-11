<aside class="sidebar">

    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Wali Kelas</p>
    </div>

    <div class="menu">
@php
    $waliKelasPertama = null;
    if (auth()->check() && auth()->user()->guru_id) {
        $waliKelasPertama = \App\Models\WaliKelas::where('guru_id', auth()->user()->guru_id)->first();
    }
@endphp

        {{-- MENU UTAMA --}}
        <div class="menu-title">Menu Utama</div>

        <a href="{{ route('wali-kelas.dashboard') }}">
            Beranda
        </a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}">
            Ganti Password
        </a>

        {{-- WALI KELAS --}}
        <div class="menu-title">Wali Kelas</div>

        <a href="{{ route('wali-kelas.index') }}">
            Kelas Saya
        </a>

        <a href="{{ $waliKelasPertama ? route('wali-kelas.siswa', $waliKelasPertama->kelas_id) : '#' }}">
            Data Siswa
        </a>

        <a href="#">
            Nilai Siswa
        </a>

        <a href="#">
            Rapor Siswa
        </a>


        {{-- GURU MATA PELAJARAN --}}
@php
    $jadwalSaya = collect();

    if (auth()->check() && auth()->user()->guru_id) {
        $jadwalSaya = \App\Models\Jadwal_pelajaran::with([
            'kelas',
            'mataPelajaran'
        ])
        ->where('guru_id', auth()->user()->guru_id)
        ->orderBy('hari')
        ->orderBy('jam_mulai')
        ->get();
    }
@endphp

@if($jadwalSaya->isNotEmpty())

    <div class="menu-title">Guru Mata Pelajaran</div>

    <a href="{{ route('wali-kelas.kelas-mengajar') }}">
        Kelas Mengajar
    </a>


    <a href="{{ route('wali-kelas.kelas-mengajar') }}">
        Input Nilai
    </a>

    <a href="{{ route('wali-kelas.kelas-mengajar') }}">
        Nilai Harian
    </a>

    <a href="#">
        Nilai PJBL
    </a>

@endif

>>>>>>> Stashed changes
    </div>


    {{-- LOGOUT --}}
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>
<<<<<<< Updated upstream
=======

>>>>>>> Stashed changes
</aside>