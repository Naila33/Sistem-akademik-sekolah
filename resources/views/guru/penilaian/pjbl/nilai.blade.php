<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <title>Penilaian PjBL</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f5f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px;
            margin: auto;
        }

        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px;
            box-sizing: border-box;
        }

        .header {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .student {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
        }

        input {
            width: 80px;
            padding: 8px;
        }

        button {
            padding: 10px 20px;
            cursor: pointer;
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
        <div class="container">

            <div class="header">

                <h2>Penilaian PjBL</h2>

                <p>
                    <strong>PjBL:</strong>
                    {{ ucwords(str_replace('_', ' ', $pjbl->periode)) }}
                </p>

                <p>
                    <strong>Guru Penguji:</strong>
                    {{ $guru->nama }}
                </p>

                <p>
                    <p>
    <strong>Jenis Penguji:</strong>
    {{ ucwords(str_replace('_', ' ', $penguji->jenis_penguji)) }}
</p>
                </p>

            </div>


            <form action="{{ route('guru.penilaian-pjbl.simpan', $pjbl->id) }}" method="POST">

                @csrf

                @forelse ($siswaKelas as $siswaKelasItem)
                    <div class="card">

                        <div class="student">

                            <div>
                                <strong>{{ $siswaKelasItem->siswa->nama }}</strong>
                                <br>
                                <small>NIS: {{ $siswaKelasItem->siswa->nis }}</small>
                            </div>

                            <div>
                                <label>Nilai</label>

                                <input type="number" name="nilai[{{ $siswaKelasItem->siswa_id }}]" min="0" max="100"
                                    required>
                            </div>

                        </div>
                    </div>
                @empty
                    <div class="card">Belum ada siswa di kelas ini.</div>
                @endforelse


                <button type="submit">
                    Simpan Penilaian
                </button>

                <a href="{{ route('guru.penilaian-pjbl.index') }}"> Kembali </a>

            </form>

        </div>
    </main>

</body>

</html>