@extends('layouts.app')

@section('title', 'Penilaian Mata Pelajaran')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Penilaian Mata Pelajaran
        </h3>

        <p class="text-muted mb-0">
            Pilih kelas untuk melihat mata pelajaran dan data penilaian.
        </p>

    </div>


    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.penilaian.mapel.index') }}">

                <div class="row g-3">

                    {{-- SEARCH --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Cari Kelas
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control"
                                   value="{{ request('search') }}"
                                   placeholder="Contoh: X RPL A">

                        </div>

                    </div>


                    {{-- JENJANG --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Jenjang
                        </label>

                        <select name="tingkat"
                                class="form-select">

                            <option value="">
                                Semua Jenjang
                            </option>

                            @foreach($tingkat as $t)

                                <option value="{{ $t }}"
                                    {{ request('tingkat') == $t ? 'selected' : '' }}>

                                    {{ $t }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- JURUSAN --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Jurusan
                        </label>

                        <select name="jurusan_id"
                                class="form-select">

                            <option value="">
                                Semua Jurusan
                            </option>

                            @foreach($jurusan as $j)

                                <option value="{{ $j->id }}"
                                    {{ request('jurusan_id') == $j->id ? 'selected' : '' }}>

                                    {{ $j->nama_jurusan }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-1 d-flex align-items-end">

                        <button type="submit"
                                class="btn btn-success w-100">

                            <i class="bi bi-funnel"></i>

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- CARD KELAS --}}
    <div class="row g-4">

        @forelse($kelas as $k)

            <div class="col-xl-3 col-lg-4 col-md-6">

                <a href="{{ route(
                    'admin.penilaian.mapel.kelas',
                    $k->id
                ) }}"
                   class="text-decoration-none">

                    <div class="card border-0 shadow-sm h-100 kelas-card">

                        <div class="card-body">

                            <div class="d-flex justify-content-between align-items-start">

                                <div>

                                    <div class="text-muted small mb-1">
                                        Kelas
                                    </div>

                                    <h4 class="fw-bold text-dark mb-1">

                                        {{ $k->tingkat }}
                                        {{ $k->nama_kelas }}

                                    </h4>

                                    <div class="text-muted">

                                        {{ $k->jurusan?->nama_jurusan ?? 'Umum' }}

                                    </div>

                                </div>


                                <div class="rounded-circle bg-success bg-opacity-10
                                            p-3 text-success">

                                    <i class="bi bi-mortarboard-fill fs-4"></i>

                                </div>

                            </div>


                            <hr>


                            <div class="d-flex justify-content-between">

                                <span class="text-muted">
                                    <i class="bi bi-people me-1"></i>
                                    Siswa
                                </span>

                                <strong>
                                    {{ $k->siswa_kelas_count }}
                                </strong>

                            </div>


                        </div>


                        <div class="card-footer bg-white border-0 pt-0">

                            <div class="text-success fw-semibold">

                                Lihat Mata Pelajaran

                                <i class="bi bi-arrow-right ms-1"></i>

                            </div>

                        </div>

                    </div>

                </a>

            </div>

        @empty

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-mortarboard fs-1 text-muted"></i>

                        <h5 class="mt-3">
                            Kelas tidak ditemukan
                        </h5>

                        <p class="text-muted mb-0">
                            Belum ada kelas yang sesuai dengan filter.
                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>

</div>


<style>

.kelas-card {
    transition: all .2s ease;
}

.kelas-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,.10) !important;
}

</style>

@endsection