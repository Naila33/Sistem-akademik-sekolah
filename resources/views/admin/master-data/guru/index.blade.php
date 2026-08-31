@extends('layouts.app')

@section('title', 'Master Guru')
@section('content')
<div class="card">
    <h1>Master Guru</h1>
    @if(session('success'))<p>{{ session('success') }}</p>@endif
    <p><a href="{{ route('guru.create') }}">Tambah Guru</a></p>
    <div class="table-wrapper"><table>
        <thead><tr><th>No</th><th>NIP</th><th>Nama</th><th>Jenis Kelamin</th><th>Tanggal Lahir</th><th>Agama</th><th>Alamat</th><th>No. HP</th><th>Email</th><th>Status Kepegawaian</th><th>Jabatan</th><th>TMT</th><th>Mata Pelajaran</th><th>Aksi</th></tr></thead>
        <tbody>
        @forelse($gurus as $guru)<tr>
            <td>{{ $loop->iteration }}</td><td>{{ $guru->nip }}</td><td>{{ $guru->nama }}</td><td>{{ $guru->jk }}</td><td>{{ optional($guru->tgl_lahir)->format('d-m-Y') }}</td><td>{{ $guru->agama }}</td><td>{{ $guru->alamat }}</td><td>{{ $guru->no_hp }}</td><td>{{ $guru->email }}</td><td>{{ str_replace('_',' ',$guru->status_kepegawaian) }}</td><td>{{ str_replace('_',' ',$guru->jabatan) }}</td><td>{{ optional($guru->tmt)->format('d-m-Y') }}</td><td>{{ optional($guru->mataPelajaran)->nama_mapel ?? '-' }}</td>
            <td><a href="{{ route('guru.edit', $guru->id) }}">Edit</a><form action="{{ route('guru.destroy', $guru->id) }}" method="POST">@csrf @method('DELETE')<button type="submit" onclick="return confirm('Hapus data guru?')">Hapus</button></form></td>
        </tr>@empty<tr><td colspan="14">Belum ada data guru.</td></tr>@endforelse
        </tbody>
    </table></div>
</div>
@endsection
