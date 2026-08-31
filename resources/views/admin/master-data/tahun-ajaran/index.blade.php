@extends('layouts.app')

@section('title', 'Master Tahun Ajaran')

@section('content')

<div class="card">
    <h1>Master Tahun Ajaran</h1>@if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('master-data.index') }}">Kembali ke Master Data</a> | <a href="{{ route('tahun-ajaran.create') }}">Tambah Tahun Ajaran</a></p>
    <table border="1" cellpadding="8" cellspacing="0">
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
            @forelse($tahunAjaran as $tahun)<tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tahun->tahun_ajaran }}</td>
                <td>{{ $tahun->semester }}</td>
                <td>{{ $tahun->status ? 'Aktif' : 'Tidak Aktif' }}</td>
                <td><a href="{{ route('tahun-ajaran.edit', $tahun->id) }}">Edit</a>
                    <form action="{{ route('tahun-ajaran.destroy', $tahun->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus tahun ajaran?')">Hapus</button></form>
                </td>
            </tr>@empty<tr>
                <td colspan="5">Belum ada data tahun ajaran.</td>
            </tr>@endforelse
        </tbody>
    </table>
</div>

@endsection