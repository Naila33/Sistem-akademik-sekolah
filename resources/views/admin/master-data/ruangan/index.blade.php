<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Ruangan</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
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
    <h1>Master Ruangan</h1>@if(session('success'))
    <p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | <a
            href="{{ route('ruangan.create') }}">Tambah Ruangan</a></p>
    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Ruang</th>
                <th>Nama Ruang</th>
                <th>Kapasitas</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($ruangan as $item)
                <tr>
                    <td>{{ $ruangan->firstItem() + $loop->index }}</td>
                    <td>{{ $item->kode_ruang }}</td>
                    <td>{{ $item->nama_ruang }}</td>
                    <td>{{ $item->kapasitas }}</td>
                    <td>{{ $item->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td><a href="{{ route('ruangan.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST">@csrf
                            @method('DELETE')<button type="submit" onclick="return confirm('Hapus ruangan?')">Hapus</button>
                        </form>
                    </td>
            </tr>@empty<tr>
                <td colspan="6">Belum ada data ruangan.</td>
            </tr>@endforelse
        </tbody>
    </table>{{ $ruangan->links() }}
</body>

</html>