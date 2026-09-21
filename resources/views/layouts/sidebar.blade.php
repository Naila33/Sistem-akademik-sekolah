<aside class="sidebar">

   

    <div class="sidebar-header">
        <h2>Sistem Akademik</h2>
        <p>Admin Sekolah</p>
    </div>



    <div class="menu">

        <div class="menu-title">
            Menu Utama
        </div>

        <a href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span>Dashboard</span>
        </a>




        <div class="menu-title">
            SPMB
        </div>

        <a href="{{ route('admin.spmb.index') }}">
            <i class="bi bi-person-plus"></i>
            <span>Calon Siswa</span>
        </a>



        <div class="menu-title">
            Master Data
        </div>

        <a href="{{ route('jurusan.index') }}">
            <i class="bi bi-diagram-3"></i>
            <span>Jurusan</span>
        </a>

        <a href="{{ route('ruangan.index') }}">
            <i class="bi bi-building"></i>
            <span>Ruangan</span>
        </a>

        <a href="{{ route('mata_pelajaran.index') }}">
            <i class="bi bi-book"></i>
            <span>Mata Pelajaran</span>
        </a>

        <a href="{{ route('tahun-ajaran.index') }}">
            <i class="bi bi-calendar3"></i>
            <span>Tahun Ajaran</span>
        </a>

        <a href="{{ route('siswa.index') }}">
            <i class="bi bi-people"></i>
            <span>Siswa</span>
        </a>

        <a href="{{ route('guru.index') }}">
            <i class="bi bi-person-badge"></i>
            <span>Guru</span>
        </a>

        <a href="{{ route('kelas.index') }}">
            <i class="bi bi-grid-3x3-gap"></i>
            <span>Kelas</span>
        </a>



        <div class="menu-title">
            Pembagian Kelas
        </div>

        <a href="{{ route('pembagian_kelas.index') }}">
            <i class="bi bi-diagram-2"></i>
            <span>Pembagian Kelas</span>
        </a>


        <div class="menu-title">
            Jadwal
        </div>

        <a href="{{ route('admin.jadwal_pelajaran.index') }}">
            <i class="bi bi-calendar-week"></i>
            <span>Lihat Jadwal</span>
        </a>


        <div class="menu-title">
            Presensi
        </div>

        <a href="{{ route('admin.absensi.index') }}">
            <i class="bi bi-calendar-check"></i>
            <span>Absensi</span>
        </a>

        <a href="{{ route('admin.sakit.index') }}">
            <i class="bi bi-heart-pulse"></i>
            <span>Pengajuan Sakit</span>
        </a>

        <a href="{{ route('admin.izin-keluar.index') }}">
            <i class="bi bi-box-arrow-right"></i>
            <span>Izin Keluar</span>
        </a>

        <a href="{{ route('admin.izin-pulang.index') }}">
            <i class="bi bi-house-door"></i>
            <span>Izin Pulang</span>
        </a>

        <a href="{{ route('admin.dispen.index') }}">
            <i class="bi bi-file-earmark-text"></i>
            <span>Dispensasi</span>
        </a>


        <div class="menu-title">
            Penilaian
        </div>

        <a href="{{ route('admin.penilaian.mapel.index') }}">
            <i class="bi bi-journal-check"></i>
            <span>Penilaian Mata Pelajaran</span>
        </a>

        <a href="{{ route('admin.penilaian.pjbl.index') }}">
            <i class="bi bi-clipboard-check"></i>
            <span>Penilaian PJBL</span>
        </a>

    </div>


  

    <form
        action="{{ route('logout') }}"
        method="POST"
        class="logout-form"
    >
        @csrf

        <button type="submit">
            <i class="bi bi-box-arrow-right"></i>
            <span>Logout</span>
        </button>
    </form>

</aside>