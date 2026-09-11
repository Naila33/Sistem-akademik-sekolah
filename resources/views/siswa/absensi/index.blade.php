<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Absensi Siswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
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
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.sidebar-siswa')

    <main class="content">

        <div class="container py-4">

            <div class="card shadow-sm border-0">
                <div class="card-body">

                    <h4 class="fw-bold mb-2">Absensi</h4>
                    <p class="text-muted">
                        Masukkan kode absensi yang diberikan oleh guru.
                    </p>

                    <form action="{{ route('siswa.absensi.submit') }}" method="POST">
                        @csrf

                        <div class="mb-3">
                            <label for="token" class="form-label">
                                Kode Absensi
                            </label>

                            <input type="text" name="token" id="token" class="form-control"
                                placeholder="Masukkan kode absensi" autocomplete="off" required>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            Absen
                        </button>
                    </form>

                </div>
            </div>

        </div>

    </main>

</body>

</html>