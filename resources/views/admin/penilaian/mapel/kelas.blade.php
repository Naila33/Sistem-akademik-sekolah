@extends('layouts.app')

@section('title', 'Mata Pelajaran Kelas')

@section('content')

<div class="container-fluid py-4">

    {{-- BREADCRUMB --}}
    <div class="mb-4">

        <a href="{{ route('admin.penilaian.mapel.index') }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Kelas

        </a>

    </div>


    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                {{ $kelas->tingkat }}
                {{ $kelas->nama_kelas }}

            </h3>

            <p class="text-muted mb-0">

                {{ $kelas->jurusan?->nama_jurusan ?? 'Umum' }}

                — Pilih mata pelajaran

            </p>

        </div>

    </div>


    {{-- SEARCH --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route(
                      'admin.penilaian.mapel.kelas',
                      $kelas->id
                  ) }}">

                <div class="row g-3">

                    <div class="col-md-8">

                        <label class="form-label fw-semibold">
                            Cari Mata Pelajaran
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-search"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Cari nama atau kode mata pelajaran">

                        </div>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-success w-100">

                            <i class="bi bi-search me-1"></i>
                            Cari

                        </button>

                    </div>


                    <div class="col-md-2 d-flex align-items-end">

                        <a href="{{ route(
                            'admin.penilaian.mapel.kelas',
                            $kelas->id
                        ) }}"
                           class="btn btn-secondary w-100">

                            <i class="bi bi-arrow-counterclockwise"></i>
                            Reset

                        </a>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- CARD MAPEL --}}
    <div class="row g-4">

        @forelse($mataPelajaran as $mapel)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <a href="{{ route(
                    'admin.penilaian.mapel.mapel',
                    [
                        'kelasId' => $kelas->id,
                        'mapelId' => $mapel->id
                    ]
                ) }}"
                   class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 mapel-card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between">

                                <div>

                                    <div class="text-muted small">
                                        Mata Pelajaran
                                    </div>

                                    <h5 class="fw-bold text-dark mt-1">

                                        {{ $mapel->nama_mapel }}

                                    </h5>

                                </div>


                                <div class="rounded-circle bg-primary bg-opacity-10
                                            p-3 text-primary">

                                    <i class="bi bi-book fs-5"></i>

                                </div>

                            </div>


                            <div class="mt-4">

                                @if($mapel->kode_mapel)

                                    <span class="badge bg-light text-dark">

                                        {{ $mapel->kode_mapel }}

                                    </span>

                                @endif

                            </div>


                            <hr>


                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    Data Penilaian
                                </span>

                                <strong>
                                    {{ $mapel->jumlah_penilaian }}
                                </strong>

                            </div>

                        </div>


                        <div class="card-footer bg-white border-0">

                            <span class="text-success fw-semibold">

                                Lihat Penilaian

                                <i class="bi bi-arrow-right ms-1"></i>

                            </span>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-book fs-1 text-muted"></i>

                        <h5 class="mt-3">
                            Mata pelajaran tidak ditemukan
                        </h5>

                        <p class="text-muted">
                            Belum ada mata pelajaran pada kelas ini.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>


<style>

.mapel-card {
    transition: all .2s ease;
}

.mapel-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,.10) !important;
}

</style>

@endsection