<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
</head>

<body>
    <h1>Edit Kelas</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">@csrf @method('PUT')
        <p><label>Tingkat<br><input name="tingkat" value="{{ old('tingkat', $kelas->tingkat) }}" required></label></p>
        <p><label>Jurusan<br><input name="jurusan" value="{{ old('jurusan', $kelas->jurusan) }}" required></label></p>
        <p><label>Nama Kelas<br><input name="nama_kelas" value="{{ old('nama_kelas', $kelas->nama_kelas) }}" required></label></p>
        <p><label>Wali Kelas<br><select name="wali_kelas_id">
                    <option value="">Pilih wali kelas</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}" @selected(old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id)>{{ $guru->nama }}</option>@endforeach
                </select></label></p>
        <p><label>Tahun Ajaran<br><select name="tahun_ajaran_id">
                    <option value="">Pilih tahun ajaran</option>@foreach($tahunAjarans as $tahun)<option value="{{ $tahun->id }}" @selected(old('tahun_ajaran_id', $kelas->tahun_ajaran_id) == $tahun->id)>{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}</option>@endforeach
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('kelas.index') }}">Kembali</a>
    </form>
</body>

</html>