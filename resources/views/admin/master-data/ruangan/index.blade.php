@extends('layouts.app')

@section('title', 'Master Ruangan')

@push('styles')
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            color: 
            background: 
        }

        .room-page {
            color: 
        }

        .room-panel {
            background: 
            border: 1px solid 
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .room-header {
            align-items: center;
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .room-title {
            color: 
            font-size: 24px;
            font-weight: 600;
            margin: 0;
        }

        .room-add {
            background: 
            border-radius: 8px;
            color: 
            font-size: 14px;
            font-weight: 600;
            padding: 10px 14px;
        }

        .room-add:hover {
            background: 
            color: 
            text-decoration: none;
        }

        .room-alert {
            background: 
            border: 1px solid 
            border-radius: 8px;
            color: 
            margin-bottom: 18px;
            padding: 11px 14px;
        }

        .room-table-wrapper {
            overflow-x: auto;
        }

        .room-table {
            min-width: 680px;
            width: 100%;
            border-collapse: collapse;
        }

        .room-table th,
        .room-table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid 
        }

        .room-table th {
            background: 
            color: 
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .room-table td {
            color: 
            font-size: 14px;
        }

        .room-table tbody tr:hover {
            background: 
        }

        .room-code {
            color: 
            font-weight: 600;
        }

        .room-status {
            background: 
            border-radius: 10px;
            color: 
            display: inline-block;
            font-size: 12px;
            font-weight: 600;
            padding: 5px 9px;
        }

        .room-status.is-inactive {
            background: 
            color: 
        }

        .room-action {
            display: flex;
            gap: 8px;
            white-space: nowrap;
        }

        .room-action a,
        .room-action button {
            border: 1px solid transparent;
            border-radius: 6px;
            cursor: pointer;
            font-size: 12px;
            padding: 7px 10px;
            text-decoration: none;
        }

        .room-edit {
            background: 
            border-color: 
            color: 
        }

        .room-delete {
            background: 
            border-color: 
            color: 
        }

        .room-edit:hover {
            background: 
            color: 
        }

        .room-delete:hover {
            background: 
            color: 
        }

        .room-pagination {
            display: flex;
            justify-content: center;
            margin-top: 20px;
        }

        .room-pagination nav {
            display: flex;
        }

        .room-pagination ul.pagination {
            align-items: center;
            display: flex;
            gap: 6px;
            margin: 0;
        }

        .room-pagination .page-item {
            margin: 0;
        }

        .room-pagination .page-link {
            align-items: center;
            background: 
            border: 1px solid 
            border-radius: 6px;
            color: 
            display: flex;
            font-size: 13px;
            height: 34px;
            justify-content: center;
            min-width: 34px;
            padding: 0 10px;
        }

        .room-pagination .page-link:hover {
            background: 
            border-color: 
            color: 
        }

        .room-pagination .page-item.active .page-link {
            background: 
            border-color: 
            color: 
        }

        .room-pagination .page-item.disabled .page-link {
            background: 
            border-color: 
            color: 
        }

        .room-empty {
            color: 
            padding: 28px !important;
            text-align: center !important;
        }

        @media (max-width: 768px) {
            .room-panel {
                padding: 18px;
            }

            .room-header {
                align-items: flex-start;
                flex-direction: column;
                gap: 14px;
            }
        }
    </style>

@endpush
@section('content')
    <div class="room-page">
        <div class="room-panel">
            <div class="room-header">
                <h1 class="room-title">Master Ruangan</h1>
                <a class="room-add text-decoration-none" href="{{ route('ruangan.create') }}"> Tambah Ruangan
                </a>
            </div>

            @if(session('success'))
                <div class="room-alert">{{ session('success') }}</div>
            @endif

            <div class="room-table-wrapper">
                <table class="room-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Kode Ruang</th>
                            <th>Nama Ruang</th>
                            <th>Kapasitas</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($ruangan as $item)
                            <tr>
                                <td>{{ $ruangan->firstItem() + $loop->index }}</td>
                                <td class="room-code">{{ $item->kode_ruang }}</td>
                                <td>{{ $item->nama_ruang }}</td>
                                <td>{{ $item->kapasitas }}</td>
                                <td><span
                                        class="room-status {{ $item->status ? '' : 'is-inactive' }}">{{ $item->status ? 'Aktif' : 'Tidak Aktif' }}</span>
                                </td>
                                <td>
                                    <div class="room-action">
                                        <a class="room-edit" href="{{ route('ruangan.edit', $item->id) }}">Edit</a>
                                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="room-delete" type="submit"
                                                onclick="return confirm('Hapus ruangan?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="room-empty">Belum ada data ruangan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="room-pagination">{{ $ruangan->links('pagination::bootstrap-5') }}</div>
        </div>
    </div>
@endsection