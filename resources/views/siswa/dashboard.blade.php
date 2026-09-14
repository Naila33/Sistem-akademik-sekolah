@extends('layouts.app')

@section('title', 'Dashboard Siswa')

@push('styles')
    <style>
    </style>
@endpush

@section('content')
   <div class="card rounded-3 shadow-sm p-4 mb-4 border-0"> 
    <p class="mb-0 fs-4"> Halo, <span class="fw-bold"> {{ $siswa?->nama ?? auth()->user()->username ?? 'Siswa' }} </span>
</div>
<div class="row g-3">
<div class="col-md-4">
        <div class="card card-biodata rounded-3 shadow-sm border-0 p-4 mt-4">
            <h2 class="mb-3"> Biodata Siswa </h2>
        <p>NIS: {{ $siswa?->nis ?? 'NIS tidak tersedia' }}</p>
        <p>NO hp: {{ $siswa?->no_hp ?? 'NO hp tidak tersedia' }}</p>
        <p>Jenis kelamin: {{ $siswa?->jk ?? 'Jenis kelamin tidak tersedia' }}</p>
        <p>Kelas: {{ $kelas?->tingkat ?? 'Kelas tidak tersedia' }}
                {{ $kelas?->jurusan?->kode_jurusan ?? 'Kelas tidak tersedia' }}
                {{ $kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}<p>
        <p>Walas: {{ $kelas?->waliKelas?->nama ?? 'Walas tidak tersedia' }}</p>
        <p>Tahun ajaran: {{ $kelas?->tahunAjaran?->tahun_ajaran ?? 'Tahun ajaran tidak tersedia' }}</p>
        <p>Semester: {{ $kelas?->tahunAjaran?->semester ?? 'Semester tidak tersedia' }}</p>
    </div>
    </div>
    <div class="col-md-8">
    <div class="card card-jadwal rounded-3 shadow-sm border-0 p-4 mt-4 mb-4">
        <h2 class="mb-3"> Jadwal Pelajaran </h2>
        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Hari</th>
                        <th>Jam</th>
                        <th>Mata Pelajaran</th>
                        <th>Guru</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwal as $item)
                        <tr>
                            <td>{{ $item->hari }}</td>
                            <td>{{ $item->jam }}</td>
                            <td>{{ $item->mapel->nama_mapel ?? 'Mata pelajaran tidak tersedia' }}</td>
                            <td>{{ $item->guru->nama ?? 'Guru tidak tersedia' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center">Tidak ada jadwal pelajaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
    </div>
    </div>
@endsection