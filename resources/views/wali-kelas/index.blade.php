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

    @if($kelas->isNotEmpty())
    <div class="card shadow-sm border-0">
        <div class="card-body">
            <h5 class="mb-3">Kelas yang Diampu</h5>

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Kelas</th>
                        <th>Tingkat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($kelas as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->nama_kelas }}</td>
                        <td>{{ $item->tingkat }}</td>
                        <td>
                            <a href="{{ route('wali-kelas.siswa', $item->id) }}" class="btn btn-primary btn-sm">
                                Lihat Siswa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center">
                            Belum ada kelas yang diampu.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    @else
    <div class="alert alert-warning">
        Guru ini belum ditetapkan sebagai wali kelas.
    </div>
    @endif
</div>

@endsection