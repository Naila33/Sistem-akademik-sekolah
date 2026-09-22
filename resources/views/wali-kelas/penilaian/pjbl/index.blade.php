@extends('layouts.app')

@section('title', 'Penilaian PjBL')

@push('styles')
<style>
    .wali-pjbl-page {
        width: 100%;
    }

    .wali-pjbl-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 2px 12px rgba(15, 23, 42, 0.05);
        padding: 24px;
    }

    .wali-pjbl-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
        margin-bottom: 8px;
    }

    .wali-pjbl-heading h1 {
        margin: 0;
        color: #1e293b;
        font-size: 25px;
        font-weight: 600;
    }

    .wali-pjbl-subtitle {
        margin: 0 0 22px;
        color: #64748b;
    }

    .wali-pjbl-card {
        margin-bottom: 16px;
        padding: 18px 20px;
        border: 1px solid #dbeafe;
        border-radius: 10px;
        background: #f8fbff;
    }

    .wali-pjbl-card h2 {
        margin: 0 0 10px;
        color: #1e3a8a;
        font-size: 18px;
        font-weight: 600;
    }

    .wali-pjbl-meta {
        margin: 6px 0;
        color: #475569;
    }

    .wali-pjbl-button {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        margin-top: 12px;
        padding: 9px 14px;
        border: 0;
        border-radius: 8px;
        background: #2449a4;
        color: #ffffff;
        text-decoration: none;
        font-size: 13px;
        font-weight: 600;
    }

    .wali-pjbl-button:hover {
        background: #1d3d8b;
        color: #ffffff;
    }

    @media (max-width: 640px) {
        .wali-pjbl-panel {
            padding: 18px;
        }

        .wali-pjbl-heading {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="wali-pjbl-page">
    <div class="wali-pjbl-panel">
        <div class="wali-pjbl-heading">
            <h1>Penilaian PjBL</h1>
            <a href="{{ route('wali-kelas.penilaian-pjbl.riwayat') }}" class="wali-pjbl-button">
                <i class="bi bi-clock-history" aria-hidden="true"></i>
                Riwayat Penilaian
            </a>
        </div>

        <p class="wali-pjbl-subtitle">Daftar penilaian proyek siswa yang ditugaskan kepada Anda.</p>
        <p class="wali-pjbl-meta"><strong>Guru:</strong> {{ $guru->nama ?? '-' }}</p>

        @forelse ($pjblPenguji as $item)
            <div class="wali-pjbl-card">
                <h2>{{ $item->pjbl->periode ? ucwords(str_replace('_', ' ', $item->pjbl->periode)) : '-' }}</h2>
                <p class="wali-pjbl-meta">
                    <strong>Kelas:</strong>
                    {{ $item->pjbl->kelas->tingkat ?? '-' }}
                    {{ $item->pjbl->kelas->jurusan->kode_jurusan ?? '' }}
                    {{ $item->pjbl->kelas->nama_kelas ?? '' }}
                </p>
                <p class="wali-pjbl-meta">
                    <strong>Tahun Ajaran:</strong>
                    {{ $item->pjbl->tahunAjaran->tahun_ajaran ?? '-' }}
                    {{ $item->pjbl->tahunAjaran->semester ?? '-' }}
                </p>
                <p class="wali-pjbl-meta">
                    <strong>Jenis Penguji:</strong>
                    {{ $item->jenis_peguji ? ucwords(str_replace('_', ' ', $item->jenis_peguji)) : '-' }}
                </p>
                <a href="{{ route('wali-kelas.penilaian-pjbl.nilai', $item->pjbl_id) }}" class="wali-pjbl-button">
                    <i class="bi bi-pencil-square" aria-hidden="true"></i>
                    Mulai Menilai
                </a>
            </div>
        @empty
            <p class="wali-pjbl-meta mb-0">Belum ada PjBL yang ditugaskan kepada Anda.</p>
        @endforelse
    </div>
</div>
@endsection
