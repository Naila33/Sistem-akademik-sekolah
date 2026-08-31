<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Siswa Kelas</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 30px;
            background: #f5f6fa;
            color: #333;
        }

        .container {
            max-width: 1100px;
            margin: 0 auto;
            background: #fff;
            padding: 25px;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            padding: 12px;
            border-bottom: 1px solid #e5e7eb;
            text-align: left;
        }

        th {
            background: #f8fafc;
        }

        .btn {
            display: inline-block;
            padding: 8px 12px;
            margin-right: 5px;
            background: #2563eb;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
        }

        .btn-secondary {
            background: #64748b;
        }
    </style>
</head>

<body>
    <main class="container">
        <h1>{{ $kelas->nama_kelas }}</h1>
        <p>Wali Kelas: {{ optional($kelas->waliKelas)->nama ?? '-' }}</p>
        <p><a href="{{ route('wali-kelas.index') }}">Kembali ke Daftar Kelas</a></p>

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($siswa as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ optional($item->siswa)->nisn ?? '-' }}</td>
                        <td>{{ optional($item->siswa)->nama ?? '-' }}</td>
                        <td>
                            @if($item->siswa)
                            <a class="btn btn-primary" href="{{ route('wali-kelas.nilai', $item->siswa) }}">Nilai</a>
                            <a class="btn btn-secondary" href="{{ route('wali-kelas.rapor', $item->siswa) }}">Rapor</a>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4">Belum ada siswa di kelas ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </main>
</body>

</html>