@extends('layouts.app')

@section('title', 'Tambah Penilaian')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route(
            'admin.penilaian.mapel.mapel',
            [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id
            ]
        ) }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>


    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Tambah Penilaian
        </h3>

        <p class="text-muted">
            {{ $kelas->tingkat }}
            {{ $kelas->nama_kelas }}
            —
            {{ $mataPelajaran->nama_mapel }}
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST"
                  action="{{ route(
                      'admin.penilaian.mapel.store',
                      [
                          'kelasId' => $kelas->id,
                          'mapelId' => $mataPelajaran->id
                      ]
                  ) }}">

                @csrf


                {{-- JADWAL --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Guru / Jadwal
                    </label>

                    <select name="jadwal_pelajaran_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Guru --
                        </option>

                        @foreach($jadwal as $j)

                            <option value="{{ $j->id }}">

                                {{ $j->guru?->nama ?? '-' }}

                                @if($j->hari)
                                    — {{ $j->hari }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- SISWA --}}
<div class="mb-3">

    <label class="form-label fw-semibold">
        Siswa
    </label>

    {{-- Hidden ID siswa yang dipilih --}}
    <input type="hidden"
           name="siswa_id"
           id="siswa_id"
           required>

    {{-- Search siswa --}}
    <div class="input-group">

        <span class="input-group-text">
            <i class="bi bi-search"></i>
        </span>

        <input type="text"
               id="searchSiswa"
               class="form-control"
               placeholder="Cari nama, NIS, atau NISN..."
               autocomplete="off">

    </div>

    {{-- Hasil pencarian --}}
    <div id="hasilSiswa"
         class="list-group mt-2"
         style="max-height: 250px; overflow-y: auto;">

        @foreach($siswa as $s)

            <button type="button"
                    class="list-group-item list-group-item-action siswa-item"
                    data-id="{{ $s->id }}"
                    data-nama="{{ $s->nama }}"
                    data-nis="{{ $s->nis }}"
                    data-nisn="{{ $s->nisn }}">

                <div class="fw-semibold">
                    {{ $s->nama }}
                </div>

                <small class="text-muted">
                    NIS: {{ $s->nis }}

                    @if($s->nisn)
                        | NISN: {{ $s->nisn }}
                    @endif
                </small>

            </button>

        @endforeach

    </div>

    {{-- Siswa yang dipilih --}}
    <div id="siswaTerpilih"
         class="alert alert-success mt-2 d-none">

        <div class="d-flex justify-content-between align-items-center">

            <div>

                <div class="fw-bold"
                     id="namaSiswaTerpilih">
                </div>

                <small id="nisSiswaTerpilih"></small>

            </div>

            <button type="button"
                    class="btn btn-sm btn-outline-danger"
                    id="hapusSiswa">

                <i class="bi bi-x-lg"></i>

            </button>

        </div>

    </div>

</div>


                {{-- JENIS NILAI --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jenis Nilai
                    </label>

                    <select name="jenis_nilai"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Jenis Nilai --
                        </option>

                        <option value="harian">
                            Harian
                        </option>

                        <option value="ujian">
                            Ujian
                        </option>

                    </select>

                </div>


                {{-- NILAI --}}
                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nilai
                    </label>

                    <input type="number"
                           name="nilai"
                           class="form-control"
                           min="0"
                           max="100"
                           step="0.01"
                           required>

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route(
                        'admin.penilaian.mapel.mapel',
                        [
                            'kelasId' => $kelas->id,
                            'mapelId' => $mataPelajaran->id
                        ]
                    ) }}"
                       class="btn btn-secondary">

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

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchSiswa');
    const hasilSiswa = document.getElementById('hasilSiswa');
    const siswaId = document.getElementById('siswa_id');

    const siswaTerpilih = document.getElementById('siswaTerpilih');
    const namaSiswaTerpilih = document.getElementById('namaSiswaTerpilih');
    const nisSiswaTerpilih = document.getElementById('nisSiswaTerpilih');

    const hapusSiswa = document.getElementById('hapusSiswa');

    const siswaItems = document.querySelectorAll('.siswa-item');


    /*
    |--------------------------------------------------------------------------
    | SEARCH SISWA
    |--------------------------------------------------------------------------
    */

    searchInput.addEventListener('input', function () {

        const keyword = this.value.toLowerCase().trim();

        siswaItems.forEach(function (item) {

            const nama = item.dataset.nama.toLowerCase();
            const nis = item.dataset.nis
                ? item.dataset.nis.toLowerCase()
                : '';

            const nisn = item.dataset.nisn
                ? item.dataset.nisn.toLowerCase()
                : '';

            if (
                nama.includes(keyword) ||
                nis.includes(keyword) ||
                nisn.includes(keyword)
            ) {

                item.style.display = '';

            } else {

                item.style.display = 'none';

            }

        });

    });


    /*
    |--------------------------------------------------------------------------
    | PILIH SISWA
    |--------------------------------------------------------------------------
    */

    siswaItems.forEach(function (item) {

        item.addEventListener('click', function () {

            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const nis = this.dataset.nis;

            siswaId.value = id;

            namaSiswaTerpilih.textContent = nama;

            nisSiswaTerpilih.textContent =
                'NIS: ' + nis;

            siswaTerpilih.classList.remove('d-none');

            hasilSiswa.classList.add('d-none');

            searchInput.value = nama;

            searchInput.readOnly = true;

        });

    });


    /*
    |--------------------------------------------------------------------------
    | HAPUS SISWA
    |--------------------------------------------------------------------------
    */

    hapusSiswa.addEventListener('click', function () {

        siswaId.value = '';

        searchInput.value = '';

        searchInput.readOnly = false;

        siswaTerpilih.classList.add('d-none');

        hasilSiswa.classList.remove('d-none');

        siswaItems.forEach(function (item) {

            item.style.display = '';

        });

        searchInput.focus();

    });

});
</script>