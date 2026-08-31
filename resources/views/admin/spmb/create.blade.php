@extends('layouts.app')

@section('title', 'Tambah Calon Siswa')

@section('content')

    <div class="container-fluid py-4">

        <div class="mb-4">

            <h4 class="fw-bold">
                Tambah Calon Siswa
            </h4>

            <p class="text-muted">
                Masukkan data calon siswa dan dokumen daftar ulang.
            </p>

        </div>


        @if($errors->any())

            <div class="alert alert-danger">

                <strong>
                    Terdapat kesalahan:
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>{{ $error }}</li>

                    @endforeach

                </ul>

            </div>

        @endif


        <form action="{{ route('admin.spmb.store') }}" method="POST" enctype="multipart/form-data">

            @csrf


            {{-- DATA PRIBADI --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Data Pribadi
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nama Lengkap *
                            </label>

                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old('nama_lengkap') }}"
                                required>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                NIK *
                            </label>

                            <input type="text" name="nik" maxlength="16" class="form-control" value="{{ old('nik') }}"
                                required>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                NISN
                            </label>

                            <input type="text" name="nisn" maxlength="10" class="form-control" value="{{ old('nisn') }}">

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Jenis Kelamin *
                            </label>

                            <select name="jenis_kelamin" class="form-select" required>

                                <option value="">
                                    Pilih
                                </option>

                                <option value="laki-laki" @selected(old('jenis_kelamin') === 'laki-laki')}>
                                    Laki-laki
                                </option>

                                <option value="perempuan" @selected(old('jenis_kelamin') === 'perempuan')}>
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Tempat Lahir *
                            </label>

                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}"
                                required>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Tanggal Lahir *
                            </label>

                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}"
                                required>

                        </div>


                        <div class="col-12">

                            <label class="form-label">
                                Alamat *
                            </label>

                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat') }}</textarea>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                Asal Sekolah *
                            </label>

                            <input type="text" name="asal_sekolah" class="form-control" value="{{ old('asal_sekolah') }}"
                                required>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Tahun Lulus
                            </label>

                            <input type="number" name="tahun_lulus" class="form-control" value="{{ old('tahun_lulus') }}">

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                No. KK *
                            </label>

                            <input type="text" name="no_kk" maxlength="16" class="form-control" value="{{ old('no_kk') }}"
                                required>

                        </div>

                    </div>

                </div>

            </div>


            {{-- DATA SPMB --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Data SPMB
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Jurusan *
                            </label>

                            <select name="jurusan_id" class="form-select" required>

                                <option value="">
                                    Pilih Jurusan
                                </option>

                                @foreach($jurusan as $item)

                                    <option value="{{ $item->id }}" @selected(old('jurusan_id') == $item->id)>

                                        {{ $item->kode_jurusan }}
                                        -
                                        {{ $item->nama_jurusan }}

                                    </option>

                                @endforeach

                            </select>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Jalur Pendaftaran *
                            </label>

                            <select name="jalur_pendaftaran" class="form-select" required>

                                <option value="">
                                    Pilih Jalur
                                </option>

                                <option value="Domisili">
                                    Domisili
                                </option>

                                <option value="Prestasi">
                                    Prestasi
                                </option>

                                <option value="Afirmasi">
                                    Afirmasi
                                </option>

                                <option value="Mutasi">
                                    Mutasi
                                </option>

                            </select>

                        </div>


                        <div class="col-md-3">

                            <label class="form-label">
                                Status Penerimaan *
                            </label>

                            <select name="status_penerimaan" class="form-select" required>

                                <option value="diterima">
                                    Diterima
                                </option>

                                <option value="tidak_diterima">
                                    Tidak Diterima
                                </option>

                            </select>

                        </div>

                    </div>

                </div>

            </div>


            {{-- DATA ORANG TUA --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Data Orang Tua
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        <div class="col-md-4">

                            <label class="form-label">
                                Nama Ayah *
                            </label>

                            <input type="text" name="nama_ayah" class="form-control" value="{{ old('nama_ayah') }}"
                                required>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                Nama Ibu *
                            </label>

                            <input type="text" name="nama_ibu" class="form-control" value="{{ old('nama_ibu') }}" required>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label">
                                No. HP Orang Tua *
                            </label>

                            <input type="text" name="no_hp_ortu" class="form-control" value="{{ old('no_hp_ortu') }}"
                                required>

                        </div>

                    </div>

                </div>

            </div>


            {{-- DOKUMEN --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Dokumen Daftar Ulang
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">

                        @php

                            $dokumen = [
                                'skl_ijazah' => 'SKL / Ijazah',
                                'rapor' => 'Rapor',
                                'kk' => 'Kartu Keluarga',
                                'akta_kelahiran' => 'Akta Kelahiran',
                                'surat_kesehatan' => 'Surat Kesehatan',
                                'surat_pernyataan_orang_tua' => 'Surat Pernyataan Orang Tua',
                                'bukti_penerimaan' => 'Bukti Penerimaan Tahap',
                            ];

                        @endphp


                        @foreach($dokumen as $key => $label)

                            <div class="col-md-6">

                                <label class="form-label">
                                    {{ $label }}
                                </label>

                                <input type="file" name="dokumen[{{ $key }}]" class="form-control"
                                    accept=".pdf,.jpg,.jpeg,.png">

                                <small class="text-muted">
                                    PDF/JPG/PNG, maksimal 2 MB.
                                </small>

                            </div>

                        @endforeach

                    </div>

                </div>

            </div>


            {{-- BUTTON --}}

            <div class="d-flex justify-content-end gap-2">

                <a href="{{ route('admin.spmb.index') }}" class="btn btn-secondary">
                    Batal
                </a>

                <button class="btn btn-primary">
                    Simpan Calon Siswa
                </button>

            </div>

        </form>

    </div>

@endsection