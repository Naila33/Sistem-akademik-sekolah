@extends('layouts.app')

@section('title', 'Edit Kelas')
@section('content')
<div class="card">
    <h1>Edit Kelas</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('kelas.update', $kelas->id) }}" method="POST">@csrf @method('PUT')
        <p><label>Tingkat<br><select name="tingkat" required>@foreach(['X','XI','XII'] as $tingkat)<option value="{{ $tingkat }}" @selected(old('tingkat', $kelas->tingkat) === $tingkat)>{{ $tingkat }}</option>@endforeach</select></label></p>
        <p><label>Jurusan<br><select name="jurusan_id" required>
                    <option value="">Pilih jurusan</option>@foreach($jurusans as $jurusan)<option value="{{ $jurusan->id }}" @selected(old('jurusan_id', $kelas->jurusan_id) == $jurusan->id)>{{ $jurusan->kode_jurusan }} - {{ $jurusan->nama_jurusan }}</option>@endforeach
                </select></label></p>
        <p><label>Nama Kelas<br><select name="nama_kelas" required>@foreach(['A','B','C','D','E','F','G','H'] as $namaKelas)<option value="{{ $namaKelas }}" @selected(old('nama_kelas', $kelas->nama_kelas) === $namaKelas)>{{ $namaKelas }}</option>@endforeach</select></label></p>
        <p><label>Wali Kelas<br><select name="wali_kelas_id">
                    <option value="">Pilih wali kelas</option>@foreach($gurus as $guru)<option value="{{ $guru->id }}" @selected(old('wali_kelas_id', $kelas->wali_kelas_id) == $guru->id)>{{ $guru->nama }}</option>@endforeach
                </select></label></p>
        <p><label>Tahun Ajaran<br><select name="tahun_ajaran_id">
                    <option value="">Pilih tahun ajaran</option>@foreach($tahunAjarans as $tahun)<option value="{{ $tahun->id }}" @selected(old('tahun_ajaran_id', $kelas->tahun_ajaran_id) == $tahun->id)>{{ $tahun->tahun_ajaran }} - {{ $tahun->semester }}</option>@endforeach
                </select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('kelas.index') }}">Kembali</a>
    </form>
</div>
@endsection