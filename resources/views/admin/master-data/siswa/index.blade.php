<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Siswa</title>
</head>

<body>
    <h1>Master Siswa</h1>
    @if (session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | <a href="{{ route('siswa.create') }}">Tambah Siswa</a></p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>NISN</th>
                <th>NIK</th>
                <th>Nama</th>
                <th>Jenis Kelamin</th>
                <th>Alamat</th>
                <th>Orang Tua</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($siswas as $siswa)<tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $siswa->nisn }}</td>
                <td>{{ $siswa->nik }}</td>
                <td>{{ $siswa->nama }}</td>
                <td>{{ $siswa->jenis_kelamin }}</td>
                <td>{{ $siswa->alamat }}</td>
                <td>{{ $siswa->nama_orang_tua }}</td>
                <td>{{ $siswa->status }}</td>
                <td><a href="{{ route('siswa.edit', $siswa->id) }}">Edit</a>
                    <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus data siswa?')">Hapus</button></form>
                </td>
            </tr>@empty<tr>
                <td colspan="9">Belum ada data siswa.</td>
            </tr>@endforelse
        </tbody>
    </table>
</body>

</html>