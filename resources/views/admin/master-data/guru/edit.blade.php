@extends('layouts.app')

@section('title', 'Edit Guru')
@section('content')
<div class="card">
    <h1>Edit Guru</h1>
    @include('admin.master-data.partials.errors')
    <form action="{{ route('guru.update', $guru->id) }}" method="POST">@csrf @method('PUT')
        <p><label>NIP<br><input name="nip" value="{{ old('nip', $guru->nip) }}" required></label></p>
        <p><label>Nama<br><input name="nama" value="{{ old('nama', $guru->nama) }}" required></label></p>
        <p><label>Jenis Kelamin<br><select name="jk" required>@foreach(['Laki-laki','Perempuan'] as $jk)<option value="{{ $jk }}" @selected(old('jk', $guru->jk) === $jk)>{{ $jk }}</option>@endforeach</select></label></p>
        <p><label>Tanggal Lahir<br><input type="date" name="tgl_lahir" value="{{ old('tgl_lahir', optional($guru->tgl_lahir)->format('Y-m-d')) }}" required></label></p>
        <p><label>Agama<br><select name="agama" required>@foreach(['Islam','Kristen','Katolik','Hindu','Budha','Konghucu'] as $agama)<option value="{{ $agama }}" @selected(old('agama', $guru->agama) === $agama)>{{ $agama }}</option>@endforeach</select></label></p>
        <p><label>Alamat<br><textarea name="alamat" required>{{ old('alamat', $guru->alamat) }}</textarea></label></p>
        <p><label>No. HP<br><input name="no_hp" value="{{ old('no_hp', $guru->no_hp) }}" required></label></p>
        <p><label>Email<br><input type="email" name="email" value="{{ old('email', $guru->email) }}" required></label></p>
        <p><label>Status Kepegawaian<br><select name="status_kepegawaian" required>@foreach(['PNS','PPPK','Honorer','Guru_tetap','Guru_tidak_tetap'] as $status)<option value="{{ $status }}" @selected(old('status_kepegawaian', $guru->status_kepegawaian) === $status)>{{ str_replace('_',' ',$status) }}</option>@endforeach</select></label></p>
        <p><label>Jabatan<br><select name="jabatan" required>@foreach(['Guru','Kepala_sekolah','Waka_sekolah'] as $jabatan)<option value="{{ $jabatan }}" @selected(old('jabatan', $guru->jabatan) === $jabatan)>{{ str_replace('_',' ',$jabatan) }}</option>@endforeach</select></label></p>
        <p><label>TMT<br><input type="date" name="tmt" value="{{ old('tmt', optional($guru->tmt)->format('Y-m-d')) }}" required></label></p>
        <p><label>Mata Pelajaran<br><select name="mata_pelajaran_id" required>@foreach($mataPelajaran as $mapel)<option value="{{ $mapel->id }}" @selected(old('mata_pelajaran_id', $guru->mata_pelajaran_id) == $mapel->id)>{{ $mapel->nama_mapel }}</option>@endforeach</select></label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('guru.index') }}">Kembali</a>
    </form>
</div>
@endsection