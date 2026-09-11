<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Siswa</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        body {
            margin: 0;
            background: #f5f6fa;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px;
        }

        .card {
            max-width: 700px;
            padding: 25px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .card h1 {
            margin-top: 0;
            margin-bottom: 10px;
        }

        .card p {
            color: #64748b;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 210px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar-siswa')

    <main class="content">
        <div class="card">
            <h1>Dashboard Siswa</h1>
            <p>Selamat datang, {{ auth()->user()->username ?? 'Siswa' }}</p>
        </div>
    </main>
</body>

</html>