@extends('layouts.app')

@section('title', 'Mata Pelajaran ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: #212529;
            background: #f5f6fa;
        }
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

       
        .filter-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .filter-field label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .filter-field input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .filter-field input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

     
        .btn-action-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .btn-action-secondary {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 16px;
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
            background: #f1f5f9;
            color: #1e293b;
        }

        
        .item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease-in-out;
            height: 100%;
        }

        .item-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.08);
            transform: translateY(-2px);
        }

        .item-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background-color: rgba(37, 99, 235, 0.1);
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .item-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }

        .item-subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 13px;
            color: #64748b;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
            margin-top: 12px;
        }

        .badge-academic {
            background-color: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
            padding: 3px 8px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 500;
            display: inline-block;
        }
    </style>
@endpush

@section('content')
<div class="academic-container">
    <div class="academic-card">

        
        <a href="{{ route('admin.penilaian.mapel.index') }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i> Kembali ke Kelas
        </a>

       
        <div class="academic-header">
            <h1>Mata Pelajaran {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}</h1>
            <p>{{ $kelas->jurusan?->nama_jurusan ?? 'Umum' }} — Pilih mata pelajaran untuk mengelola penilaian</p>
        </div>
        <div class="filter-section">
            <form method="GET" action="{{ route('admin.penilaian.mapel.kelas', $kelas->id) }}" class="filter-field">
                <label for="searchMapel">Cari Mata Pelajaran</label>
                <div class="d-flex gap-2">
                    <input type="text" name="search" id="searchMapel" value="{{ request('search') }}" placeholder="Cari nama atau kode mata pelajaran..." autocomplete="off">
                    <button type="submit" class="btn-action-primary">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    @if(request('search'))
                        <a href="{{ route('admin.penilaian.mapel.kelas', $kelas->id) }}" class="btn-action-secondary">
                            <i class="bi bi-arrow-counterclockwise"></i> Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>

        <div class="row g-3">
            @forelse($mataPelajaran as $mapel)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <a href="{{ route('admin.penilaian.mapel.mapel', ['kelasId' => $kelas->id, 'mapelId' => $mapel->id]) }}" class="item-card">
                        
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <div class="item-subtitle mb-1">Mata Pelajaran</div>
                                <div class="item-title">{{ $mapel->nama_mapel }}</div>
                            </div>
                            <div class="item-icon flex-shrink-0">
                                <i class="bi bi-book"></i>
                            </div>
                        </div>

                        <div class="mb-3">
                            <span class="badge-academic">
                                {{ $mapel->kode_mapel ?? '-' }}
                            </span>
                        </div>

                        <div class="item-footer">
                            <span>
                                Data Penilaian: <strong class="text-dark">{{ $mapel->jumlah_penilaian ?? 0 }}</strong>
                            </span>
                            <span class="fw-semibold text-primary">
                                Lihat <i class="bi bi-arrow-right ms-1"></i>
                            </span>
                        </div>

                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 border rounded bg-light">
                        <i class="bi bi-book fs-1 text-muted"></i>
                        <h5 class="mt-3 text-dark">Belum ada mata pelajaran</h5>
                        <p class="text-muted mb-0">Belum ada jadwal mata pelajaran untuk kelas ini.</p>
                    </div>
                </div>
            @endforelse
        </div>

    </div>
</div>
@endsection