@extends('layouts.app')

@section('title', 'Detail Calon Siswa')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h4 class="fw-bold mb-1">
                Detail Calon Siswa
            </h4>

            <p class="text-muted mb-0">
                {{ $calonSiswa->no_pendaftaran }}
            </p>

        </div>

        <div class="d-flex gap-2">

            <a
                href="{{ route('admin.spmb.edit', $calonSiswa->id) }}"
                class="btn btn-warning"
            >
                Edit
            </a>

            <a
                href="{{ route('admin.spmb.index') }}"
                class="btn btn-secondary"
            >
                Kembali
            </a>

        </div>

    </div>


    {{-- ALERT --}}

    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    @if(session('error'))

        <div class="alert alert-danger alert-dismissible fade show">

            {{ session('error') }}

            <button
                type="button"
                class="btn-close"
                data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- DATA UTAMA --}}

    <div class="row g-4">

        <div class="col-lg-8">

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

                            <small class="text-muted">
                                Nama Lengkap
                            </small>

                            <div class="fw-semibold">
                                {{ $calonSiswa->nama_lengkap }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                No. Pendaftaran
                            </small>

                            <div class="fw-semibold">
                                {{ $calonSiswa->no_pendaftaran }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                NIK
                            </small>

                            <div>
                                {{ $calonSiswa->nik }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                NISN
                            </small>

                            <div>
                                {{ $calonSiswa->nisn ?? '-' }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Jenis Kelamin
                            </small>

                            <div>
                                {{ $calonSiswa->jenis_kelamin === 'L'
                                    ? 'Laki-laki'
                                    : 'Perempuan' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Tempat, Tanggal Lahir
                            </small>

                            <div>
                                {{ $calonSiswa->tempat_lahir }},
                                {{ $calonSiswa->tanggal_lahir
                                    ? $calonSiswa->tanggal_lahir->format('d-m-Y')
                                    : '-' }}
                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Asal Sekolah
                            </small>

                            <div>
                                {{ $calonSiswa->asal_sekolah }}
                            </div>

                        </div>


                        <div class="col-12">

                            <small class="text-muted">
                                Alamat
                            </small>

                            <div>
                                {{ $calonSiswa->alamat }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                No. KK
                            </small>

                            <div>
                                {{ $calonSiswa->no_kk }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Ayah
                            </small>

                            <div>
                                {{ $calonSiswa->nama_ayah }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                Ibu
                            </small>

                            <div>
                                {{ $calonSiswa->nama_ibu }}
                            </div>

                        </div>


                        <div class="col-md-4">

                            <small class="text-muted">
                                No. HP Orang Tua
                            </small>

                            <div>
                                {{ $calonSiswa->no_hp_ortu }}
                            </div>

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

                            <small class="text-muted">
                                Jurusan
                            </small>

                            <div class="fw-semibold">

                                @if($calonSiswa->jurusan)

                                    {{ $calonSiswa->jurusan->nama_jurusan }}

                                    <span class="badge text-bg-primary">
                                        {{ $calonSiswa->jurusan->kode_jurusan }}
                                    </span>

                                @else

                                    <span class="text-muted">
                                        Jurusan tidak tersedia
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="col-md-3">

                            <small class="text-muted">
                                Jalur
                            </small>

                            <div>
                                {{ $calonSiswa->jalur_pendaftaran }}
                            </div>

                        </div>


                        <div class="col-md-3">

                            <small class="text-muted">
                                Penerimaan
                            </small>

                            <div>

                                @if($calonSiswa->status_penerimaan === 'diterima')

                                    <span class="badge text-bg-success">
                                        Diterima
                                    </span>

                                @else

                                    <span class="badge text-bg-danger">
                                        Tidak Diterima
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Status Daftar Ulang
                            </small>

                            <div>

                                @if($calonSiswa->status_daftar_ulang === 'terverifikasi')

                                    <span class="badge text-bg-success">
                                        Terverifikasi
                                    </span>

                                @elseif($calonSiswa->status_daftar_ulang === 'revisi')

                                    <span class="badge text-bg-danger">
                                        Revisi
                                    </span>

                                @elseif($calonSiswa->status_daftar_ulang === 'menunggu_verifikasi')

                                    <span class="badge text-bg-warning">
                                        Menunggu Verifikasi
                                    </span>

                                @else

                                    <span class="badge text-bg-secondary">
                                        Belum Daftar Ulang
                                    </span>

                                @endif

                            </div>

                        </div>


                        <div class="col-md-6">

                            <small class="text-muted">
                                Tanggal Daftar Ulang
                            </small>

                            <div>
                                {{ $calonSiswa->tanggal_daftar_ulang
                                    ? $calonSiswa->tanggal_daftar_ulang->format('d-m-Y H:i')
                                    : '-' }}
                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- SIDEBAR STATUS --}}

        <div class="col-lg-4">

            <div class="card shadow-sm border-0 mb-4">

                <div class="card-header bg-white">

                    <h5 class="mb-0">
                        Status Daftar Ulang
                    </h5>

                </div>

                <div class="card-body">

                    @if($calonSiswa->status_daftar_ulang === 'terverifikasi')

                        <div class="alert alert-success">
                            Semua dokumen telah diverifikasi.
                        </div>

                    @elseif($calonSiswa->status_daftar_ulang === 'revisi')

                        <div class="alert alert-danger">
                            Terdapat dokumen yang perlu diperbaiki.
                        </div>

                    @elseif($calonSiswa->status_daftar_ulang === 'menunggu_verifikasi')

                        <div class="alert alert-warning">
                            Dokumen sedang menunggu verifikasi.
                        </div>

                    @else

                        <div class="alert alert-secondary">
                            Calon siswa belum melakukan daftar ulang.
                        </div>

                    @endif


                    @if($calonSiswa->catatan_revisi)

                        <div class="mt-3">

                            <strong>
                                Catatan Revisi:
                            </strong>

                            <p class="text-muted">
                                {{ $calonSiswa->catatan_revisi }}
                            </p>

                        </div>

                    @endif


                    @if(
                        $calonSiswa->status_penerimaan === 'diterima'
                        &&
                        $calonSiswa->status_daftar_ulang !== 'terverifikasi'
                    )

                        <form
                            action="{{ route(
                                'admin.spmb.daftar-ulang.verifikasi',
                                $calonSiswa->id
                            ) }}"
                            method="POST"
                            class="mt-3"
                        >

                            @csrf
                            @method('PUT')

                            <button
                                class="btn btn-success w-100"
                                onclick="return confirm(
                                    'Verifikasi daftar ulang siswa ini?'
                                )"
                            >
                                Verifikasi Daftar Ulang
                            </button>

                        </form>

                    @endif

                </div>

            </div>

        </div>

    </div>


    {{-- DOKUMEN --}}

    <div class="card shadow-sm border-0">

        <div class="card-header bg-white">

            <h5 class="mb-0">
                Dokumen Daftar Ulang
            </h5>

        </div>

        <div class="card-body p-0">

            @php

                $jenisDokumen = [
                    'skl_ijazah' => 'SKL / Ijazah',
                    'rapor' => 'Rapor',
                    'kk' => 'Kartu Keluarga',
                    'akta_kelahiran' => 'Akta Kelahiran',
                    'surat_kesehatan' => 'Surat Kesehatan',
                    'surat_pernyataan_orang_tua' => 'Surat Pernyataan Orang Tua',
                    'bukti_penerimaan' => 'Bukti Penerimaan Tahap',
                ];

            @endphp


            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th>
                                Dokumen
                            </th>

                            <th>
                                File
                            </th>

                            <th>
                                Status
                            </th>

                            <th>
                                Catatan
                            </th>

                            <th width="280">
                                Verifikasi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @foreach($jenisDokumen as $key => $label)

                        @php

                            $dok = $calonSiswa->dokumen
                                ->where('jenis_dokumen', $key)
                                ->first();

                        @endphp


                        <tr>

                            <td class="fw-semibold">
                                {{ $label }}
                            </td>


                            <td>

                                @if($dok)

                                    <a
                                        href="{{ asset('storage/' . $dok->path_file) }}"
                                        target="_blank"
                                        class="btn btn-sm btn-outline-primary"
                                    >
                                        Lihat Dokumen
                                    </a>

                                @else

                                    <span class="text-muted">
                                        Belum diupload
                                    </span>

                                @endif

                            </td>


                            <td>

    @if(!$dok)

    <span class="badge text-bg-secondary">
        Belum Ada
    </span>

@elseif($dok->status === 'Valid')

    <span class="badge text-bg-success">
        Valid
    </span>

@elseif($dok->status === 'Tidak Valid')

    <span class="badge text-bg-danger">
        Tidak Valid
    </span>

@else

    <span class="badge text-bg-warning">
        Belum Diverifikasi
    </span>

@endif

</td>


                            <td>

                                @if($dok && $dok->catatan)

                                    {{ $dok->catatan }}

                                @else

                                    <span class="text-muted">
                                        -
                                    </span>

                                @endif

                            </td>


                            <td>

    @if($dok)

        <form
            action="{{ route(
                'admin.spmb.dokumen.verifikasi',
                [
                    'id' => $calonSiswa->id,
                    'dokumenId' => $dok->id
                ]
            ) }}"
            method="POST"
        >

            @csrf
            @method('PUT')

            <div class="input-group">

                <select
                    name="status_verifikasi"
                    class="form-select form-select-sm"
                    required
                >

                    <option
                        value="Belum Diverifikasi"
                        @selected(
                            $dok->status === 'Belum Diverifikasi'
                        )
                    >
                        Belum Diverifikasi
                    </option>

                    <option
                        value="Valid"
                        @selected(
                            $dok->status === 'Valid'
                        )
                    >
                        Valid
                    </option>

                    <option
                        value="Tidak Valid"
                        @selected(
                            $dok->status === 'Tidak Valid'
                        )
                    >
                        Tidak Valid
                    </option>

                </select>

                <input
                    type="text"
                    name="catatan"
                    class="form-control form-control-sm"
                    placeholder="Catatan"
                    value="{{ $dok->catatan }}"
                >

                <button
                    type="submit"
                    class="btn btn-primary btn-sm"
                >
                    Simpan
                </button>

            </div>

        </form>

    @else

        <span class="text-muted">
            Menunggu upload
        </span>

    @endif

</td>

                        </tr>

                    @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection