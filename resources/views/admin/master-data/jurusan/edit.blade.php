<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jurusan</title>
</head>

<body>
    <h1>Edit Jurusan</h1>

    @if ($errors->any())
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <form action="{{ route('jurusan.update', $jurusan->id) }}" method="POST">
        @csrf
        @method('PUT')
        <p>
            <label for="kode_jurusan">Kode Jurusan</label><br>
            <input type="text" id="kode_jurusan" name="kode_jurusan" value="{{ old('kode_jurusan', $jurusan->kode_jurusan) }}" required>
        </p>
        <p>
            <label for="nama_jurusan">Nama Jurusan</label><br>
            <input type="text" id="nama_jurusan" name="nama_jurusan" value="{{ old('nama_jurusan', $jurusan->nama_jurusan) }}" required>
        </p>
        <button type="submit">Simpan Perubahan</button>
        <a href="{{ route('jurusan.index') }}">Kembali</a>
    </form>
</body>

</html>