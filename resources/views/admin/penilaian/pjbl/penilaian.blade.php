@extends('layouts.app')

@section(
'title',
'Penilaian PJBL ' .
$kelas->tingkat . ' ' .
$kelas->nama_kelas
)

@section('content')

<div class="container-fluid py-4">





<div class="mb-4">
    <a href="{{ route('admin.penilaian.pjbl.kelas', $kelas->id) }}"
       class="text-decoration-none text-muted">

        <i class="bi bi-arrow-left me-1"></i>
        Kembali ke PJBL

    </a>
</div>

<div class="d-flex justify-content-between align-items-center mb-4">

    <div>
        <h3 class="fw-bold mb-1">
            Penilaian PJBL
        </h3>

        <p class="text-muted mb-0">

            {{ $kelas->tingkat }}
            {{ $kelas->nama_kelas }}

            <span class="mx-1">—</span>

            {{ $pjbl->nama_periode ?? 'PJBL' }}

            <span class="mx-1">—</span>

            {{ $pjbl->tanggal
                ? \Carbon\Carbon::parse($pjbl->tanggal)->format('d/m/Y')
                : '-'
            }}

        </p>
    </div>

    <a href="{{ route(
        'admin.penilaian.pjbl.create',
        [
            'kelasId' => $kelas->id,
            'pjblId' => $pjbl->id
        ]
    ) }}"
       class="btn btn-success">

        <i class="bi bi-plus-lg me-1"></i>
        Tambah Penilaian

    </a>

</div>






@if(session('success'))

    <div class="alert alert-success alert-dismissible fade show">

        {{ session('success') }}

        <button type="button"
                class="btn-close"
                data-bs-dismiss="alert">
        </button>

    </div>

@endif






<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>
                <h6 class="fw-bold mb-1">
                    <i class="bi bi-people-fill text-success me-2"></i>
                    Penguji PJBL
                </h6>

                <small class="text-muted">
                    Penguji yang memberikan penilaian pada PJBL ini
                </small>
            </div>

            <span class="badge bg-success">
                {{ $penguji->count() }} Penguji
            </span>

        </div>

        <div class="table-responsive">

            <table class="table table-bordered align-middle mb-0">

                <thead class="table-light">
                    <tr>

                        <th width="70">
                            No
                        </th>

                        <th>
                            Nama Penguji
                        </th>

                        <th>
                            NIP
                        </th>

                    </tr>
                </thead>

                <tbody>

                    @forelse($penguji as $p)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td class="fw-semibold">
                                {{ $p->guru?->nama ?? '-' }}
                            </td>

                            <td>
                                {{ $p->guru?->nip ?? '-' }}
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="3"
                                class="text-center text-muted py-4">

                                Belum ada data penguji PJBL.

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>






<div class="card border-0 shadow-sm mb-4">

    <div class="card-body">

        <div class="row g-3 align-items-end">

            <div class="col-md-10">

                <label class="form-label fw-semibold">
                    Cari Siswa
                </label>

                <div class="input-group">

                    <span class="input-group-text">
                        <i class="bi bi-search"></i>
                    </span>

                    <input type="text"
                           id="liveSearchSiswa"
                           class="form-control"
                           placeholder="Cari nama, NIS, atau NISN..."
                           autocomplete="off">

                </div>

            </div>

            <div class="col-md-2">

                <button type="button"
                        id="resetSearch"
                        class="btn btn-secondary w-100">

                    <i class="bi bi-arrow-counterclockwise me-1"></i>
                    Reset

                </button>

            </div>

        </div>

    </div>

</div>






<div class="card border-0 shadow-sm">

    <div class="card-body">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <div>

                <h6 class="fw-bold mb-1">

                    <i class="bi bi-clipboard-data text-success me-2"></i>
                    Data Penilaian

                </h6>

                <small class="text-muted">
                    Nilai berdasarkan masing-masing penguji PJBL
                </small>

            </div>

            <span class="badge bg-light text-dark border">
                {{ $penilaianPerSiswa->count() }} Siswa
            </span>

        </div>


        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle mb-0">

                
                
                

                <thead class="table-light">

                    <tr>

                        <th width="60">
                            No
                        </th>

                        <th style="min-width: 220px;">
                            Siswa
                        </th>

                        
                        @foreach($penguji as $p)

                            <th class="text-center"
                                style="min-width: 130px;">

                                <div class="fw-semibold">
                                    Guru {{ $loop->iteration }}
                                </div>

                                <small class="text-muted">
                                    Nilai
                                </small>

                            </th>

                        @endforeach

                        
                        <th class="text-center"
                            style="min-width: 120px;">

                            Total Nilai

                        </th>

                        
                        <th width="150"
                            class="text-center">

                            Aksi

                        </th>

                    </tr>

                </thead>


                
                
                

                <tbody>

                    @forelse($penilaianPerSiswa as $siswaId => $nilaiSiswa)

                        @php

                            $siswa = $nilaiSiswa->first()->siswa;

                            $totalNilai = 0;

                        @endphp

                        <tr class="siswa-row"
                            data-search="{{ strtolower(
                                ($siswa?->nama ?? '') . ' ' .
                                ($siswa?->nis ?? '') . ' ' .
                                ($siswa?->nisn ?? '')
                            ) }}">

                            
                            <td>
                                {{ $loop->iteration }}
                            </td>


                            
                            <td>

                                <div class="fw-semibold">
                                    {{ $siswa?->nama ?? '-' }}
                                </div>

                                <small class="text-muted">
                                    NIS: {{ $siswa?->nis ?? '-' }}
                                </small>

                            </td>


                            
                            
                            

                            @foreach($penguji as $p)

                                @php

                                    $nilaiPenguji = $nilaiSiswa->firstWhere(
                                        'pjbl_penguji_id',
                                        $p->id
                                    );

                                    $nilai = $nilaiPenguji?->nilai ?? 0;

                                    $totalNilai += $nilai;

                                @endphp

                                <td class="text-center">

                                    @if($nilaiPenguji)

                                        <span class="badge bg-success fs-6">
                                            {{ $nilai }}
                                        </span>

                                    @else

                                        <span class="text-muted">
                                            -
                                        </span>

                                    @endif

                                </td>

                            @endforeach


                            
                            
                            

                            <td class="text-center">

                                <span class="badge bg-success fs-6">
                                    {{ $totalNilai }}
                                </span>

                            </td>


                            
                            
                            

                            <td>

                                <div class="d-flex gap-1 justify-content-center">

                                    @php
                                        $nilaiPertama = $nilaiSiswa->first();
                                    @endphp

                                    @if($nilaiPertama)

                                        <a href="{{ route(
                                            'admin.penilaian.pjbl.edit',
                                            [
                                                'kelasId' => $kelas->id,
                                                'pjblId' => $pjbl->id,
                                                'id' => $nilaiPertama->id
                                            ]
                                        ) }}"
                                           class="btn btn-sm btn-warning">

                                            <i class="bi bi-pencil"></i>
                                            Edit

                                        </a>


                                        <form action="{{ route(
                                            'admin.penilaian.pjbl.destroy',
                                            [
                                                'kelasId' => $kelas->id,
                                                'pjblId' => $pjbl->id,
                                                'id' => $nilaiPertama->id
                                            ]
                                        ) }}"
                                              method="POST"
                                              class="d-inline">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger"
                                                    onclick="return confirm('Yakin ingin menghapus penilaian PJBL ini?')">

                                                <i class="bi bi-trash"></i>
                                                Hapus

                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="{{ 4 + $penguji->count() }}"
                                class="text-center py-5">

                                <i class="bi bi-clipboard-x fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    Belum ada penilaian
                                </h6>

                                <p class="text-muted">
                                    Belum ada siswa yang dinilai pada PJBL ini.
                                </p>

                                <a href="{{ route(
                                    'admin.penilaian.pjbl.create',
                                    [
                                        'kelasId' => $kelas->id,
                                        'pjblId' => $pjbl->id
                                    ]
                                ) }}"
                                   class="btn btn-success">

                                    <i class="bi bi-plus-lg me-1"></i>
                                    Tambah Penilaian

                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</div>





<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('liveSearchSiswa');
    const resetButton = document.getElementById('resetSearch');
    const rows = document.querySelectorAll('.siswa-row');


    function filterSiswa() {

        const keyword = searchInput.value
            .toLowerCase()
            .trim();


        rows.forEach(function (row) {

            const searchData = row
                .getAttribute('data-search')
                .toLowerCase();


            row.style.display =
                searchData.includes(keyword)
                    ? ''
                    : 'none';

        });

    }


    searchInput.addEventListener(
        'input',
        filterSiswa
    );


    resetButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            rows.forEach(function (row) {
                row.style.display = '';
            });

            searchInput.focus();

        }
    );

});

</script>

@endsection
