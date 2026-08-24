<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Jadwal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
        }

        form {
            max-width: 1000px;
        }

        label {
            display: block;
            margin: 12px 0;
        }

        select,
        button {
            padding: 7px;
        }

        .mapel-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1.5fr 1fr auto;
            gap: 8px;
            margin: 8px 0;
        }

        .mapel-row select {
            min-width: 0;
        }

        .hapus-baris {
            color: #b42318;
            border: 0;
            background: transparent;
            cursor: pointer;
        }

        @media (max-width: 700px) {
            .mapel-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <main>
        <h1>Tambah Jadwal</h1>
        <form action="{{ route('admin.jadwal_pelajaran.store') }}" method="POST">
            @csrf
            <label>Kelas
                <select name="kelas_id" required>
                    <option value="">Pilih kelas</option>
                    @foreach ($kelas as $item)
                        <option value="{{ $item->id }}">{{ $item->nama_kelas }} - {{ $item->tingkat }}
                            {{ optional($item->jurusan)->kode_jurusan ?? optional($item->jurusan)->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
            </label>
            <label>Hari
                <select name="hari" required>
                    @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat'] as $namaHari)
                        <option value="{{ $namaHari }}">{{ $namaHari }}</option>
                    @endforeach
                </select>
            </label>
            <h3>Mapel dan JP</h3>
            <div id="mapel-list">
                <div class="mapel-row">
                    <select name="mapel_id[]" required>
                        <option value="">Pilih mapel</option>
                        @foreach ($mapel as $item)
                            <option value="{{ $item->id }}">{{ $item->kode_mapel }} - {{ $item->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <select name="guru_id[]" required>
                        <option value="">Pilih guru</option>
                        @foreach ($guru as $item)
                            <option value="{{ $item->id }}">{{ $item->kode_guru ?? $item->nip }} - {{ $item->nama }}
                            </option>
                        @endforeach
                    </select>
                    <select name="ruang_id[]" required>
                        <option value="">Pilih ruangan</option>
                        @foreach ($ruangan as $item)
                            <option value="{{ $item->id }}">{{ $item->kode_ruang }} - {{ $item->nama_ruang }}</option>
                        @endforeach
                    </select>
                    <select name="jumlah_jp[]" required>
                        @for ($jp = 1; $jp <= 10; $jp++)
                        <option value="{{ $jp }}">{{ $jp }} JP</option> @endfor
                    </select>
                    <button type="button" class="hapus-baris" onclick="this.parentElement.remove()">Hapus</button>
                </div>
            </div>
            <button type="button" onclick="tambahMapel()">+ Tambah Mapel</button>
            <button type="submit">Simpan</button>
            <a href="{{ route('admin.jadwal_pelajaran.index') }}">Batal</a>
        </form>
    </main>
    <script>
        function tambahMapel() {
            const baris = document.querySelector('.mapel-row').cloneNode(true);
            baris.querySelectorAll('select').forEach((select) => select.selectedIndex = 0);
            document.getElementById('mapel-list').appendChild(baris);
        }
    </script>
</body>

</html>