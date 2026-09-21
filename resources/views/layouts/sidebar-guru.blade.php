<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Guru</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('guru.dashboard') }}">Dashboard</a>

        <div class="menu-title">Akun</div>
        <a href="{{ route('password.change') }}">Ganti Password</a>

        <div class="menu-title">Penilaian</div>
        <a href="{{ route('guru.penilaian.index') }}">Input Nilai</a>
        <a href="{{ route('guru.penilaian-pjbl.index') }}">Penilaian PjBL</a>

        <div class="menu-title">Jadwal pelajaran</div>
        <a href="{{ route('guru.jadwal.index') }}">Lihat Jadwal</a>

        <div class="menu-title">Absensi</div>
        <a href="{{ route('absensi.index') }}">Lihat Absensi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-right" aria-hidden="true"></i>Logout</button>
        </form>
    </nav>
</aside>