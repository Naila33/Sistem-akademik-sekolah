@extends('layouts.app')

@section('title', 'Atur Batas Waktu Penilaian')

@push('styles')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
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

        /* Buttons */
        .btn-action-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
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
            background: #f1f5f9;
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
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn-back-link">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>

        <div class="academic-card">
            <div class="academic-header">
                <h1>Atur Batas Waktu Penilaian</h1>
                <p>Tentukan kapan semua guru dapat memasukkan nilai PJBL.</p>
            </div>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('admin.penilaian.pjbl.waktu.update') }}" method="POST">
                @csrf
                @method('PUT')

                @include('admin.penilaian.pjbl.waktu-create')

                <div class="d-flex gap-2 justify-content-end pt-3 border-top mt-4">
                    <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn-action-secondary">
                        <i class="bi bi-x-lg"></i> Batal
                    </a>
                    <button type="submit" class="btn-action-primary">
                        <i class="bi bi-clock me-1"></i> Simpan Waktu
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection