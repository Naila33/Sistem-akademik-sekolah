@extends('layouts.app')

@section('title', 'Pengajuan Sakit')

@section('content')

<div class="container-fluid py-4">

    
    
    

    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Pengajuan Sakit
        </h3>

        <p class="text-muted mb-0">
            Monitoring pengajuan sakit siswa.
        </p>

    </div>


    
    
    

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="row g-3">

                

                <div class="col-md-7">

                    <label class="form-label fw-semibold">
                        Cari Siswa
                    </label>

                    <input
                        type="text"
                        id="searchSakit"
                        class="form-control"
                        placeholder="Nama / NIS / NISN..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >

                </div>


                

                <div class="col-md-3">

                    <label class="form-label fw-semibold">
                        Status
                    </label>

                    <select
                        id="statusSakit"
                        class="form-select"
                    >

                        <option value="">
                            Semua
                        </option>

                        <option
                            value="pending"
                            @selected(request('status') === 'pending')
                        >
                            Menunggu
                        </option>

                        <option
                            value="diterima"
                            @selected(request('status') === 'diterima')
                        >
                            Diterima
                        </option>

                        <option
                            value="ditolak"
                            @selected(request('status') === 'ditolak')
                        >
                            Ditolak
                        </option>

                    </select>

                </div>


            </div>

        </div>

    </div>


    
    
    

    <div id="sakitContent">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead>

                            <tr>

                                <th>No</th>

                                <th>Siswa</th>

                                <th>Tanggal</th>

                                <th>Wali Kelas</th>

                                <th>Guru Mapel</th>

                                <th>Status</th>

                                <th>Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                        @forelse($sakit as $item)

                            <tr>

                                

                                <td>

                                    {{ $sakit->firstItem() + $loop->index }}

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

                                    @php

                                        $statusWali =
                                            $item->status_wali_kelas
                                            ?? 'pending';

                                        $badgeWali =
                                            $statusWali === 'diterima'
                                                ? 'success'
                                                : (
                                                    $statusWali === 'ditolak'
                                                        ? 'danger'
                                                        : 'warning'
                                                );

                                    @endphp


                                    <span
                                        class="badge text-bg-{{ $badgeWali }}"
                                    >

                                        {{ ucfirst($statusWali) }}

                                    </span>

                                </td>


                                

                                <td>

                                    @php

                                        $totalGuru =
                                            $item->guru->count();

                                        $diterimaGuru =
                                            $item->guru
                                                ->where(
                                                    'status',
                                                    'diterima'
                                                )
                                                ->count();

                                    @endphp


                                    @if($totalGuru > 0)

                                        <span class="fw-semibold">

                                            {{ $diterimaGuru }}
                                            /
                                            {{ $totalGuru }}

                                        </span>

                                        <small class="text-muted">
                                            guru
                                        </small>

                                    @else

                                        <span class="text-muted">
                                            Belum ada
                                        </span>

                                    @endif

                                </td>


                                

                                <td>

                                    @php

                                        $status =
                                            $item->status
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

                                    <a
                                        href="{{ route(
                                            'admin.sakit.show',
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

                                    Belum ada pengajuan sakit.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>


                

                <div class="mt-3">

                    {{ $sakit->links() }}

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
        document.getElementById('searchSakit');

    const statusInput =
        document.getElementById('statusSakit');

    const resetButton =
        document.getElementById('resetSakit');

    const content =
        document.getElementById('sakitContent');

    let timer = null;


    

    function loadSakit(url = null) {

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
                    'status',
                    status
                );

            }


            url =
                "{{ route('admin.sakit.index') }}";


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
                    '#sakitContent'
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
                function () {

                    loadSakit();

                },
                300
            );

        }
    );


    

    statusInput.addEventListener(
        'change',
        function () {

            loadSakit();

        }
    );


    

    resetButton.addEventListener(
        'click',
        function () {

            searchInput.value = '';

            statusInput.value = '';

            loadSakit();

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


            loadSakit(link.href);

        }
    );

});

</script>

@endpush