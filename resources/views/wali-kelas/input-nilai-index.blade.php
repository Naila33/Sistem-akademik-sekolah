@extends('layouts.app')

@section('title', 'Input Nilai')

@push('styles')
<style>
    .page-wrap {
        width: 100%;
    }

    .page-card {
        background: #fff;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.04);
        padding: 24px;
    }

    .page-title {
        margin: 0 0 8px;
        font-size: 25px;
        font-weight: 500;
    }

    .page-subtitle {
        margin: 0 0 20px;
        color: #6b7280;
    }

    .table th {
        background: #f8fafc;
        color: #475569;
        font-size: 0.82rem;
        vertical-align: middle;
    }

    .table td {
        vertical-align: middle;
    }

    .empty-state {
        padding: 20px;
        border-radius: 10px;
        background: #f8fafc;
        color: #64748b;
    }

    .btn-input {
        display: inline-block;
        padding: 8px 12px;
        background: #2449A4;
        color: white;
        border-radius: 8px;
        text-decoration: none;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .btn-input:hover {
        color: white;
        opacity: 0.95;
        text-decoration: none;
    }
</style>
@endpush

@section('content')
<div class="page-wrap">
    <div class="page-card">
        <h1 class="page-title">Input Nilai</h1>
        <p class="page-subtitle">Pilih jadwal untuk mengisi nilai harian siswa.</p>

        <div class="table-responsive">
            <table class="table table-bordered align-middle mb-0">
                <thead>
                    <tr>
                        <th width="60">No</th>
                        <th>Hari</th>
                        <th>Kelas</th>
                        <th>Mata Pelajaran</th>
                        <th>Ruangan</th>
                        <th width="150">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($jadwalMengajar as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->hari ?? '-' }}</td>
                        <td>
                            {{ $item->kelas?->tingkat ?? '' }}
                            {{ $item->kelas?->jurusan?->kode_jurusan ?? '' }}
                            {{ $item->kelas?->nama_kelas ?? '' }}
                        </td>
                        <td>{{ $item->mataPelajaran?->nama_mapel ?? '-' }}</td>
                        <td>{{ $item->ruangan?->nama_ruang ?? '-' }}</td>
                        <td>
                            <a href="{{ route('wali-kelas.input-nilai', $item->id) }}" class="btn-input">
                                Input Nilai
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state mb-0">
                                Belum ada jadwal yang bisa diinput nilainya.
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection