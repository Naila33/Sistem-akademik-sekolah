<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard Admin</title>

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #f5f6fa;
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