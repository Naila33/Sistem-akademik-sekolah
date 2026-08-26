<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jadwal Pelajaran</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            margin-left: 250px;
            padding: 60px;
            color: #212529;
        }

        .container {
            background-color: white;
            padding: 24px;
            border: 1px solid #dfe5e8;
            border-radius: 8px;
            overflow-x: auto;
            margin-top: 35px;
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 5px;
        }

        .header p {
            color: #666;
            margin: 0;
        }

        .btn-tambah {
            background-color: #176b87;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
            white-space: nowrap;
        }

        .success {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .toolbar {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 16px;
        }

        .filter label {
            display: block;
            color: #5c6970;
            font-size: 12px;
            margin-bottom: 5px;
        }

        .filter select,
        .filter button {
            border: 1px solid #b7c5ca;
            border-radius: 4px;
            padding: 8px 10px;
            background: white;
        }

        .filter button {
            background: #176b87;
            color: white;
            cursor: pointer;
        }

        .download-button {
            display: inline-block;
            margin-left: 6px;
            border-radius: 4px;
            padding: 8px 10px;
            background: #217346;
            color: white;
            font-size: 13px;
            text-decoration: none;
        }

        .download-pdf {
            background: #b42318;
        }

        .legend {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 16px;
        }

        .legend-item {
            border: 1px solid #d9e1e5;
            border-radius: 3px;
            padding: 4px 7px;
            font-size: 11px;
        }

        table {
            width: 100%;
            min-width: 1100px;
            border-collapse: collapse;
            table-layout: fixed;
        }

        th,
        td {
            border: 1px solid #cbd5da;
            padding: 8px;
            vertical-align: top;
        }

        th {
            background-color: #e8f0f3;
            text-align: center;
        }

        .identity {
            width: 95px;
            background-color: #f7fafb;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .row-labels {
            width: 55px;
            background-color: #f7fafb;
            padding: 0;
            text-align: center;
            vertical-align: middle;
        }

        .identity strong {
            display: block;
            font-size: 14px;
        }

        .identity span {
            color: #65747c;
            font-size: 12px;
        }

        .identity-row {
            display: block;
            min-height: 24px;
            padding: 4px 6px;
            box-sizing: border-box;
            border-top: 1px solid #cbd5da;
            text-align: center;
        }

        .identity-row:first-child {
            border-top: 0;
        }

        .row-label {
            display: flex;
            min-height: 30px;
            align-items: center;
            justify-content: center;
            border-top: 1px solid #cbd5da;
            font-size: 11px;
        }

        .row-label:first-child {
            border-top: 0;
        }

        .identity-row strong,
        .identity-row span {
            display: block;
        }

        .day {
            width: 255px;
            min-height: 110px;
        }

        .day-header {
            display: block;
            margin: -8px -8px 8px;
            padding: 4px;
            border-bottom: 1px solid #cbd5da;
        }

        .jp-numbers,
        .schedule-list,
        .schedule-row {
            display: grid;
            grid-template-columns: repeat(10, minmax(22px, 1fr));
            gap: 0;
        }

        .jp-numbers {
            margin-top: 8px;
            padding-top: 4px;
            border-top: 1px solid #cbd5da;
        }

        .jp-number {
            border-right: 1px solid #cbd5da;
            color: #176b87;
            font-size: 10px;
            font-weight: normal;
            text-align: center;
        }

        .jp-number:last-child {
            border-right: 0;
        }

        .schedule-list {
            align-items: start;
        }

        .schedule-list {
            display: block;
        }

        .schedule-row {
            min-height: 24px;
            align-items: stretch;
        }

        .schedule-row+.schedule-row {
            border-top: 1px solid #cbd5da;
        }

        .schedule-value {
            min-width: 0;
            overflow: hidden;
            padding: 4px 2px;
            border-right: 1px solid #cbd5da;
            text-align: center;
            white-space: nowrap;
            text-overflow: ellipsis;
            font-size: 12px;
        }

        .schedule-value:last-child {
            border-right: 0;
        }

        .schedule-value.mapel {
            font-weight: bold;
            font-size: 12px;
        }

        .schedule-actions {
            display: flex;
            justify-content: flex-start;
            gap: 3px;
            margin-top: 2px;
        }

        .schedule-actions a,
        .schedule-actions button {
            border: 0;
            border-radius: 2px;
            padding: 1px 3px;
            color: white;
            cursor: pointer;
            font-size: 9px;
            text-decoration: none;
        }

        .day-footer {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 6px;
            margin-top: 5px;
        }

        .day-actions {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 3px;
        }

        .day-action {
            border: 0;
            border-radius: 2px;
            padding: 2px 4px;
            color: white;
            font-size: 9px;
            text-decoration: none;
        }

        .day-action.edit {
            background-color: #176b87;
        }

        .day-action.delete {
            background-color: #c0392b;
        }

        .schedule-actions a {
            background-color: #176b87;
        }

        .schedule-actions button {
            background-color: #c0392b;
        }

        .schedule-value.empty {
            color: transparent;
        }

        .schedule {
            border: 1px solid #d9e1e5;
            background-color: #fffdf2;
            box-sizing: border-box;
            min-width: 0;
            margin: 0;
            padding: 0;
            font-size: 12px;
            text-align: center;
        }

        .schedule strong {
            display: block;
            color: #263238;
            overflow-wrap: anywhere;
            padding: 3px 2px;
        }

        .schedule small {
            display: block;
            color: #000000;
            line-height: 1.35;
            white-space: nowrap;
            border-top: 1px solid #d9e1e5;
            padding: 3px 2px;
        }

        .schedule .actions {
            border-top: 1px solid #d9e1e5;
            padding: 3px 2px;
        }

        .actions {
            margin-top: 3px;
            font-size: 10px;
        }

        .empty-cell {
            color: #a0abb0;
            text-align: center;
            font-size: 12px;
        }

        .day-count {
            display: block;
            color: #65747c;
            font-size: 11px;
            font-weight: normal;
            margin-top: 3px;
        }

        .btn-edit {
            color: #0d6efd;
            text-decoration: none;
        }

        .btn-hapus {
            color: #dc3545;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font: inherit;
        }

        @media (max-width: 600px) {
            body {
                padding: 15px;
                margin-left: 210px;
            }

            .container {
                padding: 15px;
            }

            .header {
                align-items: flex-start;
                flex-direction: column;
            }
        }
    </style>
</head>

<body>
     @include('layouts.sidebar')
        <div class="header">
            <div>
                <h1>Jadwal Pelajaran</h1>
                <p>Daftar jadwal pelajaran yang telah ditambahkan.</p>
            </div>
            <a href="{{ route('admin.jadwal_pelajaran.create') }}" class="btn-tambah">
                + Tambah Jadwal
            </a>
        </div>

        <div class="toolbar">
            <form action="{{ route('admin.jadwal_pelajaran.index') }}" method="GET" class="filter">
                <label for="jurusan_id">Tampilkan jurusan</label>
                <select name="jurusan_id" id="jurusan_id">
                    <option value="">Semua Jurusan</option>
                    @foreach ($jurusanList as $jurusan)
                        <option value="{{ $jurusan->id }}" {{ (string) $selectedJurusan === (string) $jurusan->id ? 'selected' : '' }}>
                            {{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}
                        </option>
                    @endforeach
                </select>
                <button type="submit">Tampilkan</button>
                <a href="{{ route('admin.jadwal_pelajaran.export_excel', ['jurusan_id' => $selectedJurusan]) }}"
                    class="download-button">Download Excel</a>
                <a href="{{ route('admin.jadwal_pelajaran.export_pdf', ['jurusan_id' => $selectedJurusan]) }}"
                    class="download-button download-pdf">Download PDF</a>
            </form>
        </div>

    <main class="container">
        <table>
            <thead>
                <tr>
                    <th class="identity">Kelas</th>
                    <th class="row-labels">Info</th>
                    @foreach ($hari as $namaHari)
                        <th class="day">
                            <span class="day-header">
                                {{ $namaHari }}
                                <span class="jp-numbers">
                                    @for ($jp = 1; $jp <= 10; $jp++)
                                        <span class="jp-number">{{ $jp }}</span>
                                    @endfor
                                </span>
                            </span>
                        </th>
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
                    <tr>
                        <td class="identity">
                            <div class="identity-row">
                                <strong>{{ $labelKelas }}</strong>
                            </div>
                        </td>
                        <td class="row-labels">
                            <div class="row-label">Mapel</div>
                            <div class="row-label">Guru</div>
                            <div class="row-label">Ruang</div>
                        </td>
                        @foreach ($hari as $namaHari)
                            <td class="day">
                                @php
                                    $jadwalHari = $jadwalKelas
                                        ->filter(fn($item) => strtolower($item->hari) === strtolower($namaHari))
                                        ->values();
                                    $jpPosisi = 1;
                                @endphp
                                <div class="schedule-list">
                                    @foreach (['mapel', 'guru', 'ruang'] as $jenisBaris)
                                        <div class="schedule-row">
                                            @forelse ($jadwalHari as $item)
                                                @php
                                                    $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), 10);
                                                    $jumlahJpTampil = min($jumlahJp, 12 - $jpPosisi);
                                                    $nilaiBaris = match ($jenisBaris) {
                                                        'mapel' => optional($item->mapel)->kode_mapel ?? ($item->mata_pelajaran_id ?? '-'),
                                                        'guru' => optional($item->guru)->kode_guru ?? $item->guru_id,
                                                        default => optional($item->ruangan)->kode_ruang ?? ($item->ruangan_id ?? '-'),
                                                    };
                                                @endphp
                                                <div class="schedule-value {{ $jenisBaris === 'mapel' ? 'mapel' : '' }}"
                                                    style="background-color: {{ $jenisBaris === 'mapel' ? optional($item->mapel)->warna ?? '#d3d3d3' : '#ffffff' }}; grid-column: {{ $jpPosisi }} / span {{ $jumlahJpTampil }};"
                                                    title="{{ optional($item->guru)->nama ?? $item->guru_id }} | {{ optional($item->ruangan)->nama_ruang ?? ($item->ruangan_id ?? '-') }}">
                                                    {{ $nilaiBaris }}
                                                </div>
                                                @php $jpPosisi += $jumlahJpTampil; @endphp
                                            @empty
                                                <div class="schedule-value empty" style="grid-column: 1 / -1;">-</div>
                                            @endforelse
                                        </div>
                                        @php $jpPosisi = 1; @endphp
                                    @endforeach
                                </div>
                                @if ($jadwalHari->isNotEmpty())
                                    <div class="day-footer">
                                        <span class="day-count">{{ $jadwalHari->count() }} mapel</span>
                                        <div class="day-actions">
                                            <a href="{{ route('admin.jadwal_pelajaran.edit_hari', [$jadwalKelas->first()->kelas_id, $namaHari]) }}"
                                                class="day-action edit">Edit Semua</a>
                                        </div>
                                    </div>
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">Belum ada data jadwal pelajaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </main>
</body>

</html>