@extends('layouts.app')

@section('title', 'Penilaian PJBL')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="fw-bold mb-1">
                Penilaian PJBL
            </h3>

            <p class="text-muted mb-0">
                Data penilaian Project Based Learning siswa
            </p>
        </div>

        <a href="{{ route('admin.penilaian.pjbl.create') }}"
           class="btn btn-success">

            <i class="bi bi-plus-lg"></i>
            Tambah Penilaian

        </a>

    </div>


    {{-- ALERT --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- SEARCH & FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.penilaian.pjbl.index') }}"
                  class="live-search-form">

                <div class="row g-3 align-items-end">

                    {{-- SEARCH --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Cari Siswa
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control live-search-input"
                                   placeholder="Cari nama siswa..."
                                   value="{{ request('search') }}">

                        </div>

                    </div>


                    {{-- FILTER KELAS --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Filter Kelas
                        </label>

                        <select name="kelas_id"
                                class="form-select">

                            <option value="">
                                Semua Kelas
                            </option>

                            @foreach($kelas as $k)

                                <option value="{{ $k->id }}"
                                    {{ request('kelas_id') == $k->id ? 'selected' : '' }}>

                                    {{ $k->tingkat }}
                                    {{ $k->nama_kelas }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-3">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-funnel"></i>
                                Filter

                            </button>

                            <a href="{{ route('admin.penilaian.pjbl.index') }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-counterclockwise"></i>
                                Reset

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            document.querySelectorAll('.live-search-form').forEach(function (form) {
                const input = form.querySelector('.live-search-input');
                if (!input) return;

                let timeout;

                function submitLiveSearch() {
                    const formData = new FormData(form);
                    const params = new URLSearchParams(formData).toString();
                    const action = form.getAttribute('action') || window.location.href;
                    const url = params ? action + '?' + params : action;

                    fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    })
                    .then(function (response) {
                        return response.text();
                    })
                    .then(function (html) {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newResults = doc.querySelector('#pjbl-search-results');
                        const currentResults = document.querySelector('#pjbl-search-results');

                        if (newResults && currentResults) {
                            currentResults.innerHTML = newResults.innerHTML;
                        }

                        history.replaceState(null, '', url);
                    })
                    .catch(function () {
                        form.submit();
                    });
                }

                input.addEventListener('input', function () {
                    clearTimeout(timeout);
                    timeout = setTimeout(function () {
                        submitLiveSearch();
                    }, 400);
                });

                form.addEventListener('submit', function (event) {
                    event.preventDefault();
                    submitLiveSearch();
                });
            });
        });
    </script>


    {{-- DATA PER KELAS --}}

    @forelse($penilaianPerKelas as $kelasId => $dataKelas)

        @php
            $kelasData = $dataKelas->first()->pjbl?->kelas;
            $pjblData = $dataKelas->first()->pjbl;
        @endphp


        {{-- CARD KELAS --}}
        <div class="card border-0 shadow-sm mb-4" id="pjbl-search-results">

            {{-- HEADER KELAS --}}
            <div class="card-header bg-white border-0 py-3">

                <div class="d-flex justify-content-between align-items-center">

                    <div>

                        <h5 class="fw-bold mb-1">

                            <i class="bi bi-mortarboard-fill text-success me-2"></i>

                            Kelas
                            {{ $kelasData?->tingkat ?? '-' }}
                            {{ $kelasData?->nama_kelas ?? '-' }}

                        </h5>

                        <small class="text-muted">

                            {{ $dataKelas->count() }}
                            data penilaian

                        </small>

                    </div>


                    @if($pjblData)

                        <span class="badge bg-success">

                            {{ ucfirst(str_replace('_', ' ', $pjblData->periode)) }}

                        </span>

                    @endif

                </div>

            </div>


            <div class="card-body">


                {{-- ============================= --}}
                {{-- 5 PENGUJI PJBL --}}
                {{-- ============================= --}}

                <h6 class="fw-bold mb-3">

                    <i class="bi bi-people-fill me-2"></i>

                    Penguji PJBL

                </h6>


                <div class="table-responsive mb-4">

                    <table class="table table-bordered align-middle">

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

                            @php
                                $pengujiKelas = $dataKelas
                                    ->map(fn($item) => $item->pjbl)
                                    ->filter()
                                    ->flatMap(fn($pjbl) => $pjbl->penguji()->with('guru')->get())
                                    ->unique('id')
                                    ->values();
                            @endphp


                            @forelse($pengujiKelas->take(5) as $penguji)

                                <tr>

                                    <td>
                                        {{ $loop->iteration }}
                                    </td>

                                    <td class="fw-semibold">

                                        {{ $penguji->guru?->nama ?? '-' }}

                                    </td>

                                    <td>

                                        {{ $penguji->guru?->nip ?? '-' }}

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="3"
                                        class="text-center text-muted py-3">

                                        Belum ada data penguji PJBL.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- ============================= --}}
                {{-- TABEL PENILAIAN --}}
                {{-- ============================= --}}

                <h6 class="fw-bold mb-3">

                    <i class="bi bi-clipboard-data me-2"></i>

                    Data Penilaian

                </h6>


                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead>

                            <tr>

                                <th width="60">
                                    No
                                </th>

                                <th>
                                    Siswa
                                </th>

                                <th>
                                    PJBL
                                </th>


                                <th>
                                    Nilai
                                </th>

                                <th>
                                    Tanggal
                                </th>

                                <th width="160">
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @foreach($dataKelas as $item)

                                <tr>

                                    {{-- NO --}}
                                    <td>
                                        {{ $loop->iteration }}
                                    </td>


                                    {{-- SISWA --}}
                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->siswa?->nama ?? '-' }}

                                        </div>

                                        <small class="text-muted">

                                            NIS:
                                            {{ $item->siswa?->nis ?? '-' }}

                                        </small>

                                    </td>


                                    {{-- PJBL --}}
                                    <td>

                                        <span class="badge bg-light text-dark border">

                                            PJBL #{{ $item->pjbl?->id ?? '-' }}

                                        </span>

                                    </td>



                                    {{-- NILAI --}}
                                    <td>

                                        <span class="fw-bold">

                                            {{ $item->nilai }}

                                        </span>

                                    </td>


                                    {{-- TANGGAL --}}
                                    <td>

                                        {{ $item->created_at?->format('d/m/Y') ?? '-' }}

                                    </td>


                                    {{-- AKSI --}}
                                    <td>

                                        <div class="d-flex gap-1">

                                            <a href="{{ route('admin.penilaian.pjbl.edit', $item->id) }}"
                                               class="btn btn-sm btn-warning">

                                                <i class="bi bi-pencil"></i>
                                                Edit

                                            </a>


                                            <form action="{{ route('admin.penilaian.pjbl.destroy', $item->id) }}"
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

                                        </div>

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            </div>

        </div>


    @empty


        {{-- DATA KOSONG --}}

        <div class="card border-0 shadow-sm">

            <div class="card-body text-center py-5">

                <i class="bi bi-clipboard-x fs-1 text-muted"></i>

                <h5 class="mt-3">
                    Belum ada data penilaian PJBL
                </h5>

                <p class="text-muted">
                    Data penilaian akan muncul setelah guru memasukkan nilai.
                </p>

                <a href="{{ route('admin.penilaian.pjbl.create') }}"
                   class="btn btn-success">

                    <i class="bi bi-plus-lg"></i>
                    Tambah Penilaian

                </a>

            </div>

        </div>

    @endforelse


</div>

@endsection