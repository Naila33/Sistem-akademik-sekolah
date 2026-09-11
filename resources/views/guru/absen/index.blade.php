<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi</title>

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

        .card form button {
            width: 100%;
            padding: 10px;
            background: #0d6efd;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .card form button:hover {
            background: #0b5ed7;
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
        <h1>Absensi</h1>

        <div class="cards">
            @forelse ($jadwal as $item)
                <article class="card">

                    <h2>
                        {{ $item->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}
                    </h2>

                    <p>
                        {{ $item->kelas?->tingkat ?? '' }}
                        {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                        {{ $item->kelas?->nama_kelas ?? '' }}
                    </p>

                    <form action="{{ route('absensi.buka', $item->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            Buka Absensi
                        </button>
                    </form>

                </article>
            @empty
                <div class="empty-state">
                    Belum ada jadwal pelajaran untuk Anda.
                </div>
            @endforelse
        </div>
    </main>

</body>

</html>