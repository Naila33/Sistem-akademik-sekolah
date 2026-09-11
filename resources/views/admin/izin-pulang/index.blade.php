@extends('layouts.app')

@section('title', 'Izin Pulang')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Izin Pulang
        </h3>

        <p class="text-muted mb-0">
            Monitoring izin pulang siswa.
        </p>

    </div>


    {{-- FILTER --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-7">

                    <label class="form-label fw-semibold">
                        Cari Siswa
                    </label>

                    <input
                        type="text"
                        id="searchIzinPulang"
                        class="form-control"
                        placeholder="Nama / NIS / NISN..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >

                </div>


                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Status Kesiswaan
                    </label>

                    <select
                        id="statusIzinPulang"
                        class="form-select"
                    >

                        <option value="">
                            Semua Status
                        </option>

                        <option
                            value="pending"
                            @selected(request('status_kesiswaan') === 'pending')
                        >
                            Menunggu
                        </option>

                        <option
                            value="diterima"
                            @selected(request('status_kesiswaan') === 'diterima')
                        >
                            Diterima
                        </option>

                        <option
                            value="ditolak"
                            @selected(request('status_kesiswaan') === 'ditolak')
                        >
                            Ditolak
                        </option>

                    </select>

                </div>


            </div>

        </div>

    </div>


    {{-- DATA --}}

    <div id="izinPulangContent">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>No</th>
                                <th>Siswa</th>
                                <th>Tanggal</th>
                                <th>Jam Pulang</th>
                                <th>Kesiswaan</th>
                                <th>Guru Mapel</th>
                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($izinPulang as $item)

                            <tr>

                                <td>
                                    {{ $izinPulang->firstItem() + $loop->index }}
                                </td>


                                <td>

                                    <strong>
                                        {{ $item->siswa->nama ?? '-' }}
                                    </strong>

                                    <br>

                                    <small class="text-muted">

                                        NIS:
                                        {{ $item->siswa->nis ?? '-' }}

                                    </small>

                                </td>


                                <td>

                                    {{ $item->tanggal?->format('d-m-Y') ?? '-' }}

                                </td>


                                <td>

                                    {{ $item->jam_mulai ?? '-' }}

                                    -

                                    {{ $item->jam_selesai ?? '-' }}

                                </td>


                                <td>

                                    @php
                                        $status =
                                            $item->status_kesiswaan
                                            ?? 'pending';

                                        $badge =
                                            $status === 'diterima'
                                                ? 'success'
                                                : (
                                                    $status === 'ditolak'
                                                        ? 'danger'
                                                        : 'warning'
                                                );
                                    @endphp

                                    <span
                                        class="badge text-bg-{{ $badge }}"
                                    >

                                        {{ ucfirst($status) }}

                                    </span>

                                </td>


                                <td>

                                    @php
                                        $statusGuru =
                                            $item->status_guru_mapel
                                            ?? 'pending';

                                        $badgeGuru =
                                            $statusGuru === 'diterima'
                                                ? 'success'
                                                : (
                                                    $statusGuru === 'ditolak'
                                                        ? 'danger'
                                                        : 'warning'
                                                );
                                    @endphp

                                    <span
                                        class="badge text-bg-{{ $badgeGuru }}"
                                    >

                                        {{ ucfirst($statusGuru) }}

                                    </span>

                                </td>


                                <td>

                                    <a
                                        href="{{ route(
                                            'admin.izin-pulang.show',
                                            $item->id
                                        ) }}"
                                        class="btn btn-sm btn-outline-primary"
                                    >

                                        <i class="bi bi-eye"></i>

                                        Detail

                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="7"
                                    class="text-center text-muted py-4"
                                >

                                    <i
                                        class="bi bi-inbox fs-3 d-block mb-2"
                                    ></i>

                                    Belum ada izin pulang.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                <div class="mt-3">

                    {{ $izinPulang->links() }}

                </div>

            </div>

        </div>

    </div>

</div>

@endsection


@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('searchIzinPulang');

    const statusInput =
        document.getElementById('statusIzinPulang');

    const resetButton =
        document.getElementById('resetIzinPulang');

    const content =
        document.getElementById('izinPulangContent');

    let timer = null;


    function loadData(url = null) {

        if (!url) {

            const params =
                new URLSearchParams();

            const search =
                searchInput.value.trim();

            const status =
                statusInput.value;


            if (search !== '') {

                params.append(
                    'search',
                    search
                );

            }


            if (status !== '') {

                params.append(
                    'status_kesiswaan',
                    status
                );

            }


            url =
                "{{ route('admin.izin-pulang.index') }}";


            if (params.toString() !== '') {

                url +=
                    '?' +
                    params.toString();

            }

        }


        content.style.opacity = '0.5';


        fetch(url, {

            headers: {

                'X-Requested-With':
                    'XMLHttpRequest',

                'Accept':
                    'text/html'

            }

        })

        .then(response => {

            if (!response.ok) {

                throw new Error(
                    'Gagal mengambil data.'
                );

            }

            return response.text();

        })

        .then(html => {

            const doc =
                new DOMParser()
                    .parseFromString(
                        html,
                        'text/html'
                    );


            const newContent =
                doc.querySelector(
                    '#izinPulangContent'
                );


            if (newContent) {

                content.innerHTML =
                    newContent.innerHTML;

            }


            content.style.opacity = '1';

        })

        .catch(error => {

            console.error(error);

            content.style.opacity = '1';

        });

    }


    searchInput.addEventListener(
        'input',
        function () {

            clearTimeout(timer);

            timer = setTimeout(
                () => loadData(),
                300
            );

        }
    );


    statusInput.addEventListener(
        'change',
        function () {

            loadData();

        }
    );


    resetButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            statusInput.value = '';

            loadData();

        }
    );


    content.addEventListener(
        'click',
        function (event) {

            const link =
                event.target.closest(
                    '.pagination a'
                );


            if (!link) {
                return;
            }


            event.preventDefault();

            loadData(link.href);

        }
    );

});

</script>

@endpush