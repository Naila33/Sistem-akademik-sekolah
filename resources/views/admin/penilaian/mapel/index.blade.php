@extends('layouts.app')

@section('title', 'Penilaian Mata Pelajaran')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Penilaian Mata Pelajaran
            </h3>

            <p class="text-muted mb-0">
                Data nilai harian dan ujian siswa
            </p>

        </div>


        <a href="{{ route('admin.penilaian.mapel.create') }}"
           class="btn btn-success">

            <i class="bi bi-plus-lg"></i>
            Tambah Penilaian

        </a>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- ================================================= --}}
    {{-- SEARCH & FILTER --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.penilaian.mapel.index') }}"
                  class="live-search-form">

                <div class="row g-3">

                    {{-- SEARCH --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Cari
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-search"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   class="form-control live-search-input"
                                   placeholder="Cari nama siswa atau tanggal (contoh: 31/08/2026 atau 2026-08-31)"
                                   value="{{ request('search') }}">

                        </div>

                        <small class="text-muted">
                            Bisa mencari berdasarkan nama siswa atau tanggal.
                        </small>

                    </div>


                    {{-- SISWA --}}
                    <div class="col-md-6">

                        <label class="form-label fw-semibold">
                            Nama Siswa
                        </label>

                        <select name="siswa_id"
                                class="form-select">

                            <option value="">
                                -- Semua Siswa --
                            </option>

                            @foreach($siswa as $s)

                                <option value="{{ $s->id }}"
                                    {{ request('siswa_id') == $s->id ? 'selected' : '' }}>

                                    {{ $s->nama }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- MAPEL --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Mata Pelajaran
                        </label>

                        <select name="mata_pelajaran_id"
                                class="form-select">

                            <option value="">
                                -- Semua Mata Pelajaran --
                            </option>

                            @foreach($mataPelajaran as $mapel)

                                <option value="{{ $mapel->id }}"
                                    {{ request('mata_pelajaran_id') == $mapel->id ? 'selected' : '' }}>

                                    {{ $mapel->nama_mapel }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    {{-- KELAS --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Kelas
                        </label>

                        <select name="kelas_id"
                                class="form-select">

                            <option value="">
                                -- Semua Kelas --
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


                    {{-- JENIS NILAI --}}
                    <div class="col-md-4">

                        <label class="form-label fw-semibold">
                            Jenis Nilai
                        </label>

                        <select name="jenis_nilai"
                                class="form-select">

                            <option value="">
                                -- Semua Jenis --
                            </option>

                            <option value="harian"
                                {{ request('jenis_nilai') == 'harian' ? 'selected' : '' }}>

                                Harian

                            </option>

                            <option value="ujian"
                                {{ request('jenis_nilai') == 'ujian' ? 'selected' : '' }}>

                                Ujian

                            </option>

                        </select>

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-12">

                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-success">

                                <i class="bi bi-funnel"></i>
                                Terapkan Filter

                            </button>


                            <a href="{{ route('admin.penilaian.mapel.index') }}"
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
                        const newResults = doc.querySelector('#mapel-search-results');
                        const currentResults = document.querySelector('#mapel-search-results');

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


    {{-- ================================================= --}}
    {{-- TABLE --}}
    {{-- ================================================= --}}

    <div class="card border-0 shadow-sm" id="mapel-search-results">

        <div class="card-body">

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
                                Mata Pelajaran
                            </th>

                            <th>
                                Kelas
                            </th>

                            <th>
                                Jenis Nilai
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

                    @forelse($penilaian as $item)

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

                            </td>


                            {{-- MAPEL --}}
                            <td>

                                {{ $item->jadwal?->mataPelajaran?->nama_mapel ?? '-' }}

                            </td>


                            {{-- KELAS --}}
                            <td>

                                @if($item->jadwal?->kelas)

                                    {{ $item->jadwal->kelas->tingkat }}
                                    {{ $item->jadwal->kelas->nama_kelas }}

                                @else

                                    -

                                @endif

                            </td>


                            {{-- JENIS NILAI --}}
                            <td>

                                @if($item->jenis_nilai === 'harian')

                                    <span class="badge bg-info">

                                        Harian

                                    </span>

                                @elseif($item->jenis_nilai === 'ujian')

                                    <span class="badge bg-warning text-dark">

                                        Ujian

                                    </span>

                                @endif

                            </td>


                            {{-- NILAI --}}
                            <td>

                                <strong>

                                    {{ $item->nilai }}

                                </strong>

                            </td>


                            {{-- TANGGAL --}}
                            <td>

                                {{ $item->created_at?->format('d/m/Y') ?? '-' }}

                            </td>


                            {{-- AKSI --}}
                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route('admin.penilaian.mapel.edit', $item->id) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>
                                        Edit

                                    </a>


                                    <form action="{{ route('admin.penilaian.mapel.destroy', $item->id) }}"
                                          method="POST"
                                          class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus nilai ini?')">

                                            <i class="bi bi-trash"></i>
                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>


                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                <div class="text-muted">

                                    <i class="bi bi-clipboard-x fs-1 d-block mb-2"></i>

                                    Belum ada data penilaian.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection