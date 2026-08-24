<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f6fa;
        }

        .sidebar {
            position: fixed;
            width: 250px;
            height: 100vh;
            background: #1e293b;
            color: white;
            box-sizing: border-box;
            top: 0;
            left: 0;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 25px 20px;
            border-bottom: 1px solid #334155;
        }

        .sidebar-header h2 {
            margin: 0;
            font-size: 20px;
        }

        .sidebar-header p {
            font-size: 12px;
            color: #94a3b8;
            margin: 5px 0 0;
        }

        .menu {
            padding: 15px 0;
        }

        .menu-title {
            font-size: 11px;
            color: #94a3b8;
            padding: 15px 20px 8px;
            text-transform: uppercase;
        }

        .menu a {
            display: block;
            color: #cbd5e1;
            text-decoration: none;
            padding: 12px 20px;
            font-size: 14px;
        }

        .menu a:hover {
            background: #334155;
            color: white;
        }

        .content {
            margin-left: 250px;
            padding: 30px;
        }

        .card-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .card h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <div class="content">

        <h1>Dashboard</h1>

        <p>Selamat datang di Sistem Akademik Sekolah.</p>

        <div class="card-container">

            <div class="card">
                <h3>Calon Siswa</h3>
                <p>Kelola data calon siswa SPMB.</p>

                <a href="{{ route('admin.spmb.index') }}">
                    Kelola
                </a>
            </div>

            <div class="card">
                <h3>Ruangan</h3>
                <p>Kelola data ruangan sekolah.</p>

                <a href="{{ route('ruangan.index') }}">
                    Kelola
                </a>
            </div>

            <div class="card">
                <h3>SPMB</h3>
                <p>Verifikasi pendaftaran dan daftar ulang.</p>

                <a href="{{ route('admin.spmb.index') }}">
                    Buka SPMB
                </a>
            </div>

        </div>

    </div>

</body>

</html>