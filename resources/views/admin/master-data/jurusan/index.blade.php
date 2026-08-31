@extends('layouts.app')

@section('title', 'Master Jurusan')

@section('content')

<div class="card">
    <h1>Master Jurusan</h1>
    <p>Kelola data jurusan sekolah.</p>

    @if (session('success'))
    <p>{{ session('success') }}</p>
    @endif

    <p><a href="{{ route('jurusan.create') }}">Tambah Jurusan</a></p>

    <table border="1" cellpadding="8" cellspacing="0">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode Jurusan</th>
                <th>Nama Jurusan</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jurusans as $jurusan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $jurusan->kode_jurusan }}</td>
                <td>{{ $jurusan->nama_jurusan }}</td>
                <td>
                    <a href="{{ route('jurusan.edit', $jurusan->id) }}">Edit</a>
                    <form action="{{ route('jurusan.destroy', $jurusan->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" onclick="return confirm('Yakin ingin menghapus jurusan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4">Belum ada data jurusan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection