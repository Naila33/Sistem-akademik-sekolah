@extends('layouts.app')

@section('title', 'Master Kelas')
@section('content')
<div class="card">
    <h1>Master Kelas</h1>
    @if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('kelas.create') }}">Tambah Kelas</a></p>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tingkat</th>
                    <th>Jurusan</th>
                    <th>Nama Kelas</th>
                    <th>Wali Kelas</th>
                    <th>Tahun Ajaran</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($kelases as $kelas)<tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $kelas->tingkat }}</td>
                    <td>{{ optional($kelas->jurusan)->kode_jurusan ?? '-' }} - {{ optional($kelas->jurusan)->nama_jurusan ?? '-' }}</td>
                    <td>{{ $kelas->nama_kelas }}</td>
                    <td>{{ optional($kelas->waliKelas)->nama ?? '-' }}</td>
                    <td>{{ optional($kelas->tahunAjaran)->tahun_ajaran ?? '-' }}</td>
                    <td><a href="{{ route('kelas.edit', $kelas->id) }}">Edit</a>
                        <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus data kelas?')">Hapus</button></form>
                    </td>
                </tr>@empty<tr>
                    <td colspan="7">Belum ada data kelas.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection