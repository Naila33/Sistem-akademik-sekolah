<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Guru</title>
</head>

<body>
    <h1>Tambah Guru</h1>
    @if ($errors->any())
        <ul>@foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    @endif
    <form action="{{ route('guru.store') }}" method="POST">@csrf
        <p><label>NIP<br>
                <input name="nip" value="{{ old('nip') }}" required></label></p>
        <p><label>Nama<br>
                <input name="nama" value="{{ old('nama') }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jk" required>
                    <option value="">Pilih</option>
                    <option value="Laki-laki">Laki-laki</option>
                    <option value="Perempuan">Perempuan</option>
                </select></label></p>
        <p><label>Tanggal Lahir<br><input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required></label>
        </p>
        <p><label>Agama<br><select name="agama" required>
                    <option value="">Pilih agama</option>
                    @foreach(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Budha', 'Konghucu'] as $agama)
                    <option value="{{ $agama }}">{{ $agama }}</option>@endforeach
                </select></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat') }}</textarea></label></p>
        <p><label>No. HP<br><input name="no_hp" value="{{ old('no_hp') }}" required></label></p>
        <p><label>Email<br><input type="email" name="email" value="{{ old('email') }}" required></label></p>
        <p><label>Status Kepegawaian<br><select name="status_kepegawaian" required>
                    <option value="">Pilih status</option>
                    @foreach(['PNS', 'PPPK', 'Honorer', 'Guru_tetap', 'Guru_tidak_tetap'] as $status)
                    <option value="{{ $status }}">{{ str_replace('_', ' ', $status) }}</option>@endforeach
                </select></label></p>
        <p><label>Jabatan<br><select name="jabatan" required>
                    <option value="">Pilih jabatan</option>
                    @foreach(['Guru', 'Kepala_sekolah', 'Waka_sekolah'] as $jabatan)
                    <option value="{{ $jabatan }}">{{ str_replace('_', ' ', $jabatan) }}</option>@endforeach
                </select></label></p>
        <p><label>TMT<br><input type="date" name="tmt" value="{{ old('tmt') }}" required></label></p>
        <p><label>Mata Pelajaran<br><select name="mata_pelajaran_id" required>
                    <option value="">Pilih mata pelajaran</option>
                    @foreach($mataPelajaran as $mapel)
                        <option value="{{ $mapel->id }}">{{ $mapel->kode_mapel }} - {{ $mapel->nama_mapel }}</option>
                    @endforeach
                </select></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('guru.index') }}">Kembali</a>
    </form>
</body>

</html>