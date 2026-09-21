@extends('layouts.app')

@section('title', 'Izin Keluar Siswa')

@section('content')
<div class="page-header">
    <h1>Izin Keluar Siswa</h1>
    <p>Daftar izin keluar siswa dari kelas yang kamu ajar.</p>
</div>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<div class="card"><div class="table-wrapper"><table>
<thead><tr><th>No</th><th>Siswa</th><th>Tanggal</th><th>Jam</th><th>Alasan</th><th>Status Wali</th><th>Verifikasi</th></tr></thead>
<tbody>
@forelse($izinKeluar as $item)
@php($status = $item->status_wali_kelas ?? 'pending')
<tr>
<td>{{ $izinKeluar->firstItem() + $loop->index }}</td>
<td><strong>{{ $item->siswa->nama ?? '-' }}</strong><br><small>NIS: {{ $item->siswa->nis ?? '-' }}</small></td>
<td>{{ $item->tanggal?->format('d-m-Y') ?? '-' }}</td>
<td>{{ $item->jam_mulai ?? '-' }} - {{ $item->jam_selesai ?? '-' }}</td>
<td>{{ $item->alasan ?? '-' }}</td>
<td>{{ ucfirst($status) }}</td>
<td><form action="{{ route('wali-kelas.izin-keluar.verifikasi', $item->id) }}" method="POST">@csrf @method('PATCH')<input type="text" name="catatan_wali_kelas" class="form-control form-control-sm mb-2" placeholder="Catatan (opsional)" value="{{ $item->catatan_wali_kelas }}"><button name="status_wali_kelas" value="diterima" class="btn btn-sm btn-success">Terima</button> <button name="status_wali_kelas" value="ditolak" class="btn btn-sm btn-danger">Tolak</button></form></td>
</tr>
@empty<tr><td colspan="7" class="text-center">Belum ada izin keluar siswa.</td></tr>@endforelse
</tbody></table></div><div class="mt-3">{{ $izinKeluar->links() }}</div></div>
@endsection
