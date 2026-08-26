<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <title>Master Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            margin-left: 250px;
            padding: 60px;
            color: #212529;
        }
    </style>
</head>

<body>
    @include('layouts.sidebar')
    <h1>Master Guru</h1>
    @if (session('success'))
    <p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | <a
            href="{{ route('guru.create') }}">Tambah Guru</a></p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>No. HP</th>
                <th>Mata Pelajaran</th>
                <th>Status Kepegawaian</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gurus as $guru)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $guru->nip }}</td>
                    <td>{{ $guru->nama }}</td>
                    <td>{{ $guru->jk }}</td>
                    <td>{{ $guru->no_hp }}</td>
                    <td>{{ $guru->mata_pelajaran_id }}</td>
                    <td>{{ $guru->status_kepegawaian }}</td>
                    <td><a href="{{ route('guru.edit', $guru->id) }}">Edit</a>
                        <form action="{{ route('guru.destroy', $guru->id) }}" method="POST">@csrf @method('DELETE')<button
                                type="submit" onclick="return confirm('Hapus data guru?')">Hapus</button></form>
                    </td>
            </tr>@empty<tr>
                <td colspan="8">Belum ada data guru.</td>
            </tr>@endforelse
        </tbody>
    </table>
    @if (session('password_awal'))
        <div>
            <h3>Akun Guru Berhasil Dibuat</h3>

            <p>
                Username:
                <strong>{{ session('username') }}</strong>
            </p>

            <p>
                Password Awal:
                <strong>{{ session('password_awal') }}</strong>
            </p>

            <p>
                Simpan password ini dan berikan kepada guru.
            </p>
        </div>
    @endif
</body>

</html>