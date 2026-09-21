@extends('layouts.app')

@section('title', 'Penilaian PjBL')

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
            <h2 class="page-title">Penilaian PjBL</h2>
            <p class="page-subtitle">Guru: {{ $guru->nama ?? '-' }}</p>

            @forelse ($pjblPenguji as $item)
                <div class="pjbl-card">
                    <h3>{{ $item->pjbl->periode ?? '-' }}</h3>

                    <p class="pjbl-meta">
                        Kelas: {{ $item->pjbl->kelas->nama_kelas ?? '-' }}
                    </p>

                    <p class="pjbl-meta">
                        Tahun Ajaran: {{ $item->pjbl->tahunAjaran->tahun_ajaran ?? '-' }}
                        {{ $item->pjbl->tahunAjaran->semester ?? '-' }}
                    </p>

                    <p class="pjbl-meta">
                        Jenis Penguji: {{ ucwords(str_replace('_', ' ', $item->jenis_penguji)) }}
                    </p>

                    <a href="{{ route('guru.penilaian-pjbl.nilai', $item->pjbl_id) }}" class="btn-nilai fs-12">
                        Mulai Menilai
                    </a>
                </div>
            @empty
                <p class="mb-0 text-muted">Belum ada PjBL yang ditugaskan kepada Anda.</p>
            @endforelse
        </div>
    </div>
@endsection