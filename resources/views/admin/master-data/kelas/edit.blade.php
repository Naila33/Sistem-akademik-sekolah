<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Kelas</title>
</head>

<body>
    <h1>Edit Kelas</h1>@if($errors->any())
        <ul>@foreach($errors->all() as $error)
        <li>{{ $error }}</li>@endforeach
    </ul>@endif
    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">@csrf @method('PUT')
        <p><label>Tingkat<br><select name="tingkat" required>
                    <option value="">Pilih tingkat</option>
                    @foreach(['X', 'XI', 'XII'] as $tingkat)
                        <option value="{{ $tingkat }}" @selected(old('tingkat', $kelas->tingkat) === $tingkat)>{{ $tingkat }}
                        </option>
                    @endforeach
                </select></label></p>
        <p><label>Jurusan<br><select name="jurusan_id" required>
                    <option value="">Pilih jurusan</option>@foreach($jurusans as $jurusan)
                        <option value="{{ $jurusan->id }}" @selected(old('jurusan_id', $kelas->jurusan_id) == $jurusan->id)>
                            {{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}
                    </option>@endforeach
                </select></label></p>
        <p><label>Nama Kelas<br><select name="nama_kelas" required>
                    <option value="">Pilih nama kelas</option>
                    @foreach(['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'] as $namaKelas)
                        <option value="{{ $namaKelas }}" @selected(old('nama_kelas', $kelas->nama_kelas) === $namaKelas)>
                            {{ $namaKelas }}</option>
                    @endforeach
                </select></label></p>
        <p><label>Wali Kelas<br><select name="wali_kelas_id">
                    <option value="">Pilih wali kelas</option>@foreach($gurus as $guru)
                        <option value="{{ $guru->id }}" @selected(old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id)>
                            {{ $guru->nama }}
                    </option>@endforeach
                </select></label></p>
        <p><label>Tahun Ajaran<br><select name="tahun_ajaran_id">
                    <option value="">Pilih tahun ajaran</option>@foreach($tahunAjarans as $tahun)
                        <option value="{{ $tahun->id }}" @selected(old('tahun_ajaran_id', $kelas->tahun_ajaran_id) == $tahun->id)>{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}
                    </option>@endforeach
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('kelas.index') }}">Kembali</a>
    </form>
</body>

</html>