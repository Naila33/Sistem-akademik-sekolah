<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Siswa</title>
</head>

<body>
    <h1>Edit Siswa</h1>
    @if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">@csrf @method('PUT')
        <p><label>NISN<br><input name="nisn" value="{{ old('nisn', $siswa->nisn) }}" required></label></p>
        <p><label>NIK<br><input name="nik" value="{{ old('nik', $siswa->nik) }}" required></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama', $siswa->nama) }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jk" required>
                    <option value="Laki-laki" @selected(old('jk', $siswa->jk) === 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(old('jk', $siswa->jk) === 'Perempuan')>Perempuan</option>
                </select></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat', $siswa->alamat) }}</textarea></label></p>
        <p><label>Nama Orang Tua<br><input name="nama_orang_tua" value="{{ old('nama_orang_tua', $siswa->nama_orang_tua) }}" required></label></p>
        <p><label>Status<br><select name="status" required>
                    <option value="Aktif" @selected(old('status', $siswa->status) === 'Aktif')>Aktif</option>
                    <option value="Tidak Aktif" @selected(old('status', $siswa->status) === 'Tidak Aktif')>Tidak Aktif</option>
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('siswa.index') }}">Kembali</a>
    </form>
</body>

</html>