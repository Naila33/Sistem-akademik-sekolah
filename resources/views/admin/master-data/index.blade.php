<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Data</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f7fb; margin: 0; padding: 32px; color: #1f2937; }
        .container { max-width: 900px; margin: auto; }
        h1 { margin-bottom: 8px; }
        .subtitle { color: #6b7280; margin-bottom: 24px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 16px; }
        .card { display: block; padding: 20px; background: white; border: 1px solid #e5e7eb; border-radius: 8px; text-decoration: none; color: inherit; }
        .card:hover { border-color: #2563eb; box-shadow: 0 4px 12px rgba(37, 99, 235, .12); }
        .card h2 { margin: 0 0 8px; font-size: 18px; }
        .card p { margin: 0; color: #6b7280; font-size: 14px; }
        .disabled { opacity: .55; cursor: default; }
    </style>
</head>
<body>
    <main class="container">
        <h1>Master Data</h1>
        <p class="subtitle">Kelola data utama sistem akademik sekolah.</p>

        <section class="grid">
            <a class="card disabled" href="#">
                <h2>Siswa</h2>
                <p>Belum tersedia</p>
            </a>
            <a class="card disabled" href="#">
                <h2>Guru</h2>
                <p>Belum tersedia</p>
            </a>
            <a class="card disabled" href="#">
                <h2>Jurusan</h2>
                <p>Belum tersedia</p>
            </a>
            <a class="card" href="{{ route('mata_pelajaran.index') }}">
                <h2>Mata Pelajaran</h2>
                <p>Buka data mata pelajaran</p>
            </a>
            <a class="card disabled" href="#">
                <h2>Kelas</h2>
                <p>Belum tersedia</p>
            </a>
            <a class="card" href="{{ route('ruangan.index') }}">
                <h2>Ruangan</h2>
                <p>Buka data ruangan</p>
            </a>
            <a class="card" href="{{ route('tahun-ajaran.index') }}">
                <h2>Tahun Ajaran</h2>
                <p>Buka data tahun ajaran</p>
            </a>
        </section>
    </main>
</body>
</html>
