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
        <div class="menu-title">Akademik</div>
        <a href="{{ route('ruangan.index') }}">Ruangan</a>
    </div>

    <div>
        <div class="jadwal">
        <div class="jadwal-title">Jadwal Pelajaran</div>
        <a href="{{ route('admin.jadwal_pelajaran.index') }}">Lihat Jadwal</a>
        </div>
    </div>
</aside>
