<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Ruangan</title>
</head>

<body>
    <h1>Edit Ruangan</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('ruangan.update', $ruangan->id) }}" method="POST">@csrf @method('PUT')
        <p><label>Kode Ruang<br><input name="kode_ruang" value="{{ old('kode_ruang', $ruangan->kode_ruang) }}" required></label></p>
        <p><label>Nama Ruang<br><input name="nama_ruang" value="{{ old('nama_ruang', $ruangan->nama_ruang) }}" required></label></p>
        <p><label>Kapasitas<br><input type="number" name="kapasitas" value="{{ old('kapasitas', $ruangan->kapasitas) }}" min="1" required></label></p>
        <p><label>Status<br><select name="status" required>
                    <option value="Aktif" @selected(old('status', $ruangan->status) === 'Aktif')>Aktif</option>
                    <option value="Tidak Aktif" @selected(old('status', $ruangan->status) === 'Tidak Aktif')>Tidak Aktif</option>
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('ruangan.index') }}">Kembali</a>
    </form>
</body>

</html>