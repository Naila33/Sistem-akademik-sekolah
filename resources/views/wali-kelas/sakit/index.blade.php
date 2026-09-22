@extends('layouts.app')

@section('title', 'Izin Tidak Masuk Siswa')

@section('content')
<div class="page-header">
    <h1>Izin Tidak Masuk Siswa</h1>
    <p>Daftar pengajuan izin tidak masuk siswa yang perlu verifikasi wali kelas.</p>
</div>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0 ps-3">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<div class="card">
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Siswa</th>
                    <th>Tanggal</th>
                    <th>Alasan</th>
                    <th>Dokumen</th>
                    <th>Status</th>
                    <th>Verifikasi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        <strong>{{ $item->siswa->nama ?? '-' }}</strong><br>
                        <small>NIS: {{ $item->siswa->nis ?? '-' }}</small>
                    </td>
                    <td>{{ $item->tanggal?->format('d-m-Y') ?? '-' }}</td>
                    <td>{{ $item->alasan ?? '-' }}</td>
                    <td>
                        @if($item->dokumen)
                            <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                <i class="bi bi-file-earmark-text me-1"></i>Lihat
                            </a>
                        @else
                            <span class="text-muted">Tidak ada</span>
                        @endif
                    </td>
                    <td>{{ ucfirst(str_replace('_', ' ', $item->status_walikelas ?? 'menunggu')) }}</td>
                    <td>
                        <form action="{{ route('wali-kelas.sakit.setujui', $item->id) }}" method="POST" class="d-inline-block">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-sm btn-success">
                                <i class="bi bi-check-lg me-1"></i>Setujui
                            </button>
                        </form>
                        <form action="{{ route('wali-kelas.sakit.tolak', $item->id) }}" method="POST" class="d-inline-block mt-2">
                            @csrf
                            @method('PATCH')
                            <input type="text" name="catatan" class="form-control form-control-sm mb-2" placeholder="Catatan penolakan" required>
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="bi bi-x-lg me-1"></i>Tolak
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada pengajuan izin tidak masuk siswa.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('styles')
<style>
    .page-header h1 {
        color: #2449a4;
        font-weight: 700;
    }

    .page-header+.alert+.card,
    .page-header+.card {
        padding: 0 24px 22px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
    }

    .page-header+.alert+.card table th,
    .page-header+.card table th {
        color: #334155;
        background: #f8fafc;
        font-size: 12px;
        text-transform: uppercase;
    }

    .page-header+.alert+.card table tbody tr:hover td,
    .page-header+.card table tbody tr:hover td {
        background: #f8fbff;
    }

    .page-header p {
        color: #64748b;
    }

    .page-header+.alert+.card,
    .page-header+.card {
        overflow: hidden;
    }
</style>
@endpush