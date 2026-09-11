@extends('layouts.app')

@section('title', 'Absensi')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold mb-1">Absensi</h3>
        <p class="text-muted mb-0">
            Rekap kehadiran siswa.
        </p>
    </div>

    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-6">
                    <label class="form-label fw-semibold">
                        Cari Siswa
                    </label>

                    <input
                        type="text"
                        id="searchAbsensi"
                        class="form-control"
                        placeholder="Nama / NIS / NISN..."
                    >
                </div>

                <div class="col-md-4">
                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select
                        id="statusAbsensi"
                        class="form-select"
                    >
                        <option value="">Semua Status</option>
                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpha">Alpha</option>
                        <option value="Terlambat">Terlambat</option>
                    </select>
                </div>

            </div>

        </div>
    </div>


    {{-- AREA TABEL --}}
    <div id="absensiContent">

        <div class="card border-0 shadow-sm">
            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Siswa</th>
                                <th>Tanggal</th>
                                <th>Mata Pelajaran</th>
                                <th>Guru</th>
                                <th>Waktu Absen</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>

                            @forelse($absensi as $item)

                                <tr>

                                    <td>
                                        {{ $absensi->firstItem() + $loop->index }}
                                    </td>

                                    <td>
                                        <div class="fw-semibold">
                                            {{ $item->siswa->nama ?? '-' }}
                                        </div>
                                    </td>

                                    <td>
                                        {{ $item->sesi->tanggal ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->sesi->jadwal->mataPelajaran->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->sesi->jadwal->guru->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->waktu_absen ?? '-' }}
                                    </td>

                                    <td>

                                        @php
                                            $badge = match($item->status) {
                                                'Hadir' => 'success',
                                                'Izin' => 'warning',
                                                'Sakit' => 'info',
                                                'Alpha' => 'danger',
                                                'Terlambat' => 'secondary',
                                                default => 'secondary'
                                            };
                                        @endphp

                                        <span class="badge bg-{{ $badge }}">
                                            {{ $item->status ?? '-' }}
                                        </span>

                                    </td>

                                    <td>
                                        <a
                                            href="{{ route(
                                                'admin.absensi.show',
                                                $item->id
                                            ) }}"
                                            class="btn btn-sm btn-primary"
                                        >
                                            <i class="bi bi-eye"></i>
                                            Detail
                                        </a>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td
                                        colspan="8"
                                        class="text-center text-muted py-4"
                                    >
                                        Tidak ada data absensi.
                                    </td>
                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- PAGINATION --}}
                <div class="mt-3" id="absensiPagination">
                    {{ $absensi->links() }}
                </div>

            </div>
        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput = document.getElementById('searchAbsensi');
    const statusInput = document.getElementById('statusAbsensi');
    const resetButton = document.getElementById('resetAbsensi');

    let timer = null;

    function loadAbsensi(url = null) {

        const search = searchInput.value.trim();
        const status = statusInput.value;

        let requestUrl = url;

        if (!requestUrl) {

            const params = new URLSearchParams();

            if (search !== '') {
                params.append('search', search);
            }

            if (status !== '') {
                params.append('status', status);
            }

            requestUrl =
                "{{ route('admin.absensi.index') }}" +
                '?' +
                params.toString();
        }

        fetch(requestUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {

            const parser = new DOMParser();
            const doc = parser.parseFromString(
                html,
                'text/html'
            );

            const newContent =
                doc.querySelector('#absensiContent');

            if (newContent) {
                document.querySelector(
                    '#absensiContent'
                ).innerHTML = newContent.innerHTML;
            }

        })
        .catch(error => {
            console.error(
                'Gagal mengambil data absensi:',
                error
            );
        });
    }


    // LIVE SEARCH
    searchInput.addEventListener('input', function () {

        clearTimeout(timer);

        timer = setTimeout(function () {
            loadAbsensi();
        }, 300);

    });


    // FILTER STATUS
    statusInput.addEventListener('change', function () {
        loadAbsensi();
    });


    // RESET
    resetButton.addEventListener('click', function () {

        searchInput.value = '';
        statusInput.value = '';

        loadAbsensi();

    });


    // PAGINATION AJAX
    document.addEventListener('click', function (event) {

        const link = event.target.closest(
            '#absensiContent .pagination a'
        );

        if (!link) {
            return;
        }

        event.preventDefault();

        loadAbsensi(link.href);

    });

});
</script>

@endpush