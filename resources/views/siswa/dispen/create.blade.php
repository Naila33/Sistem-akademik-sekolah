@extends('layouts.app')

@section('title', 'Ajukan Dispensasi')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}

    <div class="mb-4">

        <a
            href="{{ route('siswa.dispen.index') }}"
            class="text-decoration-none text-muted"
        >

            <i class="bi bi-arrow-left me-1"></i>

            Kembali ke Dispensasi

        </a>


        <h3 class="fw-bold mt-3 mb-1">

            Ajukan Dispensasi

        </h3>


        <p class="text-muted mb-0">

            Silakan isi data pengajuan dispensasi dengan lengkap.

        </p>

    </div>


    {{-- FORM --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form
                action="{{ route('siswa.dispen.store') }}"
                method="POST"
                enctype="multipart/form-data"
            >

                @csrf


                {{-- DATA SISWA --}}

                <div class="mb-4">

                    <h5 class="fw-bold mb-3">
                        Data Siswa
                    </h5>


                    <div class="row g-3">

                        <div class="col-md-6">

                            <label class="form-label">
                                Nama Siswa
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $siswa->nama }}"
                                readonly
                            >

                        </div>


                        <div class="col-md-6">

                            <label class="form-label">
                                NIS
                            </label>

                            <input
                                type="text"
                                class="form-control"
                                value="{{ $siswa->nis }}"
                                readonly
                            >

                        </div>

                    </div>

                </div>


                <hr class="mb-4">


                {{-- TANGGAL --}}

                <div class="mb-4">

                    <h5 class="fw-bold mb-3">
                        Periode Dispensasi
                    </h5>


                    <div class="row g-3">

                        <div class="col-md-6">

                            <label
                                for="tanggal_mulai"
                                class="form-label"
                            >
                                Tanggal Mulai
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="tanggal_mulai"
                                id="tanggal_mulai"
                                class="form-control @error('tanggal_mulai') is-invalid @enderror"
                                value="{{ old('tanggal_mulai') }}"
                                required
                            >

                            @error('tanggal_mulai')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>


                        <div class="col-md-6">

                            <label
                                for="tanggal_selesai"
                                class="form-label"
                            >
                                Tanggal Selesai
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="date"
                                name="tanggal_selesai"
                                id="tanggal_selesai"
                                class="form-control @error('tanggal_selesai') is-invalid @enderror"
                                value="{{ old('tanggal_selesai') }}"
                                required
                            >

                            @error('tanggal_selesai')

                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>

                            @enderror

                        </div>

                    </div>

                </div>


                {{-- ALASAN --}}

                <div class="mb-4">

                    <label
                        for="alasan"
                        class="form-label fw-semibold"
                    >

                        Alasan Dispensasi

                        <span class="text-danger">*</span>

                    </label>


                    <textarea
                        name="alasan"
                        id="alasan"
                        rows="5"
                        class="form-control @error('alasan') is-invalid @enderror"
                        placeholder="Jelaskan alasan pengajuan dispensasi..."
                        required
                    >{{ old('alasan') }}</textarea>


                    @error('alasan')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- SURAT --}}

                <div class="mb-4">

                    <label
                        for="surat"
                     class="form-label fw-semibold"
>
    Surat Dispensasi dari Kesiswaan
    <span class="text-danger">*</span>
</label>


                    <input
    type="file"
    name="surat"
    id="surat"
    class="form-control @error('surat') is-invalid @enderror"
    accept=".pdf,.jpg,.jpeg,.png"
    required
>


                    <div class="form-text">
    Upload surat dispensasi yang sudah diberikan oleh kesiswaan.
    Format PDF, JPG, JPEG, atau PNG. Maksimal 2 MB.
</div>


                    @error('surat')

                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- TOMBOL --}}

                <div class="d-flex gap-2">

                    <a
                        href="{{ route('siswa.dispen.index') }}"
                        class="btn btn-secondary"
                    >

                        Batal

                    </a>


                    <button
                        type="submit"
                        class="btn btn-success"
                    >

                        <i class="bi bi-send me-1"></i>

                        Ajukan Dispensasi

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection