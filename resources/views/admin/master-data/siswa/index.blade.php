@extends('layouts.app')

@section('title', 'Master Siswa')
@section('content')
<div class="card">
    <h1>Master Siswa</h1>
    @if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('siswa.create') }}">Tambah Siswa</a></p>
    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th><th>NIS</th><th>NISN</th><th>Nama</th><th>JK</th>
                    <th>Tempat Lahir</th><th>Tanggal Lahir</th><th>Agama</th><th>NIK</th>
                    <th>No. KK</th><th>Alamat</th><th>No. HP</th><th>Email</th><th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($siswas as $siswa)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $siswa->nis }}</td>
                        <td>{{ $siswa->nisn ?? '-' }}</td>
                        <td>{{ $siswa->nama }}</td>
                        <td>{{ $siswa->jk }}</td>
                        <td>{{ $siswa->tempat_lahir }}</td>
                        <td>{{ optional($siswa->tgl_lahir)->format('d-m-Y') }}</td>
                        <td>{{ $siswa->agama }}</td>
                        <td>{{ $siswa->nik ?? '-' }}</td>
                        <td>{{ $siswa->no_kk ?? '-' }}</td>
                        <td>{{ $siswa->alamat }}</td>
                        <td>{{ $siswa->no_hp ?? '-' }}</td>
                        <td>{{ $siswa->email ?? '-' }}</td>
                        <td><a href="{{ route('siswa.edit', $siswa->id) }}">Edit</a>
                            <form action="{{ route('siswa.destroy', $siswa->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus data siswa?')">Hapus</button></form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="14">Belum ada data siswa.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
