@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="page-header">
        <p>Selamat datang, {{ auth()->user()->username }}</p>
    </div>

    <div class="card mb-4">
        <h3>Profil Guru</h3>
        <p><strong>Username:</strong> {{ auth()->user()->username }}</p>
        <p><strong>Nama Guru:</strong> {{ optional($guru)->nama ?? 'Belum diatur' }}</p>
        <p><strong>Wali Kelas:</strong>
            @if($waliKelas->isNotEmpty())
            @foreach($waliKelas as $wali)
            @php
            $tingkat = $wali->kelas->tingkat ?? '';
            $jurusan = $wali->kelas->jurusan->nama_jurusan ?? '';
            $kodeKelas = $wali->kelas->nama_kelas ?? '';
            $waliKelasText = trim($tingkat . ' ' . $jurusan . ' ' . $kodeKelas);
            @endphp
            {{ $waliKelasText ?: 'Belum ditugaskan' }}
            @if(!$loop->last), @endif
            @endforeach
            @else
            Belum ditugaskan
            @endif
        </p>
        <p><strong>Mapel yang diajar:</strong>
            @if($jadwalMengajar->isNotEmpty())
            @foreach($jadwalMengajar as $jadwal)
            {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
            @if(!$loop->last), @endif
            @endforeach
            @else
            Belum ada jadwal mengajar
            @endif
        </p>

        <div class="mt-3">
            <a href="{{ route('password.change') }}" class="btn btn-primary">Ganti Password</a>
        </div>
    </div>

    @if($jadwalMengajar->isNotEmpty())
    <div class="card">
        <h3>Jadwal Mengajar</h3>
        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>Kelas</th>
                        <th>Jurusan</th>
                        <th>Kode Kelas</th>
                        <th>Ruangan</th>
                        <th>Hari</th>
                        <th>JP</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($jadwalMengajar as $jadwal)
                    <tr>
                        <td>{{ $jadwal->kelas->tingkat ?? '-' }}</td>
                        <td>{{ $jadwal->kelas->jurusan->nama_jurusan ?? '-' }}</td>
                        <td>{{ $jadwal->kelas->nama_kelas ?? '-' }}</td>
                        <td>{{ $jadwal->ruangan->nama_ruang ?? 'Teori' }}</td>
                        <td>{{ $jadwal->hari ?? '-' }}</td>
                        <td>{{ $jadwal->jumlah_jp ?? 0 }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
</div>
@endsection