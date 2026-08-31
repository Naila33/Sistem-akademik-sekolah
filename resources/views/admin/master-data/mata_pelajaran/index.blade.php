@extends('layouts.app')

@section('title', 'Master Mata Pelajaran')
@section('content')
<div class="card">
    <h1>Master Mata Pelajaran</h1>
    @if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('mata_pelajaran.create') }}">Tambah Mata Pelajaran</a></p>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Kode Mapel</th>
                    <th>Nama Mapel</th>
                    <th>Kode Warna</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mata_pelajaran as $mapel)<tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $mapel->kode_mapel }}</td>
                    <td>{{ $mapel->nama_mapel }}</td>
                    <td>
                        {{ $mapel->warna ?? '#d3d3d3' }}
                    </td>
                    <td><a href="{{ route('mata_pelajaran.edit', $mapel->id) }}">Edit</a>
                        <form action="{{ route('mata_pelajaran.destroy', $mapel->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus mata pelajaran?')">Hapus</button></form>
                    </td>
                </tr>@empty<tr>
                    <td colspan="5">Belum ada data mata pelajaran.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>{{ $mata_pelajaran->links() }}
</div>
@endsection