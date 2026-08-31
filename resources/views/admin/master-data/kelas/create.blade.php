@extends('layouts.app')

@section('title', 'Tambah Kelas')
@section('content')
<div class="card">
    <h1>Tambah Kelas</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('kelas.store') }}" method="POST">@csrf
        <p><label>Tingkat<br><select name="tingkat" required>@foreach(['X','XI','XII'] as $tingkat)<option value="{{ $tingkat }}">{{ $tingkat }}</option>@endforeach</select></label></p>
        <p><label>Jurusan<br><select name="jurusan_id" required>
                    <option value="">Pilih jurusan</option>@foreach($jurusans as $jurusan)<option value="{{ $jurusan->id }}">{{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}</option>@endforeach
                </select></label></p>
        <p><label>Nama Kelas<br><select name="nama_kelas" required>@foreach(['A','B','C','D','E','F','G','H'] as $namaKelas)<option value="{{ $namaKelas }}">{{ $namaKelas }}</option>@endforeach</select></label></p>
        <p><label>Wali Kelas<br><select name="wali_kelas_id">
                    <option value="">Pilih wali kelas</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}">{{ $guru->nama }}</option>@endforeach
                </select></label></p>
        <p><label>Tahun Ajaran<br><select name="tahun_ajaran_id">
                    <option value="">Pilih tahun ajaran</option>@foreach($tahunAjarans as $tahun)<option value="{{ $tahun->id }}">{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}</option>@endforeach
                </select></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('kelas.index') }}">Kembali</a>
    </form>
</div>
@endsection