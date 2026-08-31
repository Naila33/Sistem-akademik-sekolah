@extends('layouts.app')

@section('title', 'Tambah Mata Pelajaran')
@section('content')
<div class="card">
    <h1>Tambah Mata Pelajaran</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('mata_pelajaran.store') }}" method="POST">@csrf
        <p><label>Kode Mapel<br><input name="kode_mapel" value="{{ old('kode_mapel') }}" required></label></p>
        <p><label>Nama Mapel<br><input name="nama_mapel" value="{{ old('nama_mapel') }}" required></label></p>
        <p><label>Warna<br><input type="color" name="warna" value="{{ old('warna', '#d3d3d3') }}" required></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('mata_pelajaran.index') }}">Kembali</a>
    </form>
</div>
@endsection