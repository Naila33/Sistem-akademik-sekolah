@extends('layouts.app')

@section('title', 'PJBL ' . $kelas->tingkat . ' ' . $kelas->nama_kelas)

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-4">

        <a href="{{ route('admin.penilaian.pjbl.index') }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali ke Kelas

        </a>

    </div>


    <div class="mb-4">

        <h3 class="fw-bold mb-1">

            PJBL
            {{ $kelas->tingkat }}
            {{ $kelas->nama_kelas }}

        </h3>

        <p class="text-muted mb-0">

            {{ $kelas->jurusan?->nama_jurusan ?? 'Umum' }}

            — Pilih periode PJBL

        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- SEARCH & FILTER --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3 align-items-end">

                {{-- ================================================= --}}
                {{-- SEARCH --}}
                {{-- ================================================= --}}

                <div class="col-md-5">

                    <label for="searchPjbl"
                           class="form-label fw-semibold">

                        Cari Periode PJBL

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               id="searchPjbl"
                               class="form-control"
                               placeholder="Cari Ganjil, Genap, SMT 1, SMT 2..."
                               autocomplete="off">

                    </div>

                    <small class="text-muted">
                        Ketik nama periode seperti Ganjil, Genap, SMT 1, atau SMT 2.
                    </small>

                </div>


                {{-- ================================================= --}}
                {{-- KALENDER --}}
                {{-- ================================================= --}}

                <div class="col-md-3">

                    <label for="filterTanggal"
                           class="form-label fw-semibold">

                        Tanggal PJBL

                    </label>

                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-calendar3"></i>
                        </span>

                        <input type="date"
                               id="filterTanggal"
                               class="form-control">

                    </div>

                </div>


                {{-- ================================================= --}}
                {{-- TAHUN AJARAN --}}
                {{-- ================================================= --}}

                <div class="col-md-3">

                    <label for="filterTahun"
                           class="form-label fw-semibold">

                        Tahun Ajaran

                    </label>

                    <select id="filterTahun"
                            class="form-select">

                        <option value="">
                            Semua Tahun
                        </option>

                        @foreach(
                            $pjbl
                                ->pluck('tahunAjaran')
                                ->filter()
                                ->unique('id')
                            as $tahun
                        )

                            <option value="{{ $tahun->id }}">

                                {{ $tahun->tahun_ajaran
                                    ?? $tahun->tahun
                                    ?? $tahun->nama
                                    ?? $tahun->nama_tahun
                                    ?? $tahun->id
                                }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- ================================================= --}}
                {{-- RESET --}}
                {{-- ================================================= --}}

                <div class="col-md-2">

                <button type="button"
                        id="resetFilter"
                        class="btn btn-secondary w-100">

                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset

                </button>

            </div>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- JUMLAH HASIL --}}
    {{-- ========================================================= --}}

    <div class="mb-3">

        <small class="text-muted">

            Menampilkan

            <span id="jumlahPjbl"
                  class="fw-semibold text-dark">

                {{ $pjbl->count() }}

            </span>

            periode PJBL

        </small>

    </div>


    {{-- ========================================================= --}}
    {{-- CARD PJBL --}}
    {{-- ========================================================= --}}

    <div class="row g-4"
         id="pjblContainer">

        @forelse($pjbl as $p)

            @php

                /*
                |--------------------------------------------------------------------------
                | NAMA PERIODE
                |--------------------------------------------------------------------------
                */

                $namaPeriode = strtolower(
                    trim($p->nama_periode ?? '')
                );


                /*
                |--------------------------------------------------------------------------
                | TENTUKAN SEMESTER
                |--------------------------------------------------------------------------
                */

                if (
                    str_contains($namaPeriode, 'ganjil') ||
                    str_contains($namaPeriode, 'semester 1') ||
                    str_contains($namaPeriode, 'smt 1')
                ) {

                    $semester = 'Ganjil';

                } elseif (
                    str_contains($namaPeriode, 'genap') ||
                    str_contains($namaPeriode, 'semester 2') ||
                    str_contains($namaPeriode, 'smt 2')
                ) {

                    $semester = 'Genap';

                } else {

                    /*
                    |--------------------------------------------------------------------------
                    | FALLBACK
                    |--------------------------------------------------------------------------
                    */

                    $semester = 'Ganjil';

                }


                /*
                |--------------------------------------------------------------------------
                | TENTUKAN SMT
                |--------------------------------------------------------------------------
                */

                if (
                    str_contains($namaPeriode, 'smt 2') ||
                    str_contains($namaPeriode, 'semester 2')
                ) {

                    $smt = 'SMT 2';

                } else {

                    $smt = 'SMT 1';

                }


                /*
                |--------------------------------------------------------------------------
                | NAMA PERIODE FINAL
                |--------------------------------------------------------------------------
                */

                $periodeDisplay =
                    'PJBL ' .
                    $semester .
                    ' ' .
                    $smt;


                /*
                |--------------------------------------------------------------------------
                | DATA SEARCH
                |--------------------------------------------------------------------------
                */

                $searchText = strtolower(
                    $periodeDisplay . ' ' .
                    ($p->nama_periode ?? '') . ' ' .
                    ($p->tanggal ?? '')
                );


                /*
                |--------------------------------------------------------------------------
                | TANGGAL
                |--------------------------------------------------------------------------
                */

                $tanggalDisplay = $p->tanggal
                    ? \Carbon\Carbon::parse($p->tanggal)->format('d/m/Y')
                    : '-';


                $tanggalFilter = $p->tanggal
                    ? \Carbon\Carbon::parse($p->tanggal)->format('Y-m-d')
                    : '';

            @endphp


            <div class="col-xl-3 col-lg-4 col-md-6 pjbl-card"

                 data-search="{{ $searchText }}"

                 data-tahun="{{ $p->tahunAjaran?->id ?? '' }}"

                 data-tanggal="{{ $tanggalFilter }}">


                <a href="{{ route(
                    'admin.penilaian.pjbl.penilaian',
                    [
                        'kelasId' => $kelas->id,
                        'pjblId' => $p->id
                    ]
                ) }}"
                   class="text-decoration-none">


                    <div class="card border-0 shadow-sm h-100">


                        <div class="card-body p-4">


                            {{-- ================================================= --}}
                            {{-- ICON --}}
                            {{-- ================================================= --}}

                            <div class="d-flex justify-content-between
                                        align-items-start mb-3">


                                <div class="rounded-circle
                                            bg-success
                                            bg-opacity-10
                                            text-success
                                            d-flex
                                            align-items-center
                                            justify-content-center"

                                     style="width:50px;height:50px;">

                                    <i class="bi bi-kanban-fill fs-4"></i>

                                </div>


                                <i class="bi bi-arrow-right text-muted"></i>


                            </div>


                            {{-- ================================================= --}}
                            {{-- PERIODE --}}
                            {{-- ================================================= --}}

                            <h5 class="fw-bold text-dark mb-2">

                                {{ $periodeDisplay }}

                            </h5>


                            {{-- ================================================= --}}
                            {{-- TANGGAL --}}
                            {{-- ================================================= --}}

                            <p class="text-muted mb-3">

                                <i class="bi bi-calendar3 me-1"></i>

                                {{ $tanggalDisplay }}

                            </p>


                            {{-- ================================================= --}}
                            {{-- TAHUN AJARAN --}}
                            {{-- ================================================= --}}

                            <div class="mb-3">

                                <span class="badge bg-light text-dark border">

                                    <i class="bi bi-calendar-range me-1"></i>

                                    {{ $p->tahunAjaran?->tahun_ajaran
                                        ?? $p->tahunAjaran?->tahun
                                        ?? $p->tahunAjaran?->nama
                                        ?? $p->tahunAjaran?->nama_tahun
                                        ?? '-'
                                    }}

                                </span>

                            </div>


                            {{-- ================================================= --}}
                            {{-- PENGUJI --}}
                            {{-- ================================================= --}}

                            <div class="border-top pt-3">

                                <small class="text-muted">

                                    <i class="bi bi-person-badge me-1"></i>

                                    {{ $p->penguji->count() }}

                                    Penguji

                                </small>

                            </div>


                        </div>

                    </div>

                </a>

            </div>


        @empty


            {{-- ========================================================= --}}
            {{-- DATA KOSONG --}}
            {{-- ========================================================= --}}

            <div class="col-12">

                <div class="card border-0 shadow-sm">

                    <div class="card-body text-center py-5">

                        <i class="bi bi-kanban fs-1 text-muted"></i>

                        <h5 class="mt-3">

                            Belum ada PJBL

                        </h5>

                        <p class="text-muted mb-0">

                            Belum ada data PJBL untuk kelas ini.

                        </p>

                    </div>

                </div>

            </div>

        @endforelse

    </div>


    {{-- ========================================================= --}}
    {{-- TIDAK DITEMUKAN --}}
    {{-- ========================================================= --}}

    <div id="pjblEmpty"
         class="card border-0 shadow-sm mt-4"
         style="display: none;">

        <div class="card-body text-center py-5">

            <i class="bi bi-search fs-1 text-muted"></i>

            <h5 class="mt-3">

                PJBL tidak ditemukan

            </h5>

            <p class="text-muted mb-0">

                Coba ubah kata pencarian, tanggal, atau tahun ajaran.

            </p>

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- LIVE SEARCH & FILTER --}}
{{-- ========================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('searchPjbl');

    const filterTanggal =
        document.getElementById('filterTanggal');

    const filterTahun =
        document.getElementById('filterTahun');

    const resetButton =
        document.getElementById('resetPjbl');

    const cards =
        document.querySelectorAll('.pjbl-card');

    const empty =
        document.getElementById('pjblEmpty');

    const jumlahPjbl =
        document.getElementById('jumlahPjbl');


    /*
    |--------------------------------------------------------------------------
    | FILTER PJBL
    |--------------------------------------------------------------------------
    */

    function filterPjbl() {

        const keyword =
            searchInput.value
                .trim()
                .toLowerCase();


        const tanggal =
            filterTanggal.value
                .trim();


        const tahun =
            filterTahun.value
                .trim();


        let jumlahTampil = 0;


        cards.forEach(function (card) {

            const searchText =
                card.dataset.search
                    .toLowerCase();


            const cardTanggal =
                card.dataset.tanggal || '';


            const cardTahun =
                card.dataset.tahun || '';


            /*
            |--------------------------------------------------------------------------
            | CARI NAMA / PERIODE
            |--------------------------------------------------------------------------
            */

            const cocokSearch =
                keyword === '' ||
                searchText.includes(keyword);


            /*
            |--------------------------------------------------------------------------
            | FILTER TANGGAL
            |--------------------------------------------------------------------------
            */

            const cocokTanggal =
                tanggal === '' ||
                cardTanggal === tanggal;


            /*
            |--------------------------------------------------------------------------
            | FILTER TAHUN
            |--------------------------------------------------------------------------
            */

            const cocokTahun =
                tahun === '' ||
                cardTahun === tahun;


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN CARD
            |--------------------------------------------------------------------------
            */

            if (
                cocokSearch &&
                cocokTanggal &&
                cocokTahun
            ) {

                card.style.display = '';

                jumlahTampil++;

            } else {

                card.style.display = 'none';

            }

        });


        /*
        |--------------------------------------------------------------------------
        | UPDATE JUMLAH
        |--------------------------------------------------------------------------
        */

        jumlahPjbl.textContent =
            jumlahTampil;


        /*
        |--------------------------------------------------------------------------
        | EMPTY STATE
        |--------------------------------------------------------------------------
        */

        if (jumlahTampil === 0) {

            empty.style.display = 'block';

        } else {

            empty.style.display = 'none';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener(
        'input',
        function () {

            filterPjbl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER TANGGAL OTOMATIS
    |--------------------------------------------------------------------------
    */

    filterTanggal.addEventListener(
        'change',
        function () {

            filterPjbl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | FILTER TAHUN OTOMATIS
    |--------------------------------------------------------------------------
    */

    filterTahun.addEventListener(
        'change',
        function () {

            filterPjbl();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            filterTanggal.value = '';

            filterTahun.value = '';

            filterPjbl();

            searchInput.focus();

        }
    );


    /*
    |--------------------------------------------------------------------------
    | JALANKAN SAAT HALAMAN DIBUKA
    |--------------------------------------------------------------------------
    */

    filterPjbl();

});

</script>

@endsection