<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Mata Pelajaran</title>
</head>
<body>
    <h1>Tambah Mata Pelajaran</h1>

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('mata_pelajaran.store') }}" method="POST">
        @csrf

        <p>
            <label>
                Kode Mapel<br>
                <input name="kode_mapel" value="{{ old('kode_mapel') }}" required>
            </label>
        </p>

        <p>
            <label>
                Nama Mapel<br>
                <input name="nama_mapel" value="{{ old('nama_mapel') }}" required>
            </label>
        </p>

        <button type="submit">Simpan</button>
        <a href="{{ route('mata_pelajaran.index') }}">Kembali</a>
    </form>
</body>
</html>