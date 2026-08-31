<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penilaian</title>

```
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
```

</head>

<body>

```
@include('layouts.sidebar-guru')

<main class="content">
    <h1>Penilaian</h1>

    <div class="cards">
        @forelse ($jadwal as $item)
            <article class="card">

                <h2>
                    {{ $item->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}
                </h2>

                <p>
                    <p>
                        {{ $item->kelas?->tingkat ?? '' }}
                        {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                        {{ $item->kelas?->nama_kelas ?? '' }}
                    </p>
                </p>

                <a href="{{ route('guru.penilaian.create', $item->id) }}" class="btn">
                    Input Nilai
                </a>
                <a href="{{ route('guru.penilaian.detail', $item->id) }}">
                    Detail
                </a>

            </article>
        @empty
            <div class="empty-state">
                Belum ada jadwal pelajaran untuk Anda.
            </div>
        @endforelse
    </div>
</main>
```

</body>
</html>
