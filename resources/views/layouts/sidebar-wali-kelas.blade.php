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

        
        <div class="menu-title">Menu Utama</div>

        <a href="{{ route('wali-kelas.dashboard') }}">
            Beranda
        </a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}">
            Ganti Password
        </a>

        
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

        <a href="{{ route('wali-kelas.izin-keluar.index') }}">
            Izin Keluar Siswa
        </a>

        <a href="{{ route('wali-kelas.izin-pulang.index') }}">
            Izin Pulang Siswa
        </a>


        
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

    </div>


    
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf

        <button type="submit">
            Logout
        </button>
    </form>
</aside>