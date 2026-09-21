@extends('layouts.app')

@section('title', 'Master Tahun Ajaran')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: 
            background: 
        }

        .academic-page {
            color: 
        }

        .academic-panel {
            background: 
            border: 1px solid 
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .academic-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .academic-title {
            color: 
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .academic-add {
            background: 
            border-radius: 8px;
            color: 
            font-size: 14px;
            font-weight: 600;
            padding: 10px 14px;
        }

        .academic-add:hover {
            background: 
            color: 
            text-decoration: none;
        }

        .academic-alert {
            background: 
            border: 1px solid 
            border-radius: 8px;
            color: 
            margin-bottom: 18px;
            padding: 11px 14px;
        }

        .academic-table-wrapper {
            overflow-x: auto;
        }

        .academic-table {
            min-width: 680px;
            width: 100%;
            border-collapse: collapse;
        }

        .academic-table th,
        .academic-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid 
        }

        .academic-table th {
            background: 
            color: 
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .academic-table td {
            color: 
            font-size: 14px;
        }

        .academic-table tbody tr:hover {
            background: 
        }

        .academic-code {
            color: 
            font-weight: 600;
        }

        .academic-status {
            background: 
            border-radius: 10px;
            color: 
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 9px;
        }

        .academic-status.is-inactive {
            background: 
            color: 
        }

        .academic-action {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .academic-action a,
        .academic-action button {
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            padding: 7px 10px;
            text-decoration: none;
        }

        .academic-edit {
            background: 
            border-color: 
            color: 
        }

        .academic-delete {
            background: 
            border-color: 
            color: 
        }

        .academic-edit:hover {
            background: 
            color: 
        }

        .academic-delete:hover {
            background: 
            color: 
        }

        .academic-empty {
            color: 
            padding: 28px !important;
            text-align: center !important;
        }

        @media (max-width: 768px) {
            .academic-panel {
                padding: 18px;
            }

            .academic-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>

@endpush

@section('content')

    <div class="academic-page">
        <div class="academic-panel">
            <div class="academic-header">
                <h1 class="academic-title">Master Tahun Ajaran</h1>
                <a class="academic-add text-decoration-none" href="{{ route('tahun-ajaran.create') }}"> Tambah Tahun Ajaran
                </a>
            </div>

            @if(session('success'))
                <div class="academic-alert">{{ session('success') }}</div>
            @endif

            <div class="academic-table-wrapper">
                <table class="academic-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tahun Ajaran</th>
                            <th>Semester</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tahunAjaran as $tahun)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="academic-code">{{ $tahun->tahun_ajaran }}</td>
                                <td>{{ $tahun->semester }}</td>
                                <td><span
                                        class="academic-status {{ $tahun->status ? '' : 'is-inactive' }}">{{ $tahun->status ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td>
                                    <div class="academic-action">
                                        <a class="academic-edit" href="{{ route('tahun-ajaran.edit', $tahun->id) }}">Edit</a>
                                        <form action="{{ route('tahun-ajaran.destroy', $tahun->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="academic-delete" type="submit"
                                                onclick="return confirm('Hapus tahun ajaran?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="academic-empty">Belum ada data tahun ajaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection