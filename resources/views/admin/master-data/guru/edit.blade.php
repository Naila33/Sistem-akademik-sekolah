<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Guru</title>
</head>

<body>
    <h1>Edit Guru</h1>
    @if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('guru.update', $guru->id) }}" method="POST">@csrf @method('PUT')
        <p><label>NIP<br><input name="nip" value="{{ old('nip', $guru->nip) }}" required></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama', $guru->nama) }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jenis_kelamin" required>
                    <option @selected(old('jenis_kelamin', $guru->jenis_kelamin) === 'Laki-laki')>Laki-laki</option>
                    <option @selected(old('jenis_kelamin', $guru->jenis_kelamin) === 'Perempuan')>Perempuan</option>
                </select></label></p>
        <p><label>Kontak<br><input name="kontak" value="{{ old('kontak', $guru->kontak) }}" required></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat', $guru->alamat) }}</textarea></label></p>
        <p><label>Status<br><select name="status" required>
                    <option @selected(old('status', $guru->status) === 'Aktif')>Aktif</option>
                    <option @selected(old('status', $guru->status) === 'Tidak Aktif')>Tidak Aktif</option>
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('guru.index') }}">Kembali</a>
    </form>
</body>

</html>