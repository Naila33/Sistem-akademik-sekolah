<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap Nilai</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            background: #f5f6fa;
            color: #333;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            background: #64748b;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <main class="container">
        <h1>Rekap Nilai</h1>
        <p>Siswa: {{ $siswa->nama }}</p>
        <p>Data nilai belum tersedia karena tabel nilai belum ada di database.</p>
        <a class="btn btn-secondary" href="{{ url()->previous() }}">Kembali</a>
    </main>
</body>

</html>