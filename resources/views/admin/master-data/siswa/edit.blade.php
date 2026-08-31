@extends('layouts.app')

@section('title', 'Edit Siswa')
@section('content')
<div class="card">
    <h1>Edit Siswa</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('siswa.update', $siswa->id) }}" method="POST">@csrf @method('PUT')
        <p><label>NIS<br><input name="nis" value="{{ old('nis', $siswa->nis) }}" required></label></p>
        <p><label>NISN<br><input name="nisn" value="{{ old('nisn', $siswa->nisn) }}"></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama', $siswa->nama) }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jk" required>@foreach(['Perempuan','Laki-laki'] as $jk)<option value="{{ $jk }}" @selected(old('jk', $siswa->jk) === $jk)>{{ $jk }}</option>@endforeach</select></label></p>
        <p><label>Tempat Lahir<br><input name="tempat_lahir" value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}" required></label></p>
        <p><label>Tanggal Lahir<br><input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', optional($siswa->tgl_lahir)->format('Y-m-d')) }}" required></label></p>
        <p><label>Agama<br><select name="agama" required>@foreach(['Islam','Kristen','Katolik','Budha','Hindu','Konghucu'] as $agama)<option value="{{ $agama }}" @selected(old('agama', $siswa->agama) === $agama)>{{ $agama }}</option>@endforeach</select></label></p>
        <p><label>NIK<br><input name="nik" value="{{ old('nik', $siswa->nik) }}"></label></p>
        <p><label>No. KK<br><input name="no_kk" value="{{ old('no_kk', $siswa->no_kk) }}"></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat', $siswa->alamat) }}</textarea></label></p>
        <p><label>No. HP<br><input name="no_hp" value="{{ old('no_hp', $siswa->no_hp) }}"></label></p>
        <p><label>Email<br><input type="email" name="email" value="{{ old('email', $siswa->email) }}"></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('siswa.index') }}">Kembali</a>
    </form>
</div>
@endsection
