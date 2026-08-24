<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 12px;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 8px;
        }

        h2 {
            text-align: center;
            margin: 0 0 8px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #555;
            padding: 2px;
            text-align: center;
            vertical-align: middle;
            height: 18px;
        }

        th {
            background: #e8f0f3;
        }

        .kelas {
            width: 72px;
            background: #f7fafb;
        }

        .info {
            width: 38px;
            background: #f7fafb;
        }

        .day {
            width: 145px;
        }

        .jp-zero {
            width: 22px;
            background: #f4f6f4;
            font-weight: bold;
        }

        .jp {
            font-weight: normal;
            background: #eef5ed;
        }

        .label {
            font-weight: bold;
            background: #f7fafb;
        }

        .mapel {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <h2>JADWAL PELAJARAN</h2>
    <table>
        <thead>
            <tr>
                <th class="kelas" rowspan="2">Kelas</th>
                <th class="info" rowspan="2">Info</th>
                @foreach ($hari as $namaHari)
                    <th class="day" colspan="12">{{ strtoupper($namaHari) }}</th>
                @endforeach
            </tr>
            <tr>
                @foreach ($hari as $namaHari)
                    <th class="jp">0</th>
                    @for ($jp = 1; $jp <= 10; $jp++)
                        <th class="jp">{{ $jp }}</th>
                    @endfor
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse ($jadwalPerKelas as $jadwalKelas)
                @php
                    $kelas = $jadwalKelas->first()->kelas;
                    $labelKelas = trim(($kelas->tingkat ?? '-') . ' ' .
                        (optional($kelas->jurusan)->kode_jurusan ?? optional($kelas->jurusan)->nama_jurusan ?? '-') . ' ' .
                        ($kelas->nama_kelas ?? $jadwalKelas->first()->kelas_id));
                @endphp
                @foreach (['mapel', 'guru', 'ruang'] as $baris => $jenisBaris)
                    <tr>
                        @if ($baris === 0)
                            <td class="kelas" rowspan="3">
                                <strong>{{ $labelKelas }}</strong>
                            </td>
                        @endif
                        <td class="info label">{{ ucfirst($jenisBaris) }}</td>
                        @foreach ($hari as $namaHari)
                            @php
                                $jadwalHari = $jadwalKelas->filter(fn($item) => strtolower($item->hari) === strtolower($namaHari))->values();
                                $jpPosisi = 0;
                                $kegiatanJpZero = [
                                    'Senin' => 'Apel/Pembinaan',
                                    'Selasa' => 'Serasi',
                                    'Rabu' => 'Rehat',
                                    'Kamis' => 'Kasihku',
                                    'Jumat' => 'Keagamaan',
                                ][$namaHari] ?? '-';
                            @endphp
                            @if ($jenisBaris === 'mapel')
                                <td class="jp-zero" rowspan="3">{{ $kegiatanJpZero }}</td>
                            @endif
                            @foreach ($jadwalHari as $item)
                                @php
                                    $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), 11 - $jpPosisi);
                                    $nilai = match ($jenisBaris) {
                                        'mapel' => optional($item->mapel)->kode_mapel ?? ($item->mata_pelajaran_id ?? '-'),
                                        'guru' => optional($item->guru)->kode_guru ?? $item->guru_id,
                                        default => optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-'),
                                    };
                                @endphp
                                <td colspan="{{ $jumlahJp }}" class="{{ $jenisBaris }}" @if ($jenisBaris === 'mapel')
                                style="background-color: {{ optional($item->mapel)->warna ?? '#d3d3d3' }}" @endif>{{ $nilai }}</td>
                                @php $jpPosisi += $jumlahJp; @endphp
                            @endforeach
                            @if ($jpPosisi < 11)
                                <td colspan="{{ 11 - $jpPosisi }}"></td>
                            @endif
                        @endforeach
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="57">Belum ada data jadwal pelajaran.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>