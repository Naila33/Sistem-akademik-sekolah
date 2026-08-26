<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Ruangan</title>
</head>

<body>
    <h1>Tambah Ruangan</h1>@if($errors->any())
        <ul>@foreach($errors->all() as $error)
        <li>{{ $error }}</li>@endforeach
    </ul>@endif
    <form action="{{ route('ruangan.store') }}" method="POST">@csrf
        <p><label>Kode Ruang<br><input name="kode_ruang" value="{{ old('kode_ruang') }}" required></label></p>
        <p><label>Nama Ruang<br><input name="nama_ruang" value="{{ old('nama_ruang') }}" required></label></p>
        <p><label>Kapasitas<br><input type="number" name="kapasitas" value="{{ old('kapasitas') }}" min="1"
                    required></label></p>
        <p><label>Status<br><select name="status" required>
                    <option value="1" {{ old('status', '1') === '1' ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ old('status') === '0' ? 'selected' : '' }}>Tidak Aktif</option>
                </select></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('ruangan.index') }}">Kembali</a>
    </form>
</body>

</html>