<aside class="sidebar">
    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Admin Sekolah</p>
    </div>
    <div class="menu">
        <div class="menu-title">Menu Utama</div>
        <a href="{{ route('admin.dashboard') }}">Dashboard</a>
        <div class="menu-title">SPMB</div>
        <a href="{{ route('admin.spmb.index') }}">Calon Siswa</a>
        <div class="menu-title">Master Data</div>
        <a href="{{ route('jurusan.index') }}">Jurusan</a>
        <a href="{{ route('ruangan.index') }}">Ruangan</a>
        <a href="{{ route('mata_pelajaran.index') }}">Mata Pelajaran</a>
        <a href="{{ route('tahun-ajaran.index') }}">Tahun Ajaran</a>
        <a href="{{ route('siswa.index') }}">Siswa</a>
        <a href="{{ route('guru.index') }}">Guru</a>
        <a href="{{ route('kelas.index') }}">Kelas</a>
        <div class="menu-title">Pembagian Kelas</div>
        <a href="{{ route('pembagian_kelas.index') }}">Pembagian Kelas</a>
        <div class="menu-title">Jadwal</div>
        <a href="{{ route('admin.jadwal_pelajaran.index') }}">Lihat Jadwal</a>
    </div>
    <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>
</aside>
