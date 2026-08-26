<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Guru</title>
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

        .logout-form {
            margin: 15px 20px 0;
        }

        .logout-form button {
            width: 100%;
            padding: 12px 0;
            border: 0;
            background: transparent;
            color: #cbd5e1;
            cursor: pointer;
            font-size: 14px;
            text-align: left;
        }

        .logout-form button:hover {
            color: white;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 210px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar-guru')

    <main class="content">
        <div class="card">
            <h1>Dashboard Guru</h1>
            <p>Selamat datang, {{ auth()->user()->username }}</p>
            <a href="{{ route('password.change') }}">Ganti Password</a>
        </div>
    </main>
</body>

</html>