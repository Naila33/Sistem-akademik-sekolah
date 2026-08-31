@extends('layouts.app')

@section('title', 'Data Calon Siswa')

@section('content')

<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h4 class="fw-bold mb-1">
                Data Calon Siswa
            </h4>

            <p class="text-muted mb-0">
                Pengelolaan data calon siswa SPMB berdasarkan jurusan
            </p>
        </div>

        <a href="{{ route('admin.spmb.create') }}"
           class="btn btn-primary">
            + Tambah Calon Siswa
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

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            {{ session('error') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>
        </div>
    @endif


    {{-- FILTER --}}
    <div class="card shadow-sm border-0 mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route('admin.spmb.index') }}"
                  class="live-search-form">

                <div class="row g-3">

                    <div class="col-md-4">

                        <label class="form-label">
                            Pencarian
                        </label>

                        <input
                            type="text"
                            name="search"
                            class="form-control live-search-input"
                            placeholder="Nama, NISN, NIK, No. Pendaftaran"
                            value="{{ request('search') }}"
                        >

                    </div>


                    <div class="col-md-3">

                        <label class="form-label">
                            Jurusan
                        </label>

                        <select name="jurusan_id"
                                class="form-select">

                            <option value="">
                                Semua Jurusan
                            </option>

                            @foreach($jurusan as $item)

                                <option
                                    value="{{ $item->id }}"
                                    @selected(request('jurusan_id') == $item->id)
                                >
                                    {{ $item->kode_jurusan }}
                                    -
                                    {{ $item->nama_jurusan }}
                                </option>

                            @endforeach

                        </select>

                    </div>


                    <div class="col-md-2">

                        <label class="form-label">
                            Jalur
                        </label>

                        <select name="jalur_pendaftaran"
                                class="form-select">

                            <option value="">
                                Semua
                            </option>

                            <option value="Domisili"
                                @selected(request('jalur_pendaftaran') == 'Domisili')}>
                                Domisili
                            </option>

                            <option value="Prestasi"
                                @selected(request('jalur_pendaftaran') == 'Prestasi')}>
                                Prestasi
                            </option>

                            <option value="Afirmasi"
                                @selected(request('jalur_pendaftaran') == 'Afirmasi')}>
                                Afirmasi
                            </option>

                            <option value="Mutasi"
                                @selected(request('jalur_pendaftaran') == 'Mutasi')}>
                                Mutasi
                            </option>

                        </select>

                    </div>


                    <div class="col-md-2">

                        <label class="form-label">
                            Status
                        </label>

                        <select
                            name="status_daftar_ulang"
                            class="form-select">

                            <option value="">
                                Semua
                            </option>

                            <option value="belum_daftar_ulang"
                                @selected(request('status_daftar_ulang') == 'belum_daftar_ulang')}>
                                Belum Daftar Ulang
                            </option>

                            <option value="menunggu_verifikasi"
                                @selected(request('status_daftar_ulang') == 'menunggu_verifikasi')}>
                                Menunggu Verifikasi
                            </option>

                            <option value="revisi"
                                @selected(request('status_daftar_ulang') == 'revisi')}>
                                Revisi
                            </option>

                            <option value="terverifikasi"
                                @selected(request('status_daftar_ulang') == 'terverifikasi')}>
                                Terverifikasi
                            </option>

                        </select>

                    </div>


                    <div class="col-md-1 d-flex align-items-end">

                        <button class="btn btn-dark w-100">
                            Cari
                        </button>

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
                        const newResults = doc.querySelector('#spmb-search-results');
                        const currentResults = document.querySelector('#spmb-search-results');

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


    {{-- TABLE --}}
    <div class="card shadow-sm border-0" id="spmb-search-results">

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover align-middle mb-0">

                    <thead class="table-light">

                        <tr>

                            <th width="50">
                                No
                            </th>

                            <th>
                                No. Pendaftaran
                            </th>

                            <th>
                                Nama Calon Siswa
                            </th>

                            <th>
                                NISN
                            </th>

                            <th>
                                Jurusan
                            </th>

                            <th>
                                Jalur
                            </th>

                            <th>
                                Status
                            </th>

                            <th width="150">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    <tbody>

                    @forelse($calonSiswa as $index => $item)

                        <tr>

                            <td>
                                {{ $calonSiswa->firstItem() + $index }}
                            </td>

                            <td>
                                <span class="fw-semibold">
                                    {{ $item->no_pendaftaran }}
                                </span>
                            </td>

                            <td>
                                {{ $item->nama_lengkap }}
                            </td>

                            <td>
                                {{ $item->nisn ?? '-' }}
                            </td>

                            <td>

                                @if($item->jurusan)

                                    <span class="badge text-bg-primary">
                                        {{ $item->jurusan->kode_jurusan }}
                                    </span>

                                    <div class="small text-muted">
                                        {{ $item->jurusan->nama_jurusan }}
                                    </div>

                                @else

                                    <span class="text-muted">
                                        Jurusan tidak tersedia
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ $item->jalur_pendaftaran }}
                            </td>

                            <td>

                                @if($item->status_daftar_ulang === 'terverifikasi')

                                    <span class="badge text-bg-success">
                                        Terverifikasi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'revisi')

                                    <span class="badge text-bg-danger">
                                        Revisi
                                    </span>

                                @elseif($item->status_daftar_ulang === 'menunggu_verifikasi')

                                    <span class="badge text-bg-warning">
                                        Menunggu Verifikasi
                                    </span>

                                @else

                                    <span class="badge text-bg-secondary">
                                        Belum Daftar Ulang
                                    </span>

                                @endif

                            </td>

                            <td>

                                <div class="d-flex gap-1">

                                    <a
                                        href="{{ route('admin.spmb.show', $item->id) }}"
                                        class="btn btn-sm btn-info text-white"
                                    >
                                        Detail
                                    </a>

                                    <a
                                        href="{{ route('admin.spmb.edit', $item->id) }}"
                                        class="btn btn-sm btn-warning"
                                    >
                                        Edit
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="8"
                                class="text-center py-5">

                                <div class="text-muted">

                                    Belum ada data calon siswa.

                                </div>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        @if($calonSiswa->hasPages())

            <div class="card-footer bg-white">

                {{ $calonSiswa->links() }}

            </div>

        @endif

    </div>

</div>

@endsection