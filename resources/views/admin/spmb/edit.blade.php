@extends('layouts.app')

@section('title', 'Edit Calon Siswa')

@section('content')

    <div class="container-fluid py-4">

        {{-- HEADER --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h4 class="fw-bold mb-1">
                    Edit Calon Siswa
                </h4>

                <p class="text-muted mb-0">
                    {{ $calonSiswa->no_pendaftaran }}
                </p>
            </div>

            <div class="d-flex gap-2">

                <a href="{{ route('admin.spmb.show', $calonSiswa->id) }}" class="btn btn-secondary">
                    Kembali
                </a>

            </div>

        </div>


        {{-- ALERT ERROR --}}
        @if($errors->any())

            <div class="alert alert-danger alert-dismissible fade show">

                <strong>
                    Terjadi kesalahan!
                </strong>

                <ul class="mb-0 mt-2">

                    @foreach($errors->all() as $error)

                        <li>
                            {{ $error }}
                        </li>

                    @endforeach

                </ul>

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>

            </div>

        @endif


        {{-- FORM --}}
        <form action="{{ route('admin.spmb.update', $calonSiswa->id) }}" method="POST">

            @csrf
            @method('PUT')


            {{-- ================= DATA PRIBADI ================= --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-semibold">
                        Data Pribadi
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">


                        {{-- NO PENDAFTARAN --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                No. Pendaftaran
                            </label>

                            <input type="text" name="no_pendaftaran" class="form-control" value="{{ old(
        'no_pendaftaran',
        $calonSiswa->no_pendaftaran
    ) }}" readonly>

                            <small class="text-muted">
                                Nomor pendaftaran tidak dapat diubah.
                            </small>

                        </div>


                        {{-- NAMA LENGKAP --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Nama Lengkap
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nama_lengkap" class="form-control" value="{{ old(
        'nama_lengkap',
        $calonSiswa->nama_lengkap
    ) }}" required>

                        </div>


                        {{-- NIK --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                NIK
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nik" class="form-control" value="{{ old(
        'nik',
        $calonSiswa->nik
    ) }}" required>

                        </div>


                        {{-- NISN --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                NISN
                            </label>

                            <input type="text" name="nisn" class="form-control" value="{{ old(
        'nisn',
        $calonSiswa->nisn
    ) }}">

                        </div>


                        {{-- JENIS KELAMIN --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                Jenis Kelamin
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jenis_kelamin" class="form-select" required>

                                <option value="">
                                    -- Pilih Jenis Kelamin --
                                </option>

                                <option value="laki-laki" @selected(
                                    old(
                                        'jenis_kelamin',
                                        $calonSiswa->jenis_kelamin
                                    ) === 'laki-laki'
                                )>
                                    Laki-laki
                                </option>

                                <option value="perempuan" @selected(
                                    old(
                                        'jenis_kelamin',
                                        $calonSiswa->jenis_kelamin
                                    ) === 'perempuan'
                                )>
                                    Perempuan
                                </option>

                            </select>

                        </div>


                        {{-- TEMPAT LAHIR --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Tempat Lahir
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="tempat_lahir" class="form-control" value="{{ old(
        'tempat_lahir',
        $calonSiswa->tempat_lahir
    ) }}" required>

                        </div>


                        {{-- TANGGAL LAHIR --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Tanggal Lahir
                                <span class="text-danger">*</span>
                            </label>

                            <input type="date" name="tanggal_lahir" class="form-control" value="{{ old(
        'tanggal_lahir',
        $calonSiswa->tanggal_lahir
        ? $calonSiswa->tanggal_lahir->format('Y-m-d')
        : ''
    ) }}" required>

                        </div>


                        {{-- ASAL SEKOLAH --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Asal Sekolah
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="asal_sekolah" class="form-control" value="{{ old(
        'asal_sekolah',
        $calonSiswa->asal_sekolah
    ) }}" required>

                        </div>


                        {{-- NO KK --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                No. KK
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="no_kk" class="form-control" value="{{ old(
        'no_kk',
        $calonSiswa->no_kk
    ) }}" required>

                        </div>


                        {{-- ALAMAT --}}

                        <div class="col-12">

                            <label class="form-label">
                                Alamat
                                <span class="text-danger">*</span>
                            </label>

                            <textarea name="alamat" class="form-control" rows="3" required>{{ old(
        'alamat',
        $calonSiswa->alamat
    ) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= DATA ORANG TUA ================= --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-semibold">
                        Data Orang Tua / Wali
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">


                        {{-- AYAH --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                Nama Ayah
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nama_ayah" class="form-control" value="{{ old(
        'nama_ayah',
        $calonSiswa->nama_ayah
    ) }}" required>

                        </div>


                        {{-- IBU --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                Nama Ibu
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="nama_ibu" class="form-control" value="{{ old(
        'nama_ibu',
        $calonSiswa->nama_ibu
    ) }}" required>

                        </div>


                        {{-- HP ORANG TUA --}}

                        <div class="col-md-4">

                            <label class="form-label">
                                No. HP Orang Tua
                                <span class="text-danger">*</span>
                            </label>

                            <input type="text" name="no_hp_ortu" class="form-control" value="{{ old(
        'no_hp_ortu',
        $calonSiswa->no_hp_ortu
    ) }}" required>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= DATA SPMB ================= --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-semibold">
                        Data SPMB
                    </h5>

                </div>

                <div class="card-body">

                    <div class="row g-3">


                        {{-- JURUSAN --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Jurusan
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jurusan_id" class="form-select" required>

                                <option value="">
                                    -- Pilih Jurusan --
                                </option>

                                @foreach($jurusan as $item)

                                    <option value="{{ $item->id }}" @selected(
                                        old(
                                            'jurusan_id',
                                            $calonSiswa->jurusan_id
                                        ) == $item->id
                                    )>
                                        {{ $item->nama_jurusan }}
                                        ({{ $item->kode_jurusan }})
                                    </option>

                                @endforeach

                            </select>

                        </div>


                        {{-- JALUR --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Jalur Pendaftaran
                                <span class="text-danger">*</span>
                            </label>

                            <select name="jalur_pendaftaran" class="form-select" required>

                                <option value="">
                                    -- Pilih Jalur --
                                </option>

                                <option value="domisili" @selected(
                                    old(
                                        'jalur_pendaftaran',
                                        $calonSiswa->jalur_pendaftaran
                                    ) === 'domisili'
                                )>
                                    Domisili
                                </option>

                                <option value="afirmasi" @selected(
                                    old(
                                        'jalur_pendaftaran',
                                        $calonSiswa->jalur_pendaftaran
                                    ) === 'afirmasi'
                                )>
                                    Afirmasi
                                </option>

                                <option value="prestasi" @selected(
                                    old(
                                        'jalur_pendaftaran',
                                        $calonSiswa->jalur_pendaftaran
                                    ) === 'prestasi'
                                )>
                                    Prestasi
                                </option>

                                <option value="mutasi" @selected(
                                    old(
                                        'jalur_pendaftaran',
                                        $calonSiswa->jalur_pendaftaran
                                    ) === 'mutasi'
                                )>
                                    Mutasi
                                </option>

                            </select>

                        </div>


                        {{-- STATUS PENERIMAAN --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Status Penerimaan
                                <span class="text-danger">*</span>
                            </label>

                            <select name="status_penerimaan" class="form-select" required>

                                <option value="diterima" @selected(
                                    old(
                                        'status_penerimaan',
                                        $calonSiswa->status_penerimaan
                                    ) === 'diterima'
                                )>
                                    Diterima
                                </option>

                                <option value="tidak_diterima" @selected(
                                    old(
                                        'status_penerimaan',
                                        $calonSiswa->status_penerimaan
                                    ) === 'tidak_diterima'
                                )>
                                    Tidak Diterima
                                </option>

                            </select>

                        </div>


                        {{-- STATUS DAFTAR ULANG --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Status Daftar Ulang
                                <span class="text-danger">*</span>
                            </label>

                            <select name="status_daftar_ulang" class="form-select" required>

                                <option value="belum_daftar_ulang" @selected(
                                    old(
                                        'status_daftar_ulang',
                                        $calonSiswa->status_daftar_ulang
                                    ) === 'belum_daftar_ulang'
                                )>
                                    Belum Daftar Ulang
                                </option>

                                <option value="menunggu_verifikasi" @selected(
                                    old(
                                        'status_daftar_ulang',
                                        $calonSiswa->status_daftar_ulang
                                    ) === 'menunggu_verifikasi'
                                )>
                                    Menunggu Verifikasi
                                </option>

                                <option value="revisi" @selected(
                                    old(
                                        'status_daftar_ulang',
                                        $calonSiswa->status_daftar_ulang
                                    ) === 'revisi'
                                )>
                                    Revisi
                                </option>

                                <option value="terverifikasi" @selected(
                                    old(
                                        'status_daftar_ulang',
                                        $calonSiswa->status_daftar_ulang
                                    ) === 'terverifikasi'
                                )>
                                    Terverifikasi
                                </option>

                            </select>

                        </div>


                        {{-- TANGGAL DAFTAR ULANG --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Tanggal Daftar Ulang
                            </label>

                            <input type="datetime-local" name="tanggal_daftar_ulang" class="form-control" value="{{ old(
        'tanggal_daftar_ulang',
        $calonSiswa->tanggal_daftar_ulang
        ? $calonSiswa->tanggal_daftar_ulang->format('Y-m-d\TH:i')
        : ''
    ) }}">

                        </div>


                        {{-- CATATAN REVISI --}}

                        <div class="col-md-6">

                            <label class="form-label">
                                Catatan Revisi
                            </label>

                            <textarea name="catatan_revisi" class="form-control" rows="3"
                                placeholder="Masukkan catatan revisi jika diperlukan">{{ old(
        'catatan_revisi',
        $calonSiswa->catatan_revisi
    ) }}</textarea>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= INFORMASI DOKUMEN ================= --}}

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0 fw-semibold">
                        Dokumen Daftar Ulang
                    </h5>

                </div>

                <div class="card-body">

                    <div class="alert alert-info mb-0">

                        <div class="d-flex">

                            <div class="me-3">
                                <i class="fas fa-info-circle"></i>
                            </div>

                            <div>

                                <strong>
                                    Informasi
                                </strong>

                                <div>
                                    Dokumen daftar ulang tidak diubah
                                    melalui halaman ini.
                                </div>

                                <div class="mt-1">
                                    Proses upload dan verifikasi dokumen
                                    dilakukan melalui halaman detail calon siswa.
                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>


            {{-- ================= BUTTON ================= --}}

            <div class="card shadow-sm border-0 mb-5">

                <div class="card-body">

                    <div class="d-flex justify-content-end gap-2">

                        <a href="{{ route('admin.spmb.show', $calonSiswa->id) }}" class="btn btn-secondary">
                            Batal
                        </a>

                        <button type="submit" class="btn btn-primary px-4">
                            Simpan Perubahan
                        </button>

                    </div>

                </div>

            </div>

        </form>

    </div>

@endsection