@extends('layouts.app')

@section('title', 'Master Ruangan')
@section('content')
<div class="card">
    <h1>Master Ruangan</h1>
    @if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('ruangan.create') }}">Tambah Ruangan</a></p>
    <div class="table-wrapper">
        <table>
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
                @forelse($ruangan as $item)<tr>
                    <td>{{ $ruangan->firstItem() + $loop->index }}</td>
                    <td>{{ $item->kode_ruang }}</td>
                    <td>{{ $item->nama_ruang }}</td>
                    <td>{{ $item->kapasitas }}</td>
                    <td>{{ $item->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                    <td><a href="{{ route('ruangan.edit', $item->id) }}">Edit</a>
                        <form action="{{ route('ruangan.destroy', $item->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus ruangan?')">Hapus</button></form>
                    </td>
                </tr>@empty<tr>
                    <td colspan="6">Belum ada data ruangan.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>{{ $ruangan->links() }}
</div>
@endsection