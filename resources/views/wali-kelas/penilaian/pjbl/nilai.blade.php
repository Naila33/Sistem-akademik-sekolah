@extends('layouts.app')

@section('title', 'Input Nilai PjBL')

@push('styles')
<style>
    .wali-pjbl-panel { background: #fff; border: 1px solid #e2e8f0; border-radius: 12px; padding: 24px; box-shadow: 0 2px 12px rgba(15, 23, 42, .05); }
    .wali-pjbl-title { margin: 0 0 8px; color: #2449a4; font-size: 25px; font-weight: 600; }
    .wali-pjbl-subtitle { color: #64748b; margin-bottom: 22px; }
    .wali-pjbl-info, .wali-pjbl-student { border: 1px solid #dbeafe; border-radius: 10px; background: #f8fbff; padding: 16px 18px; margin-bottom: 14px; }
    .wali-pjbl-info p { margin: 5px 0; color: #475569; }
    .wali-pjbl-student-row { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
    .wali-pjbl-student-name { color: #1e293b; font-weight: 600; }
    .wali-pjbl-input { width: 100px; padding: 8px 10px; border: 1px solid #cbd5e1; border-radius: 7px; }
    .wali-pjbl-button { display: inline-flex; align-items: center; gap: 6px; padding: 9px 14px; border: 0; border-radius: 8px; background: #2449a4; color: #fff; text-decoration: none; font-size: 13px; font-weight: 600; }
    .wali-pjbl-button:hover { background: #1d3d8b; color: #fff; }
    .wali-pjbl-button.secondary { background: #e2e8f0; color: #334155; }
    @media (max-width: 640px) { .wali-pjbl-panel { padding: 18px; } .wali-pjbl-student-row { align-items: flex-start; flex-direction: column; } }
</style>
@endpush

@section('content')
<div class="wali-pjbl-panel">
    <h1 class="wali-pjbl-title">Input Nilai PjBL</h1>
    <p class="wali-pjbl-subtitle">Masukkan nilai siswa pada proyek yang ditugaskan kepada Anda.</p>

    <div class="wali-pjbl-info">
        <p><strong>PjBL:</strong> {{ ucwords(str_replace('_', ' ', $pjbl->periode)) }}</p>
        <p><strong>Guru Penguji:</strong> {{ $guru->nama ?? '-' }}</p>
        <p><strong>Jenis Penguji:</strong> {{ $penguji?->jenis_peguji ? ucwords(str_replace('_', ' ', $penguji->jenis_peguji)) : '-' }}</p>
    </div>

    <form action="{{ route('wali-kelas.penilaian-pjbl.simpan', $pjbl->id) }}" method="POST">
        @csrf
        @forelse ($siswaKelas as $siswaKelasItem)
            <div class="wali-pjbl-student">
                <div class="wali-pjbl-student-row">
                    <div>
                        <div class="wali-pjbl-student-name">{{ $siswaKelasItem->siswa->nama ?? '-' }}</div>
                        <small class="text-muted">NIS: {{ $siswaKelasItem->siswa->nis ?? '-' }}</small>
                    </div>
                    <label>
                        Nilai
                        <input class="wali-pjbl-input" type="number" name="nilai[{{ $siswaKelasItem->siswa_id }}]" min="0" max="100" value="{{ old('nilai.' . $siswaKelasItem->siswa_id, $nilaiSiswa->get($siswaKelasItem->siswa_id)) }}" required>
                    </label>
                </div>
            </div>
        @empty
            <div class="alert alert-info">Belum ada siswa di kelas ini.</div>
        @endforelse

        <button type="submit" class="wali-pjbl-button"><i class="bi bi-check-lg" aria-hidden="true"></i>Simpan Penilaian</button>
        <a href="{{ route('wali-kelas.penilaian-pjbl.index') }}" class="wali-pjbl-button secondary">Kembali</a>
    </form>
</div>
@endsection
