@extends('layouts.app')

@section('title', 'Riwayat Nilai PjBL')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }

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
            font-size: 25px;
            font-weight: 500;
            margin: 0 0 8px;
        }

        .page-subtitle {
            margin: 0 0 22px;
            color: #6b7280;
        }

        .pjbl-card {
            border: 1px solid #e5e7eb;
            padding: 18px 20px;
            border-radius: 12px;
            margin-bottom: 16px;
            background: #fff;
        }

        .pjbl-card h3 {
            margin: 0 0 10px;
            font-size: 20px;
        }

        .pjbl-meta {
            margin: 6px 0;
            color: #374151;
        }

        .btn-nilai {
            display: inline-block;
            margin-top: 12px;
            padding: 9px 14px;
            border-radius: 8px;
            background: #2449A4;
            color: #fff;
            text-decoration: none;
            font-weight: 500;
        }

        .btn-nilai:hover {
            color: #fff;
            background: #1d3f8c;
        }

        @media (max-width: 768px) {
            .page-card {
                padding: 18px;
            }
        }

        .fs-12 {
            font-size: 13px;
        }
    </style>
@endpush

@section('content')
    <div class="page-wrap">
        <div class="page-card">
            <div class="d-flex justify-content-between align-items-center mb-1">
            <h1 class="page-title">Riwayat Nilai PjBL</h1>

            <a href="{{ route('guru.penilaian-pjbl.index') }}" class="btn btn-secondary fs-12">
                    Kembali
                </a>
</div>

 <p class="page-subtitle">Pilih tahun ajaran untuk melihat detail riwayat penilaian.</p>
            <div class="table-responsive">
                <table class="table table-bordered table-hover align-middle mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kelas</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayat as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->pjbl?->kelas?->tingkat ?? '-' }} {{ $item->pjbl?->kelas?->jurusan?->kode_jurusan ?? '' }} {{ $item->pjbl?->kelas?->nama_kelas ?? '-' }}</td>
                                <td>{{ $item->pjbl?->tahunAjaran?->tahun_ajaran ?? '-' }}</td>
                                <td>{{ $item->pjbl?->tahunAjaran?->semester ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('guru.penilaian-pjbl.riwayat.detail', $item->id) }}"
                                        class="btn btn-sm btn-primary">
                                        <i class="bi bi-eye me-1"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted py-4">
                                    Belum ada riwayat penilaian PJBL.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection