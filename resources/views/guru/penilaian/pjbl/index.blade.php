<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Penilaian PjBL</title>
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

    @media (max-width: 768px) {
        .content {
            margin-left: 210px;
            padding: 20px;
        }
    }
        </style>
</head>
<body>

    @include('layouts.sidebar-guru')

    <main class="content">
    <h2>Penilaian PjBL</h2>

    <p>
        Guru: {{ $guru->nama }}
    </p>

    @forelse ($pjblPenguji as $item)

        <div style="border: 1px solid #ddd; padding: 15px; margin-bottom: 10px;">

            <h3>
                {{ $item->pjbl->periode ?? '-' }}
            </h3>

            <p>
                Kelas:
                {{ $item->pjbl->kelas->nama_kelas ?? '-' }}
            </p>

            <p>
                Tahun Ajaran:
                {{ $item->pjbl->tahunAjaran->tahun_ajaran ?? '-' }}
                {{ $item->pjbl->tahunAjaran->semester ?? '-' }}
            </p>

            <p>
                Jenis Penguji:
                {{ ucwords(str_replace('_', ' ', $item->jenis_penguji)) }}
            </p>

            <a href="{{ route('guru.penilaian-pjbl.nilai', $item->pjbl_id) }}">
                Mulai Menilai
            </a>

        </div>

    @empty

        <p>
            Belum ada PjBL yang ditugaskan kepada Anda.
        </p>

    @endforelse
    </main>

</body>
</html>