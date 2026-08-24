<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Guru</title>
</head>

<body>
    <h1>Master Guru</h1>
    @if (session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | <a href="{{ route('guru.create') }}">Tambah Guru</a></p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NIP</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Kontak</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($gurus as $guru)<tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $guru->nip }}</td>
                <td>{{ $guru->nama }}</td>
                <td>{{ $guru->jenis_kelamin }}</td>
                <td>{{ $guru->kontak }}</td>
                <td>{{ $guru->alamat }}</td>
                <td>{{ $guru->status }}</td>
                <td><a href="{{ route('guru.edit', $guru->id) }}">Edit</a>
                    <form action="{{ route('guru.destroy', $guru->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus data guru?')">Hapus</button></form>
                </td>
            </tr>@empty<tr>
                <td colspan="8">Belum ada data guru.</td>
            </tr>@endforelse
        </tbody>
    </table>
</body>

</html>