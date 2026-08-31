<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Wali Kelas</p>
    </div>

    <div class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('wali-kelas.index') }}">Beranda Wali Kelas</a>

        <div class="menu-title">Pengelolaan Kelas</div>
        <a href="{{ route('wali-kelas.index') }}">Kelas Saya</a>

        @isset($kelas)
            @if($kelas instanceof \App\Models\Kelas)
                <a href="{{ route('wali-kelas.siswa', $kelas->id) }}">Data Siswa</a>
            @endif
        @endisset

        @isset($siswa)
            @if($siswa instanceof \App\Models\Siswa)
                <a href="{{ route('wali-kelas.nilai', $siswa->id) }}">Nilai Siswa</a>
                <a href="{{ route('wali-kelas.rapor', $siswa->id) }}">Rapor Siswa</a>
            @endif
        @endisset
    </div>

    <form action="{{ route('logout') }}" method="POST" class="logout-form">
        @csrf
        <button type="submit">Logout</button>
    </form>
</aside>
