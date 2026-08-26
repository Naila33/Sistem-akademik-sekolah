<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian</title>
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

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 20px;
        }

        .card {
            padding: 22px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .card h2 {
            margin: 0 0 10px;
            font-size: 18px;
        }

        .card p {
            margin: 0 0 20px;
            color: #64748b;
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

        .empty-state {
            padding: 22px;
            background: white;
            border-radius: 10px;
            color: #64748b;
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
        <h1>Penilaian</h1>

        @forelse ($jadwal as $item)
            <div class="cards">
                <article class="card">
                    <h2>{{ $item->mapel?->nama ?? 'Mata pelajaran tidak tersedia' }}</h2>
                    <p>
                        Kelas {{ $item->kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}<br>
                        Jurusan {{ $item->kelas?->jurusan?->nama_jurusan ?? 'Jurusan tidak tersedia' }}
                    </p>
                    <a href="{{ route('guru.penilaian.create', $item->id) }}" class="btn">
                        Input Nilai
                    </a>
                </article>
            </div>
        @empty
            <div class="empty-state">Belum ada jadwal pelajaran untuk Anda.</div>
        @endforelse
    </main>

</html>
</body>