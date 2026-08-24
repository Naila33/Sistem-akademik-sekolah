<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Semua Jadwal</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 24px;
            color: #212529;
        }

        form {
            max-width: 1100px;
        }

        .info {
            margin-bottom: 20px;
        }

        .mapel-row {
            display: grid;
            grid-template-columns: 2fr 2fr 1.5fr 1fr auto;
            gap: 8px;
            margin: 8px 0;
        }

        select,
        button {
            padding: 8px;
        }

        .actions {
            margin-top: 16px;
            display: flex;
            gap: 8px;
        }

        .actions a {
            padding: 8px;
        }

        .hapus {
            border: 0;
            background: #c0392b;
            color: white;
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
        <h1>Edit Semua Jadwal</h1>
        <div class="info">
            <strong>{{ $kelasTerpilih->nama_kelas }}</strong>
            <span>Tingkat {{ $kelasTerpilih->tingkat }} ·
                {{ optional($kelasTerpilih->jurusan)->kode_jurusan ?? optional($kelasTerpilih->jurusan)->nama_jurusan }}
                · {{ $hariTerpilih }}</span>
        </div>
        <form action="{{ route('admin.jadwal_pelajaran.update_hari', [$kelasTerpilih->id, $hariTerpilih]) }}"
            method="POST">
            @csrf
            @method('PUT')
            @foreach ($jadwal as $item)
                <div class="mapel-row">
                    <input type="hidden" name="jadwal_id[]" value="{{ $item->id }}">
                    <select name="mapel_id[]" required>
                        @foreach ($mapel as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->mata_pelajaran_id === (string) $option->id ? 'selected' : '' }}>{{ $option->kode_mapel }} - {{ $option->nama_mapel }}</option>
                        @endforeach
                    </select>
                    <select name="guru_id[]" required>
                        @foreach ($guru as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->guru_id === (string) $option->id ? 'selected' : '' }}>{{ $option->kode_guru ?? $option->nip }} - {{ $option->nama }}</option>
                        @endforeach
                    </select>
                    <select name="ruang_id[]" required>
                        @foreach ($ruangan as $option)
                            <option value="{{ $option->id }}" {{ (string) $item->ruangan_id === (string) $option->id ? 'selected' : '' }}>{{ $option->kode_ruang }} - {{ $option->nama_ruang }}</option>
                        @endforeach
                    </select>
                    <select name="jumlah_jp[]" required>
                        @for ($jp = 1; $jp <= 10; $jp++)
                            <option value="{{ $jp }}" {{ (int) ($item->jumlah_jp ?? 1) === $jp ? 'selected' : '' }}>{{ $jp }} JP
                            </option>
                        @endfor
                    </select>
                    <button type="button" class="hapus"
                        data-action="{{ route('admin.jadwal_pelajaran.destroy', $item->id) }}"
                        onclick="hapusJadwal(this)">Hapus</button>
                </div>
            @endforeach
            <div class="actions">
                <button type="submit">Simpan Semua</button>
                <a href="{{ route('admin.jadwal_pelajaran.index') }}">Batal</a>
            </div>
        </form>
    </main>
    <script>
        function hapusJadwal(button) {
            if (!confirm('Yakin ingin menghapus jadwal ini?')) {
                return;
            }

            const form = document.createElement('form');
            form.method = 'POST';
            form.action = button.dataset.action;
            form.innerHTML = '<input type="hidden" name="_token" value="{{ csrf_token() }}"><input type="hidden" name="_method" value="DELETE">';
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>

</html>