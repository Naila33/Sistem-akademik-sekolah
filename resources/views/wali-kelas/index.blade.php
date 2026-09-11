@extends('layouts.app')

@section('title', 'Wali Kelas')

@section('content')

<div class="container py-4">
    <div class="mb-4">
        <h3>Wali Kelas</h3>
        <p class="text-muted">
            Kelola dan periksa nilai siswa kelas.
        </p>
    </div>

        @if($waliKelas->isNotEmpty())

    @foreach($waliKelas as $wali)
        <div class="card mb-3">
            <div class="card-body">

                <h5>
                    Kelas {{ $wali->kelas->tingkat }}
                    {{ $wali->kelas->nama_kelas }}
                </h5>

                <p class="text-muted">
                    Jurusan:
                    {{ $wali->kelas->jurusan->nama_jurusan ?? '-' }}
                </p>

                <a href="{{ route('wali-kelas.siswa', $wali->kelas->id) }}"
                   class="btn btn-primary">
                    Lihat Siswa
                </a>

            </div>
        </div>
    @endforeach

@else

    <div class="alert alert-info">
        Kamu belum ditugaskan sebagai wali kelas.
    </div>

@endif
</div>

@endsection