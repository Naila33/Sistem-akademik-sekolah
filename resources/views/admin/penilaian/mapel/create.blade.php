
@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="mb-4">

        <a href="{{ route(
            'admin.penilaian.mapel.mapel',
            [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id
            ]
        ) }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left me-1"></i>
            Kembali

        </a>

    </div>


    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Tambah Penilaian
        </h3>

        <p class="text-muted mb-0">

            {{ $kelas->tingkat }}
            {{ $kelas->nama_kelas }}

            <span class="mx-1">—</span>

            {{ $mataPelajaran->nama_mapel }}

        </p>

    </div>


    {{-- ========================================================= --}}
    {{-- FORM --}}
    {{-- ========================================================= --}}

    <div class="card border-0 shadow-sm">

        <div class="card-body p-4">

            <form method="POST"
                  action="{{ route(
                      'admin.penilaian.mapel.store',
                      [
                          'kelasId' => $kelas->id,
                          'mapelId' => $mataPelajaran->id
                      ]
                  ) }}">

                @csrf


                {{-- ================================================= --}}
                {{-- GURU / JADWAL --}}
                {{-- ================================================= --}}

                <div class="mb-4">

                    <label for="jadwal_pelajaran_id"
                           class="form-label fw-semibold">

                        Guru / Jadwal

                    </label>

                    <select name="jadwal_pelajaran_id"
                            id="jadwal_pelajaran_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Guru --
                        </option>

                        @foreach($jadwal as $j)

                            <option value="{{ $j->id }}"
                                {{ old('jadwal_pelajaran_id') == $j->id
                                    ? 'selected'
                                    : '' }}>

                                {{ $j->guru?->nama ?? '-' }}

                                @if($j->hari)
                                    — {{ $j->hari }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                    @error('jadwal_pelajaran_id')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- SISWA - AJAX SEARCH --}}
                {{-- ================================================= --}}

                <div class="mb-4">

                    <label for="searchSiswa"
                           class="form-label fw-semibold">

                        Siswa

                    </label>


                    {{-- Hidden ID siswa --}}
                    <input type="hidden"
                           name="siswa_id"
                           id="siswa_id"
                           value="{{ old('siswa_id') }}"
                           required>


                    {{-- Search siswa --}}
                    <div class="input-group">

                        <span class="input-group-text">
                            <i class="bi bi-search"></i>
                        </span>

                        <input type="text"
                               id="searchSiswa"
                               class="form-control"
                               placeholder="Ketik nama, NIS, atau NISN..."
                               autocomplete="off">

                    </div>


                    <small class="text-muted">
                        Ketik minimal 2 karakter untuk mencari siswa di kelas ini.
                    </small>


                    {{-- Loading --}}
                    <div id="loadingSiswa"
                         class="text-muted small mt-2 d-none">

                        <span class="spinner-border spinner-border-sm me-1"></span>

                        Mencari siswa...

                    </div>


                    {{-- Hasil pencarian --}}
                    <div id="hasilSiswa"
                         class="list-group mt-2"
                         style="max-height: 250px; overflow-y: auto;">
                    </div>


                    {{-- Tidak ditemukan --}}
                    <div id="siswaTidakDitemukan"
                         class="alert alert-light border mt-2 d-none">

                        <i class="bi bi-person-x me-1"></i>

                        Siswa tidak ditemukan di kelas ini.

                    </div>


                    {{-- Siswa terpilih --}}
                    <div id="siswaTerpilih"
                         class="alert alert-success mt-3 mb-0 d-none">

                        <div class="d-flex justify-content-between align-items-center">

                            <div>

                                <div class="fw-bold"
                                     id="namaSiswaTerpilih">
                                </div>

                                <small class="text-muted"
                                       id="detailSiswaTerpilih">
                                </small>

                            </div>


                            <button type="button"
                                    id="hapusSiswa"
                                    class="btn btn-sm btn-outline-danger"
                                    title="Ganti siswa">

                                <i class="bi bi-x-lg"></i>

                            </button>

                        </div>

                    </div>


                    @error('siswa_id')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- JENIS NILAI --}}
                {{-- ================================================= --}}

                <div class="mb-4">

                    <label for="jenis_nilai"
                           class="form-label fw-semibold">

                        Jenis Nilai

                    </label>

                    <select name="jenis_nilai"
                            id="jenis_nilai"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Jenis Nilai --
                        </option>

                        <option value="harian"
                            {{ old('jenis_nilai') == 'harian'
                                ? 'selected'
                                : '' }}>

                            Harian

                        </option>

                        <option value="ujian"
                            {{ old('jenis_nilai') == 'ujian'
                                ? 'selected'
                                : '' }}>

                            Ujian

                        </option>

                    </select>

                    @error('jenis_nilai')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- NILAI --}}
                {{-- ================================================= --}}

                <div class="mb-4">

                    <label for="nilai"
                           class="form-label fw-semibold">

                        Nilai

                    </label>

                    <input type="number"
                           name="nilai"
                           id="nilai"
                           class="form-control"
                           min="0"
                           max="100"
                           step="0.01"
                           value="{{ old('nilai') }}"
                           placeholder="Masukkan nilai 0 - 100"
                           required>

                    @error('nilai')

                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>

                    @enderror

                </div>


                {{-- ================================================= --}}
                {{-- BUTTON --}}
                {{-- ================================================= --}}

                <div class="d-flex gap-2">

                    <a href="{{ route(
                        'admin.penilaian.mapel.mapel',
                        [
                            'kelasId' => $kelas->id,
                            'mapelId' => $mataPelajaran->id
                        ]
                    ) }}"
                       class="btn btn-secondary">

                        <i class="bi bi-x-lg me-1"></i>
                        Batal

                    </a>


                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-save me-1"></i>
                        Simpan Penilaian

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection


{{-- ============================================================= --}}
{{-- AJAX SEARCH SISWA --}}
{{-- ============================================================= --}}

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchSiswa');
    const hasilSiswa = document.getElementById('hasilSiswa');
    const loadingSiswa = document.getElementById('loadingSiswa');
    const siswaTidakDitemukan =
        document.getElementById('siswaTidakDitemukan');

    const siswaId = document.getElementById('siswa_id');

    const siswaTerpilih =
        document.getElementById('siswaTerpilih');

    const namaSiswaTerpilih =
        document.getElementById('namaSiswaTerpilih');

    const detailSiswaTerpilih =
        document.getElementById('detailSiswaTerpilih');

    const hapusSiswa =
        document.getElementById('hapusSiswa');


    /*
    |--------------------------------------------------------------------------
    | URL SEARCH SISWA
    |--------------------------------------------------------------------------
    */

    const siswaSearchUrl = @json(
        route(
            'admin.penilaian.mapel.siswa.search',
            ['kelasId' => $kelas->id]
        )
    );


    let searchTimeout = null;


    /*
    |--------------------------------------------------------------------------
    | SEARCH SISWA VIA AJAX
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('input', function () {

        const keyword = this.value.trim();


        clearTimeout(searchTimeout);


        // Reset jika input kosong
        if (keyword.length === 0) {

            hasilSiswa.innerHTML = '';

            hasilSiswa.classList.add('d-none');

            siswaTidakDitemukan.classList.add('d-none');

            loadingSiswa.classList.add('d-none');

            return;
        }


        // Minimal 2 karakter
        if (keyword.length < 2) {

            hasilSiswa.innerHTML = '';

            hasilSiswa.classList.add('d-none');

            siswaTidakDitemukan.classList.add('d-none');

            return;
        }


        searchTimeout = setTimeout(function () {

            cariSiswa(keyword);

        }, 400);

    });


    /*
    |--------------------------------------------------------------------------
    | FUNCTION AJAX SEARCH
    |--------------------------------------------------------------------------
    */

    function cariSiswa(keyword) {

        loadingSiswa.classList.remove('d-none');

        hasilSiswa.classList.add('d-none');

        siswaTidakDitemukan.classList.add('d-none');


        fetch(
            siswaSearchUrl +
            '?search=' +
            encodeURIComponent(keyword),
            {
                method: 'GET',

                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                }
            }
        )

        .then(function (response) {

            if (!response.ok) {
                throw new Error('Gagal mengambil data siswa.');
            }

            return response.json();

        })

        .then(function (data) {

            loadingSiswa.classList.add('d-none');

            hasilSiswa.innerHTML = '';


            /*
            |--------------------------------------------------------------------------
            | TIDAK ADA DATA
            |--------------------------------------------------------------------------
            */

            if (!data.length) {

                hasilSiswa.classList.add('d-none');

                siswaTidakDitemukan.classList.remove('d-none');

                return;
            }


            siswaTidakDitemukan.classList.add('d-none');

            hasilSiswa.classList.remove('d-none');


            /*
            |--------------------------------------------------------------------------
            | TAMPILKAN HASIL
            |--------------------------------------------------------------------------
            */

            data.forEach(function (siswa) {

                const button =
                    document.createElement('button');

                button.type = 'button';

                button.className =
                    'list-group-item list-group-item-action';


                button.innerHTML = `

                    <div class="fw-semibold">
                        ${escapeHtml(siswa.nama)}
                    </div>

                    <small class="text-muted">

                        NIS:
                        ${escapeHtml(siswa.nis ?? '-')}

                        ${
                            siswa.nisn
                                ? '| NISN: ' +
                                  escapeHtml(siswa.nisn)
                                : ''
                        }

                    </small>

                `;


                /*
                |--------------------------------------------------------------------------
                | PILIH SISWA
                |--------------------------------------------------------------------------
                */

                button.addEventListener('click', function () {

                    pilihSiswa(siswa);

                });


                hasilSiswa.appendChild(button);

            });

        })

        .catch(function (error) {

            console.error(error);

            loadingSiswa.classList.add('d-none');

            hasilSiswa.innerHTML = `

                <div class="alert alert-danger mb-0">

                    <i class="bi bi-exclamation-triangle me-1"></i>

                    Gagal mengambil data siswa.

                </div>

            `;

            hasilSiswa.classList.remove('d-none');

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PILIH SISWA
    |--------------------------------------------------------------------------
    */

    function pilihSiswa(siswa) {

        siswaId.value = siswa.id;


        namaSiswaTerpilih.textContent =
            siswa.nama;


        detailSiswaTerpilih.textContent =
            'NIS: ' + (siswa.nis ?? '-') +
            (
                siswa.nisn
                    ? ' | NISN: ' + siswa.nisn
                    : ''
            );


        siswaTerpilih.classList.remove('d-none');

        hasilSiswa.classList.add('d-none');

        siswaTidakDitemukan.classList.add('d-none');

        searchInput.value = siswa.nama;

        searchInput.readOnly = true;

    }


    /*
    |--------------------------------------------------------------------------
    | GANTI SISWA
    |--------------------------------------------------------------------------
    */

    hapusSiswa.addEventListener('click', function () {

        siswaId.value = '';

        searchInput.value = '';

        searchInput.readOnly = false;

        siswaTerpilih.classList.add('d-none');

        hasilSiswa.innerHTML = '';

        hasilSiswa.classList.add('d-none');

        siswaTidakDitemukan.classList.add('d-none');

        searchInput.focus();

    });


    /*
    |--------------------------------------------------------------------------
    | ESCAPE HTML
    |--------------------------------------------------------------------------
    |
    | Mencegah karakter dari data siswa langsung menjadi HTML.
    |
    */

    function escapeHtml(value) {

        const div = document.createElement('div');

        div.textContent = value ?? '';

        return div.innerHTML;

    }

});

</script>