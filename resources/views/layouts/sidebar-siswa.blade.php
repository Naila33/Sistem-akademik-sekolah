<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">

<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Panel Siswa</p>
    </div>

    <nav class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('siswa.dashboard') }}"><i class="bi bi-house-door" aria-hidden="true"></i>Dashboard</a>

        <div class="menu-title">Informasi</div>
        <a href="#"><i class="bi bi-bar-chart" aria-hidden="true"></i>Nilai</a>
        <a href="{{ route('siswa.jadwal.index') }}"><i class="bi bi-calendar3" aria-hidden="true"></i>Jadwal</a>
        <a href="{{ route('siswa.absensi.index') }}"><i class="bi bi-check2-square" aria-hidden="true"></i>Absensi</a>

        <div class="menu-title">Perizinan</div>
        <a href="{{ route('siswa.perizinan.sakit') }}">Izin</a>
        <a href="{{ route('siswa.absensi') }}">Absensi</a>
        <a href="{{ route('siswa.dispen.index') }}">Dispensasi</a>

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit"><i class="bi bi-box-arrow-right" aria-hidden="true"></i>Logout</button>
        </form>
    </nav>
</aside>