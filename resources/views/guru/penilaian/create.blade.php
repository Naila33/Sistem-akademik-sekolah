<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Input Nilai</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        body {
            margin: 0;
            background: #f5f6fa;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .container {
            margin-left: 250px;
            padding: 30px;
            max-width: none;
        }

        .card {
            padding: 22px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, .05);
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border: 1px solid #dee2e6;
            padding: 10px;
            text-align: left;
        }

        .form-control,
        .form-select {
            box-sizing: border-box;
            padding: 8px 10px;
            border: 1px solid #ced4da;
            border-radius: 4px;
        }

        .form-control {
            width: 100%;
        }

        .form-select {
            width: 300px;
        }

        .btn {
            display: inline-block;
            padding: 8px 14px;
            border: 0;
            border-radius: 4px;
            text-decoration: none;
            cursor: pointer;
        }

        .btn-primary {
            background: #176b87;
            color: white;
        }

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        @media (max-width: 768px) {
            .container {
                margin-left: 210px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.sidebar-guru')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3>Input Nilai</h3>

                <p class="mb-0">
                    {{ $jadwal->mapel?->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}
                    - Tingkat {{ $jadwal->kelas?->tingkat ?? 'Tingkat tidak tersedia' }}
                    - Kelas {{ $jadwal->kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}
                    - Jurusan {{ $jadwal->kelas?->jurusan?->nama_jurusan ?? 'Jurusan tidak tersedia' }}
                </p>
            </div>

            <a href="{{ route('guru.penilaian.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guru.penilaian.store', $jadwal->id) }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Jenis Nilai
                </label>

                <select name="jenis_nilai" class="form-select" style="max-width: 300px;" required>

                    <option value="">-- Pilih --</option>

                    <option value="harian">
                        Harian
                    </option>

                    <option value="ujian">
                        Ujian
                    </option>

                </select>

            </div>

            <div class="form-group">
                <label for="tanggal_penilaian">Tanggal Penilaian</label>

                <input type="date" name="tanggal_penilaian" id="tanggal_penilaian"
                    value="{{ old('tanggal_penilaian', date('Y-m-d')) }}" required>
            </div>

            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered mb-0">

                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th width="150">Nilai</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($siswa as $index => $item)

                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>

                                        <td>
                                            {{ $item->nisn }}
                                        </td>

                                        <td>
                                            {{ $item->nama }}
                                        </td>

                                        <td>

                                            <input type="number" name="nilai[{{ $item->id }}]" class="form-control" min="0"
                                                max="100" step="0.01" placeholder="0-100">

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="mt-3">
                <button type="submit" class="btn btn-primary">
                    Simpan Semua Nilai
                </button>

                <a href="{{ route('guru.penilaian.detail', $jadwal->id) }}" class="btn btn-secondary">
                    Lihat Detail
                </a>
            </div>

        </form>

    </div>

</body>

</html>