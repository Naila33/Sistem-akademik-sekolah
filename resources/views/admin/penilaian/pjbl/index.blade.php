@extends('layouts.app')

@section('title', 'Penilaian PJBL')

@section('content')

<div class="container-fluid py-4">

{{-- ========================================================= --}}
{{-- HEADER --}}
{{-- ========================================================= --}}

<div class="mb-4">

    <h3 class="fw-bold mb-1">
        Penilaian PJBL
    </h3>

    <p class="text-muted mb-0">
        Pilih kelas untuk melihat penilaian Project Based Learning.
    </p>

</div>


{{-- ========================================================= --}}
{{-- SEARCH & FILTER --}}
{{-- ========================================================= --}}

<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="row g-3 align-items-end">

            {{-- SEARCH KELAS --}}
            <div class="col-md-7">

                <label for="searchKelas"
                       class="form-label fw-semibold">

                    Cari Kelas

                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           id="searchKelas"
                           class="form-control"
                           placeholder="Cari tingkat, jurusan, atau nama kelas..."
                           autocomplete="off">

                </div>

            </div>


            {{-- FILTER JENJANG --}}
            <div class="col-md-3">

                <label for="filterTingkat"
                       class="form-label fw-semibold">

                    Jenjang

                </label>

                <select id="filterTingkat"
                        class="form-select">

                    <option value="">
                        Semua Jenjang
                    </option>

                    @foreach(
                        $kelas
                            ->pluck('tingkat')
                            ->filter()
                            ->unique()
                            ->sort()
                        as $tingkat
                    )

                        <option value="{{ $tingkat }}">
                            {{ $tingkat }}
                        </option>

                    @endforeach

                </select>

            </div>


            

        </div>

    </div>

</div>


{{-- ========================================================= --}}
{{-- HASIL --}}
{{-- ========================================================= --}}

<div class="mb-3">

    <small class="text-muted">

        Menampilkan
        <span id="jumlahKelas"
              class="fw-semibold text-dark">
            {{ $kelas->count() }}
        </span>
        kelas

    </small>

</div>


{{-- ========================================================= --}}
{{-- CARD KELAS --}}
{{-- ========================================================= --}}

<div class="row g-4"
     id="kelasContainer">

    @forelse($kelas as $k)

        @php

            $searchText = strtolower(
                $k->tingkat . ' ' .
                ($k->jurusan?->nama_jurusan ?? '') . ' ' .
                $k->nama_kelas
            );

        @endphp


        <div class="col-xl-3 col-lg-4 col-md-6 kelas-card"
             data-search="{{ $searchText }}"
             data-tingkat="{{ $k->tingkat }}">

            <a href="{{ route(
                'admin.penilaian.pjbl.kelas',
                $k->id
            ) }}"
               class="text-decoration-none">

                <div class="card border-0 shadow-sm h-100">

                    <div class="card-body p-4">

                        {{-- ICON --}}
                        <div class="d-flex justify-content-between align-items-start mb-3">

                            <div class="rounded-circle
                                        bg-success
                                        bg-opacity-10
                                        text-success
                                        d-flex
                                        align-items-center
                                        justify-content-center"
                                 style="width:50px;height:50px;">

                                <i class="bi bi-mortarboard-fill fs-4"></i>

                            </div>

                            <i class="bi bi-arrow-right text-muted"></i>

                        </div>


                        {{-- NAMA KELAS --}}
                        <h5 class="fw-bold text-dark mb-1">

                            {{ $k->tingkat }}
                            {{ $k->nama_kelas }}

                        </h5>


                        {{-- JURUSAN --}}
                        <p class="text-muted mb-3">

                            {{ $k->jurusan?->nama_jurusan ?? 'Umum' }}

                        </p>


                        {{-- JUMLAH SISWA --}}
                        <div class="d-flex justify-content-between align-items-center">

                            <small class="text-muted">

                                <i class="bi bi-people me-1"></i>

                                {{ $k->siswa_kelas_count }}
                                Siswa

                            </small>


                            <span class="text-success fw-semibold">

                                Lihat PJBL

                            </span>

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
                        Belum ada data kelas
                    </h5>

                    <p class="text-muted mb-0">
                        Data kelas belum tersedia.
                    </p>

                </div>

            </div>

        </div>

    @endforelse

</div>


{{-- ========================================================= --}}
{{-- DATA TIDAK DITEMUKAN --}}
{{-- ========================================================= --}}

<div id="kelasEmpty"
     class="card border-0 shadow-sm mt-4"
     style="display: none;">

<div class="card-body text-center py-5">

    <i class="bi bi-search fs-1 text-muted"></i>

    <h5 class="mt-3">
        Kelas tidak ditemukan
    </h5>

    <p class="text-muted mb-0">
        Coba gunakan kata pencarian atau jenjang yang berbeda.
    </p>

</div>

</div>

{{-- ========================================================= --}}
{{-- LIVE SEARCH & FILTER --}}
{{-- ========================================================= --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchKelas');
    const filterTingkat = document.getElementById('filterTingkat');
    const resetButton = document.getElementById('resetFilter');

    const cards = document.querySelectorAll('.kelas-card');
    const emptyMessage = document.getElementById('kelasEmpty');
    const jumlahKelas = document.getElementById('jumlahKelas');


    /*
    |--------------------------------------------------------------------------
    | FILTER KELAS
    |--------------------------------------------------------------------------
    */

    function filterKelas() {

        const keyword = searchInput.value
            .trim()
            .toLowerCase();

        const tingkat = filterTingkat.value
            .trim()
            .toLowerCase();

        let jumlahTampil = 0;


        cards.forEach(function (card) {

            const searchText = (
                card.dataset.search || ''
            ).toLowerCase();

            const cardTingkat = (
                card.dataset.tingkat || ''
            ).toLowerCase();


            // Cek pencarian
            const cocokSearch =
                keyword === '' ||
                searchText.includes(keyword);


            // Cek jenjang
            const cocokTingkat =
                tingkat === '' ||
                cardTingkat === tingkat;


            // Tentukan tampil / sembunyi
            if (cocokSearch && cocokTingkat) {

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

        jumlahKelas.textContent = jumlahTampil;


        /*
        |--------------------------------------------------------------------------
        | PESAN TIDAK DITEMUKAN
        |--------------------------------------------------------------------------
        */

        if (jumlahTampil === 0) {

            emptyMessage.style.display = 'block';

        } else {

            emptyMessage.style.display = 'none';

        }

    }


    /*
    |--------------------------------------------------------------------------
    | LIVE SEARCH
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('input', function () {

        filterKelas();

    });


    /*
    |--------------------------------------------------------------------------
    | FILTER JENJANG
    |--------------------------------------------------------------------------
    */

    filterTingkat.addEventListener('change', function () {

        filterKelas();

    });


    /*
    |--------------------------------------------------------------------------
    | RESET
    |--------------------------------------------------------------------------
    */

    resetButton.addEventListener('click', function () {

        searchInput.value = '';

        filterTingkat.value = '';

        filterKelas();

        searchInput.focus();

    });


    /*
    |--------------------------------------------------------------------------
    | JALANKAN SAAT HALAMAN DIBUKA
    |--------------------------------------------------------------------------
    */

    filterKelas();

});
</script>
@endsection
