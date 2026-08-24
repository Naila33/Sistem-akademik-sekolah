<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Siswa</title>
</head>

<body>
    <h1>Tambah Siswa</h1>
    @if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('siswa.store') }}" method="POST">@csrf
        <p><label>NISN<br><input name="nisn" value="{{ old('nisn') }}" required></label></p>
        <p><label>NIK<br><input name="nik" value="{{ old('nik') }}" required></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama') }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jenis_kelamin" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat') }}</textarea></label></p>
        <p><label>Nama Orang Tua<br><input name="nama_orang_tua" value="{{ old('nama_orang_tua') }}" required></label></p>
        <p><label>Status<br><select name="status" required>
                    <option value="Aktif">Aktif</option>
                    <option value="Tidak Aktif">Tidak Aktif</option>
                </select></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('siswa.index') }}">Kembali</a>
    </form>
</body>

</html>