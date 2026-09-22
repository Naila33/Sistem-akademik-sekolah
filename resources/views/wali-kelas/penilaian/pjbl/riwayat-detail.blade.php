@extends('layouts.app')

@section('title', 'Detail Riwayat Nilai PjBL')

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
        <div>
            <h1 class="wali-pjbl-title">Detail Riwayat Penilaian</h1>
            <p class="text-muted mb-0">{{ $penguji->pjbl?->nama_periode ?? $penguji->pjbl?->periode ?? 'PJBL' }}</p>
        </div>
        <a href="{{ route('wali-kelas.penilaian-pjbl.riwayat') }}" class="wali-pjbl-button"><i class="bi bi-arrow-left" aria-hidden="true"></i>Kembali</a>
    </div>

    <div class="mb-4">
        <p class="mb-1"><strong>Kelas:</strong> {{ $penguji->pjbl?->kelas?->tingkat ?? '' }} {{ $penguji->pjbl?->kelas?->jurusan?->kode_jurusan ?? '' }} {{ $penguji->pjbl?->kelas?->nama_kelas ?? '-' }}</p>
        <p class="mb-1"><strong>Tahun Ajaran:</strong> {{ $penguji->pjbl?->tahunAjaran?->tahun_ajaran ?? '-' }} {{ $penguji->pjbl?->tahunAjaran?->semester ?? '-' }}</p>
        <p class="mb-0"><strong>Terakhir diperbarui:</strong> {{ $penguji->penilaian->first()?->updated_at?->format('d/m/Y') ?? '-' }}</p>
    </div>

    <div class="table-responsive">
        <table class="table table-hover align-middle">
            <thead><tr><th>No</th><th>Nama Siswa</th><th>NIS</th><th>Nilai</th><th>Tanggal Penilaian</th></tr></thead>
            <tbody>
                @forelse ($penguji->penilaian as $item)
                    <tr><td>{{ $loop->iteration }}</td><td>{{ $item->siswa?->nama ?? '-' }}</td><td>{{ $item->siswa?->nis ?? '-' }}</td><td class="fw-semibold">{{ $item->nilai }}</td><td>{{ $item->updated_at?->format('d/m/Y') ?? '-' }}</td></tr>
                @empty
                    <tr><td colspan="5" class="text-center text-muted py-4">Belum ada nilai pada sesi ini.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
