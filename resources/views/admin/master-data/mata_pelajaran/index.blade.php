<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Master Mata Pelajaran</title>
</head>
<body>

    <h1>Master Mata Pelajaran</h1>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <p>
        <a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | 
        <a href="{{ route('mata_pelajaran.create') }}">Tambah Mata Pelajaran</a>
    </p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Mapel</th>
                <th>Nama Mapel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($mata_pelajaran as $mapel)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mapel->kode_mapel }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>
                        <a href="{{ route('mata_pelajaran.edit', $mapel->id) }}">Edit</a>
                        
                        <form action="{{ route('mata_pelajaran.destroy', $mapel->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('Hapus mata pelajaran?')">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" align="center">Belum ada data mata pelajaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 10px;">
        {{ $mata_pelajaran->links() }}
    </div>

</body>
</html>