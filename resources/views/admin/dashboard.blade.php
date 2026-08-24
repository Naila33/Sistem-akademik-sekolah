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
            width: 240px;
            height: 100vh;
            background: #1e293b;
            color: white;
            padding: 20px;
            box-sizing: border-box;
        }

        .sidebar h2 {
            margin-top: 0;
        }

        .sidebar a {
            display: block;
            color: white;
            text-decoration: none;
            padding: 12px;
            margin-top: 5px;
            border-radius: 6px;
        }

        .sidebar a:hover {
            background: #334155;
        }

        .content {
            margin-left: 240px;
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
            box-shadow: 0 2px 10px rgba(0,0,0,.05);
        }

        .card h3 {
            margin-top: 0;
        }
    </style>
</head>

<body>

<div class="sidebar">

    <h2>SPMB Admin</h2>

    <a href="{{ route('admin.dashboard') }}">
        Dashboard
    </a>

    <a href="{{ route('admin.spmb.index') }}">
        Calon Siswa
    </a>

    <a href="{{ route('ruangan.index') }}">
        Ruangan
    </a>

</div>

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