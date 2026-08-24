<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Jadwal</title>
</head>

<body>
    <main>
        <h1>Edit Jadwal</h1>
        <form action="{{ route('admin.jadwal_pelajaran.update', $jadwal->id) }}" method="POST">
            @csrf
            @method('PUT')
            <label>Kelas
                <select name="kelas_id" required>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}" {{ (string) $jadwal->kelas_id === (string) $item->id ? 'selected' : '' }}>{{ $item->nama_kelas }} - {{ $item->tingkat }}
                            {{ optional($item->jurusan)->kode_jurusan ?? optional($item->jurusan)->nama_jurusan }}</option>
                    @endforeach
                </select>
            </label>
            <label>Guru
                <select name="guru_id" required>
                    @foreach ($guru as $item)
                        <option value="{{ $item->id }}" {{ (string) $jadwal->guru_id === (string) $item->id ? 'selected' : '' }}>{{ $item->kode_guru ?? $item->nip }} - {{ $item->nama }}</option>
                    @endforeach
                </select>
            </label>
            <label>Mapel
                <select name="mapel_id" required>
                    @foreach ($mapel as $item)
                        <option value="{{ $item->id }}" {{ (string) ($jadwal->mata_pelajaran_id ?? $jadwal->mapel_id) === (string) $item->id ? 'selected' : '' }}>{{ $item->kode_mapel }} -
                            {{ $item->nama_mapel }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label>Ruangan
                <select name="ruang_id" required>
                    @foreach ($ruangan as $item)
                        <option value="{{ $item->id }}" {{ (string) ($jadwal->ruangan_id ?? $jadwal->ruang_id) === (string) $item->id ? 'selected' : '' }}>{{ $item->kode_ruang }} - {{ $item->nama_ruang }}</option>
                    @endforeach
                </select>
            </label>
            <label>Hari
                <select name="hari" required>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $namaHari)
                        <option value="{{ $namaHari }}" {{ strtolower($jadwal->hari) === strtolower($namaHari) ? 'selected' : '' }}>{{ $namaHari }}</option>
                    @endforeach
                </select>
            </label>
            <label>Jumlah JP
                <select name="jumlah_jp" required>
                    @for ($jp = 1; $jp <= 10; $jp++)
                        <option value="{{ $jp }}" {{ (int) ($jadwal->jumlah_jp ?? 1) === $jp ? 'selected' : '' }}>JP {{ $jp }}
                        </option>
                    @endfor
                </select>
            </label>
            <button type="submit">Simpan Perubahan</button>
            <a href="{{ route('admin.jadwal_pelajaran.index') }}">Batal</a>
        </form>
    </main>
</body>

</html>