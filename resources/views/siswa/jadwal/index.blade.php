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
            margin-top: 25px;
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

        .toolbar {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 16px;
        }

        .download-button {
            display: inline-block;
            margin-left: 6px;
            border-radius: 4px;
            padding: 8px 12px;
            background: #217346;
            color: white;
            font-size: 13px;
            text-decoration: none;
        }

        .download-pdf {
            background: #b42318;
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

        .schedule-value.empty {
            color: transparent;
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

    @include('layouts.sidebar-siswa')

    <div class="header">
        <div>
            <h1>Jadwal Pelajaran</h1>
            <p>Daftar jadwal pelajaran yang berlaku.</p>
        </div>
    </div>

    <div class="toolbar">
        <div>
            <a href="{{ route('admin.jadwal_pelajaran.export_excel') }}" class="download-button">Download Excel</a>
            <a href="{{ route('admin.jadwal_pelajaran.export_pdf') }}" class="download-button download-pdf">Download
                PDF</a>
        </div>
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
                                <span class="jp-numbers"
                                    style="grid-template-columns: repeat({{ $jumlahJpPerHari[$namaHari] ?? 10 }}, minmax(22px, 1fr));">
                                    @for ($jp = 1; $jp <= ($jumlahJpPerHari[$namaHari] ?? 10); $jp++)
                                        <span class="jp-number">{{ $jp }}</span>
                                    @endfor
                                </span>
                            </span>
                        </th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="identity">
                        <div class="identity-row">
                            <strong>
                                {{ $kelas->tingkat ?? '-' }}
                                {{ optional($kelas->jurusan)->kode_jurusan ?? '' }}
                                {{ $kelas->nama_kelas ?? '' }}
                            </strong>
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
                                $jadwalHari = $jadwal
                                    ->filter(
                                        fn($item) =>
                                        strtolower($item->hari) === strtolower($namaHari)
                                    )
                                    ->values();
                                $jumlahJpHari = $jumlahJpPerHari[$namaHari] ?? 10;

                                // Tentukan posisi setiap jadwal berdasarkan urutan JP
                                $posisiJadwal = [];
                                $jpPosisi = 1;

                                foreach ($jadwalHari as $item) {
                                    $jumlahJp = min(max((int) ($item->jumlah_jp ?? 1), 1), $jumlahJpHari);

                                    $jumlahJpTampil = min(
                                        $jumlahJp,
                                        $jumlahJpHari + 1 - $jpPosisi
                                    );

                                    if ($jumlahJpTampil > 0) {
                                        $posisiJadwal[] = [
                                            'item' => $item,
                                            'mulai' => $jpPosisi,
                                            'jumlah' => $jumlahJpTampil,
                                        ];

                                        $jpPosisi += $jumlahJpTampil;
                                    }

                                    if ($jpPosisi > $jumlahJpHari) {
                                        break;
                                    }
                                }
                            @endphp

                            <div class="schedule-list">

                                {{-- BARIS MAPEL --}}
                                <div class="schedule-row"
                                    style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                    @forelse ($posisiJadwal as $data)
                                        @php
                                            $item = $data['item'];
                                        @endphp

                                        <div class="schedule-value mapel" style="
                                            background-color: {{ optional($item->mapel)->warna ?? '#d3d3d3' }};
                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                        " title="{{ optional($item->mapel)->nama_mapel ?? '-' }}">
                                            {{ optional($item->mapel)->kode_mapel ?? '-' }}
                                        </div>
                                    @empty
                                        <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                            -
                                        </div>
                                    @endforelse
                                </div>

                                {{-- BARIS GURU --}}
                                <div class="schedule-row"
                                    style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                    @forelse ($posisiJadwal as $data)
                                        @php
                                            $item = $data['item'];
                                        @endphp

                                        <div class="schedule-value" style="
                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                        " title="{{ optional($item->guru)->nama ?? '-' }}">
                                            {{ optional($item->guru)->kode_guru ?? '-' }}
                                        </div>
                                    @empty
                                        <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                            -
                                        </div>
                                    @endforelse
                                </div>

                                {{-- BARIS RUANG --}}
                                <div class="schedule-row"
                                    style="grid-template-columns: repeat({{ $jumlahJpHari }}, minmax(22px, 1fr));">
                                    @forelse ($posisiJadwal as $data)
                                        @php
                                            $item = $data['item'];
                                        @endphp

                                        <div class="schedule-value" style="
                                            grid-column: {{ $data['mulai'] }} / span {{ $data['jumlah'] }};
                                        " title="{{ optional($item->ruangan)->nama_ruang ?? '-' }}">
                                            {{ optional($item->ruangan)->kode_ruang ?? '-' }}
                                        </div>
                                    @empty
                                        <div class="schedule-value empty" style="grid-column: 1 / -1;">
                                            -
                                        </div>
                                    @endforelse
                                </div>

                            </div>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </main>
</body>

</html>