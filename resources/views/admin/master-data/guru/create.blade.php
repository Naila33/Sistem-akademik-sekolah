<!DOCTYPE html>
<html lang="id">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0"><title>Tambah Guru</title></head>
<body><h1>Tambah Guru</h1>
@if ($errors->any())<ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
<form action="{{ route('guru.store') }}" method="POST">@csrf
<p><label>NIP<br><input name="nip" value="{{ old('nip') }}" required></label></p><p><label>Nama<br><input name="nama" value="{{ old('nama') }}" required></label></p><p><label>Jenis Kelamin<br><select name="jenis_kelamin" required><option value="">Pilih</option><option>Laki-laki</option><option>Perempuan</option></select></label></p><p><label>Kontak<br><input name="kontak" value="{{ old('kontak') }}" required></label></p><p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat') }}</textarea></label></p><p><label>Status<br><select name="status" required><option>Aktif</option><option>Tidak Aktif</option></select></label></p>
<button type="submit">Simpan</button> <a href="{{ route('guru.index') }}">Kembali</a></form></body></html>
