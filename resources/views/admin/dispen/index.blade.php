@extends('layouts.app')

@section('title', 'Dispensasi Siswa')

@push('styles')
    <style>
        body {
            background: #f5f6fa;
            color: #212529;
            font-family: 'Poppins', sans-serif;
        }

        .dispen-page {
            color: #1f2937;
        }

        .dispen-panel {
            background: #fff;
            border: 1px solid #e4eaf2;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(30, 64, 102, 0.05);
            padding: 24px;
        }

        .dispen-title {
            color: #1e293b;
            font-size: 24px;
            font-weight: 600;
        }

        .dispen-filter {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
        }

        .dispen-table th {
            background: #f1f5fb;
            color: #475569;
            font-size: 12px;
            text-transform: uppercase;
            white-space: nowrap;
        }

        .dispen-table td,
        .dispen-table th {
            border-bottom: 1px solid #e5e7eb;
            padding: 12px;
        }

        .dispen-table tbody tr:hover {
            background: #f8fbff;
        }

        .dispen-filter input:focus,
        .dispen-filter select:focus {
            border-color: #2449a4;
            box-shadow: 0 0 0 3px rgba(36, 73, 164, 0.12);
        }

        @media (max-width: 768px) {
            .dispen-panel {
                padding: 18px;
            }
        }
    </style>
@endpush

@section('content')

    <div class="container-fluid py-4 dispen-page">

        <div class="mb-4">

            <h3 class="dispen-title mb-1">
                Dispensasi Siswa
            </h3>

            <p class="text-muted mb-0">
                Monitoring pengajuan dispensasi siswa.
            </p>

        </div>




        <div class="dispen-panel dispen-filter mb-4">

            <div class="card-body">

                <div class="row g-3">

                    <div class="col-md-7">

                        <label class="form-label fw-semibold">
                            Cari Siswa
                        </label>

                        <input type="text" id="searchDispen" class="form-control" placeholder="Nama / NIS / NISN..."
                            value="{{ request('search') }}" autocomplete="off">

                    </div>


                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Status Kesiswaan
                        </label>

                        <select id="statusDispen" class="form-select">

                            <option value="">
                                Semua Status
                            </option>

                            <option value="pending" @selected(request('status_kesiswaan') === 'pending')>
                                Menunggu
                            </option>

                            <option value="diterima" @selected(request('status_kesiswaan') === 'diterima')>
                                Diterima
                            </option>

                            <option value="ditolak" @selected(request('status_kesiswaan') === 'ditolak')>
                                Ditolak
                            </option>

                        </select>

                    </div>

                </div>

            </div>

        </div>




        <div id="dispenContent">

            <div class="dispen-panel">

                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table table-hover align-middle mb-0 dispen-table">

                            <thead>

                                <tr>

                                    <th>No</th>
                                    <th>Siswa</th>
                                    <th>Periode</th>
                                    <th>Alasan</th>
                                    <th>Status Kesiswaan</th>
                                    <th>Aksi</th>

                                </tr>

                            </thead>


                            <tbody>

                                @forelse($dispen as $item)

                                                            <tr>

                                                                <td>
                                                                    {{ $dispen->firstItem() + $loop->index }}
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

                                                                    {{ $item->tanggal_mulai?->format('d-m-Y') ?? '-' }}

                                                                    -

                                                                    {{ $item->tanggal_selesai?->format('d-m-Y') ?? '-' }}

                                                                </td>


                                                                <td>

                                                                    {{ \Illuminate\Support\Str::limit(
                                        $item->alasan ?? '-',
                                        50
                                    ) }}

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


                                                                    <span class="badge text-bg-{{ $badge }}">

                                                                        {{ ucfirst($status) }}

                                                                    </span>

                                                                </td>


                                                                <td>

                                                                    <a href="{{ route(
                                        'admin.dispen.show',
                                        $item->id
                                    ) }}" class="btn btn-sm btn-outline-primary">

                                                                        <i class="bi bi-eye"></i>

                                                                        Detail

                                                                    </a>

                                                                </td>

                                                            </tr>

                                @empty

                                    <tr>

                                        <td colspan="6" class="text-center text-muted py-4">

                                            <i class="bi bi-inbox fs-3 d-block mb-2"></i>

                                            Belum ada pengajuan dispen.

                                        </td>

                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>


                    <div class="mt-3">

                        {{ $dispen->links() }}

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
                document.getElementById('searchDispen');

            const statusInput =
                document.getElementById('statusDispen');

            const resetButton =
                document.getElementById('resetDispen');

            const content =
                document.getElementById('dispenContent');

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
                        "{{ route('admin.dispen.index') }}";


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
                                '#dispenContent'
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