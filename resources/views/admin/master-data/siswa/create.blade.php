@extends('layouts.app')

@section('title', 'Tambah Siswa')
@section('content')
<div class="card">
    <h1>Tambah Siswa</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('siswa.store') }}" method="POST">@csrf
        <p><label>NIS<br><input name="nis" value="{{ old('nis') }}" required></label></p>
        <p><label>NISN<br><input name="nisn" value="{{ old('nisn') }}"></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama') }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jk" required><option value="">Pilih</option><option value="Perempuan">Perempuan</option><option value="Laki-laki">Laki-laki</option></select></label></p>
        <p><label>Tempat Lahir<br><input name="tempat_lahir" value="{{ old('tempat_lahir') }}" required></label></p>
        <p><label>Tanggal Lahir<br><input type="date" name="tgl_lahir" value="{{ old('tgl_lahir') }}" required></label></p>
        <p><label>Agama<br><select name="agama" required><option value="">Pilih</option>@foreach(['Islam','Kristen','Katolik','Budha','Hindu','Konghucu'] as $agama)<option value="{{ $agama }}">{{ $agama }}</option>@endforeach</select></label></p>
        <p><label>NIK<br><input name="nik" value="{{ old('nik') }}"></label></p>
        <p><label>No. KK<br><input name="no_kk" value="{{ old('no_kk') }}"></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat') }}</textarea></label></p>
        <p><label>No. HP<br><input name="no_hp" value="{{ old('no_hp') }}"></label></p>
        <p><label>Email<br><input type="email" name="email" value="{{ old('email') }}"></label></p>
        <button type="submit">Simpan</button> <a href="{{ route('siswa.index') }}">Kembali</a>
    </form>
</div>
@endsection
