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
    </style>
</head>
<body>
<h1>Jadwal Mengajar</h1>

@include('layouts.sidebar-guru')
@forelse ($jadwal as $item)

    <div>
        <strong>{{ $item->hari }}</strong>
        <br>

        Kelas:
        {{ $item->kelas->tingkat ?? '-' }}
        {{ $item->kelas->jurusan->kode_jurusan }}  
        {{ $item->kelas->nama_kelas ?? '-' }}

        <br>

        Mata Pelajaran:
        {{ $item->mapel->nama_mapel ?? '-' }}

        <br>

        Ruangan:
        {{ $item->ruangan->nama_ruang ?? '-' }}
    </div>

    <hr>

@empty

    <p>Belum ada jadwal yang dipublikasikan.</p>

@endforelse
</body>
</html>