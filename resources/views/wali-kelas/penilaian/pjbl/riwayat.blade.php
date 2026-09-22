@extends('layouts.app')

@section('title', 'Riwayat Nilai PjBL')

@push('styles')
<style>
    .wali-pjbl-panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 2px 12px rgba(15, 23, 42, .05); }
    .wali-pjbl-heading { display: flex; align-items: center; justify-content: space-between; gap: 16px; margin-bottom: 20px; }
    .wali-pjbl-title { margin: 0; color: #2449a4; font-size: 25px; font-weight: 600; }
    .wali-pjbl-button { display: inline-flex; align-items: center; gap: 6px; padding: 9px 14px; border-radius: 8px; background: #2449a4; color: #fff; text-decoration: none; font-size: 13px; font-weight: 600; }
    .wali-pjbl-button:hover { background: #1d3d8b; color: #fff; }
    @media (max-width: 640px) { .wali-pjbl-panel { padding: 18px; } .wali-pjbl-heading { align-items: flex-start; flex-direction: column; } }
</style>
@endpush

@section('content')
<div class="wali-pjbl-panel">
    <div class="wali-pjbl-heading">
        <h1 class="wali-pjbl-title">Riwayat Nilai PjBL</h1>
        <a href="{{ route('wali-kelas.penilaian-pjbl.index') }}" class="wali-pjbl-button"><i class="bi bi-arrow-left" aria-hidden="true"></i>Kembali</a>
    </div>

    <p class="text-muted">Riwayat penilaian PJBL yang Anda kerjakan.</p>
    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead>
                <tr><th>No</th><th>Kelas</th><th>Tahun Ajaran</th><th>Semester</th><th>Aksi</th></tr>
            </thead>
            <tbody>
                @forelse ($riwayat as $item)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $item->pjbl?->kelas?->tingkat ?? '-' }} {{ $item->pjbl?->kelas?->jurusan?->kode_jurusan ?? '' }} {{ $item->pjbl?->kelas?->nama_kelas ?? '-' }}</td>
                        <td>{{ $item->pjbl?->tahunAjaran?->tahun_ajaran ?? '-' }}</td>
                        <td>{{ $item->pjbl?->tahunAjaran?->semester ?? '-' }}</td>
                        <td><a href="{{ route('wali-kelas.penilaian-pjbl.riwayat.detail', $item->id) }}" class="btn btn-sm btn-primary"><i class="bi bi-eye me-1"></i>Detail</a></td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada riwayat penilaian PJBL.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
