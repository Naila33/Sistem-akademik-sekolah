<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Siswa</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('siswa.dashboard') }}">Dashboard</a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}">Ganti Password</a>

        <div class="menu-title">Informasi</div>
        <a href="#">Nilai</a>
        <a href="{{ route('siswa.jadwal.index') }}">Jadwal</a>
        <a href="{{ route('siswa.absensi.index') }}">Absensi</a>

        <div class="menu-title">Perizinan</div>
        <a href="{{ route('siswa.perizinan.sakit') }}">Izin</a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
</aside>