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

        <form action="{{ route('logout') }}" method="POST" class="logout-form">
            @csrf
            <button type="submit">Logout</button>
        </form>
    </nav>
</aside>