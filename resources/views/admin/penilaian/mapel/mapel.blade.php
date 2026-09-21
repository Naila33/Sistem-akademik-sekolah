@extends('layouts.app')

@section('title', 'Penilaian ' . $mataPelajaran->nama_mapel)

@push('styles')
    <style>
        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .academic-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .academic-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .academic-header p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .btn-back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .btn-back-link:hover {
            color: #2563eb;
        }

        .btn-action-primary {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: 1px solid #2563eb !important;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .btn-action-secondary {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-action-secondary:hover {
            background-color: #f8fafc;
            color: #1e293b;
            border-color: #94a3b8;
        }

        .badge-blue-harian {
            background-color: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-blue-ujian {
            background-color: #dbeafe;
            color: #1e40af;
            border: 1px solid #93c5fd;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-action-edit {
            color: #2563eb;
            background-color: #eff6ff;
            border: 1px solid #bfdbfe;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
        }

        .btn-action-edit:hover {
            background-color: #2563eb;
            color: #ffffff;
            border-color: #2563eb;
        }

        .btn-action-delete {
            color: #dc2626;
            background-color: #fef2f2;
            border: 1px solid #fecaca;
            padding: 5px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action-delete:hover {
            background-color: #dc2626;
            color: #ffffff;
            border-color: #dc2626;
        }
    </style>
@endpush

@section('content')
<div class="academic-container">

    <a href="{{ route('admin.penilaian.mapel.kelas', $kelas->id) }}" class="btn-back-link">
        <i class="bi bi-arrow-left"></i> Kembali ke Mata Pelajaran
    </a>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="academic-header border-0 mb-0 pb-0">
            <h1>{{ $mataPelajaran->nama_mapel }}</h1>
            <p>
                Penilaian {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
                @if($kelas->jurusan)
                    — {{ $kelas->jurusan->nama_jurusan }}
                @endif
            </p>
        </div>

        <a href="{{ route('admin.penilaian.mapel.create', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}" class="btn-action-primary">
            <i class="bi bi-plus-lg"></i> Tambah Penilaian
        </a>
    </div>


    <div class="academic-card mb-4">
        <form method="GET" action="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}">
            <div class="row g-3">
                <div class="col-md-5">
                    <label class="form-label fw-semibold text-secondary fs-7">Cari Siswa</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control" placeholder="Nama, NIS, atau NISN">
                    </div>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold text-secondary fs-7">Jenis Nilai</label>
                    <select name="jenis_nilai" class="form-select">
                        <option value="">Semua Jenis</option>
                        <option value="harian" @selected(request('jenis_nilai') === 'harian')>Harian</option>
                        <option value="ujian" @selected(request('jenis_nilai') === 'ujian')>Ujian</option>
                    </select>
                </div>

                <div class="col-md-2">
                    <label class="form-label fw-semibold text-secondary fs-7">Tanggal</label>
                    <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="form-control">
                </div>

                <div class="col-md-2 d-flex align-items-end gap-2">
                    <button type="submit" class="btn-action-primary w-100 justify-content-center">
                        <i class="bi bi-funnel"></i> Filter
                    </button>
                    <a href="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}" class="btn-action-secondary" title="Reset">
                        <i class="bi bi-arrow-counterclockwise"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>

    <div class="academic-card p-0 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4" width="60">No</th>
                        <th>NIS</th>
                        <th>Siswa</th>
                        <th>Jenis Nilai</th>
                        <th>Nilai</th>
                        <th>Tanggal</th>
                        <th class="pe-4 text-end" width="160">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($penilaian as $item)
                        <tr>
                            <td class="ps-4 fw-medium text-secondary">{{ $loop->iteration }}</td>
                            <td>{{ $item->siswa?->nis ?? '-' }}</td>
                            <td class="fw-semibold text-dark">{{ $item->siswa?->nama ?? '-' }}</td>
                            <td>
                                @if($item->jenis_nilai === 'harian')
                                    <span class="badge-blue-harian">Harian</span>
                                @elseif($item->jenis_nilai === 'ujian')
                                    <span class="badge-blue-ujian">Ujian</span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold fs-6 text-dark">{{ $item->nilai }}</span>
                            </td>
                            <td class="text-secondary">{{ $item->tanggal_penilaian?->format('d/m/Y') ?? $item->created_at?->format('d/m/Y') ?? '-' }}</td>
                            <td class="pe-4 text-end">
                                <div class="d-inline-flex gap-2">
                                    <a href="{{ route('admin.penilaian.mapel.edit', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id, 'id' => $item->id]) }}" class="btn-action-edit">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('admin.penilaian.mapel.destroy', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id, 'id' => $item->id]) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action-delete" onclick="return confirm('Yakin ingin menghapus nilai ini?')">
                                            <i class="bi bi-trash"></i> Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <i class="bi bi-clipboard-x fs-1 text-muted"></i>
                                <h6 class="mt-3 font-semibold text-dark">Belum ada penilaian</h6>
                                <p class="text-muted small mb-3">Belum ada data nilai untuk mata pelajaran ini.</p>
                                <a href="{{ route('admin.penilaian.mapel.create', ['kelasId' => $kelas->id, 'mapelId' => $mataPelajaran->id]) }}" class="btn-action-primary">
                                    <i class="bi bi-plus-lg"></i> Tambah Penilaian
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection