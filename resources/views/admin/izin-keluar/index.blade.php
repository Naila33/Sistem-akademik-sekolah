@extends('layouts.app')

@section('title', 'Izin Keluar')

@push('styles')
<style>
    body {
        background-color: #f8fafc;
        font-family: 'Poppins', sans-serif;
    }

    .academic-container {
        padding: 24px 16px;
    }

    .page-header {
        margin-bottom: 24px;
    }

    .page-header h3 {
        margin: 0 0 4px;
        color: #0f172a;
        font-size: 22px;
        font-weight: 700;
    }

    .page-header p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
    }

    .filter-card {
        margin-bottom: 24px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .filter-card .card-body {
        padding: 22px;
    }

    .form-label-custom {
        display: block;
        margin-bottom: 7px;
        color: #334155;
        font-size: 13px;
        font-weight: 600;
    }

    .custom-input,
    .custom-select {
        width: 100%;
        min-height: 42px;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 7px;
        background-color: #ffffff;
        color: #1e293b;
        font-size: 13px;
        outline: none;
        transition: all 0.2s ease;
    }

    .custom-input::placeholder {
        color: #94a3b8;
    }

    .custom-input:focus,
    .custom-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }

    .data-card {
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .data-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .data-card-icon {
        width: 34px;
        height: 34px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 16px;
    }

    .data-card-title {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .custom-table {
        width: 100%;
        min-width: 1050px;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .custom-table thead th {
        padding: 13px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        white-space: nowrap;
        vertical-align: middle;
    }

    .custom-table tbody td {
        padding: 14px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
        vertical-align: middle;
    }

    .custom-table tbody tr:last-child td {
        border-bottom: none;
    }

    .custom-table tbody tr {
        transition: background-color 0.2s ease;
    }

    .custom-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .number-cell {
        width: 60px;
        color: #64748b;
        font-weight: 600;
        text-align: center;
    }

    .student-name {
        color: #0f172a;
        font-weight: 600;
    }

    .student-nis {
        display: block;
        margin-top: 3px;
        color: #94a3b8;
        font-size: 11px;
    }

    .date-cell {
        color: #475569;
        white-space: nowrap;
        font-weight: 500;
    }

    .time-cell {
        color: #475569;
        white-space: nowrap;
        font-weight: 500;
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-width: 78px;
        padding: 6px 11px;
        border-radius: 6px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .status-success {
        background: #dcfce7;
        color: #166534;
    }

    .status-warning {
        background: #fef3c7;
        color: #92400e;
    }

    .status-danger {
        background: #fee2e2;
        color: #b91c1c;
    }

    .status-info {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .status-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 5px;
        padding: 7px 12px;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
        white-space: nowrap;
    }

    .action-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .empty-state {
        padding: 55px 20px !important;
        text-align: center;
    }

    .empty-state-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #f1f5f9;
        color: #94a3b8;
        font-size: 22px;
    }

    .empty-state-title {
        margin-bottom: 4px;
        color: #475569;
        font-size: 14px;
        font-weight: 600;
    }

    .empty-state-text {
        margin: 0;
        color: #94a3b8;
        font-size: 12px;
    }

    .pagination-wrapper {
        padding: 18px 22px;
        border-top: 1px solid #f1f5f9;
    }

    .pagination-wrapper .pagination {
        margin: 0;
    }

    .pagination-wrapper .page-link {
        margin: 0 2px;
        border-color: #e2e8f0;
        border-radius: 6px;
        color: #475569;
        font-size: 12px;
    }

    .pagination-wrapper .page-item.active .page-link {
        background-color: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .pagination-wrapper .page-link:hover {
        background-color: #eff6ff;
        border-color: #bfdbfe;
        color: #2563eb;
    }

    #izinKeluarContent {
        transition: opacity 0.2s ease;
    }

    @media (max-width: 768px) {
        .academic-container {
            padding: 18px 10px;
        }

        .page-header h3 {
            font-size: 20px;
        }

        .filter-card .card-body {
            padding: 16px;
        }

        .data-card-header {
            padding: 16px;
        }

        .pagination-wrapper {
            padding: 15px;
        }
    }
</style>
@endpush

@section('content')

<div class="academic-container">

    <div class="page-header">
        <h3>Izin Keluar</h3>
        <p>Monitoring izin keluar siswa.</p>
    </div>

    <div class="filter-card">

        <div class="card-body">

            <div class="row g-3">

                <div class="col-md-7">

                    <label
                        for="searchIzinKeluar"
                        class="form-label-custom"
                    >
                        Cari Siswa
                    </label>

                    <input
                        type="text"
                        id="searchIzinKeluar"
                        class="custom-input"
                        placeholder="Nama / NIS / NISN..."
                        value="{{ request('search') }}"
                        autocomplete="off"
                    >

                </div>

                <div class="col-md-3">

                    <label
                        for="statusIzinKeluar"
                        class="form-label-custom"
                    >
                        Status Kesiswaan
                    </label>

                    <select
                        id="statusIzinKeluar"
                        class="custom-select"
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

    <div id="izinKeluarContent">

        <div class="data-card">

            <div class="data-card-header">

                <div class="data-card-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>

                <h5 class="data-card-title">
                    Data Izin Keluar
                </h5>

            </div>

            <div class="table-wrapper">

                <table class="custom-table">

                    <thead>

                        <tr>
                            <th class="text-center">No</th>
                            <th>Siswa</th>
                            <th>Tanggal</th>
                            <th>Jam Keluar</th>
                            <th>Kesiswaan</th>
                            <th>Guru Mapel</th>
                            <th class="text-center">Aksi</th>
                        </tr>

                    </thead>

                    <tbody>

                    @forelse($izinKeluar as $item)

                        @php
                            $statusKesiswaan = $item->status_kesiswaan ?? 'pending';

                            $badgeKesiswaan = match($statusKesiswaan) {
                                'diterima' => 'status-success',
                                'ditolak' => 'status-danger',
                                default => 'status-warning'
                            };

                            $statusGuru = $item->status_guru_mapel ?? 'pending';

                            $badgeGuru = match($statusGuru) {
                                'diterima' => 'status-success',
                                'ditolak' => 'status-danger',
                                default => 'status-warning'
                            };
                        @endphp

                        <tr>

                            <td class="number-cell">
                                {{ $izinKeluar->firstItem() + $loop->index }}
                            </td>

                            <td>

                                <div class="student-name">
                                    {{ $item->siswa->nama ?? '-' }}
                                </div>

                                <span class="student-nis">
                                    NIS: {{ $item->siswa->nis ?? '-' }}
                                </span>

                            </td>

                            <td class="date-cell">
                                {{ $item->tanggal?->format('d-m-Y') ?? '-' }}
                            </td>

                            <td class="time-cell">

                                {{ $item->jam_mulai ?? '-' }}

                                <span class="text-muted mx-1">
                                    -
                                </span>

                                {{ $item->jam_selesai ?? '-' }}

                            </td>

                            <td>

                                <span class="status-badge {{ $badgeKesiswaan }}">
                                    {{ ucfirst($statusKesiswaan) }}
                                </span>

                            </td>

                            <td>

                                <span class="status-badge {{ $badgeGuru }}">
                                    {{ ucfirst($statusGuru) }}
                                </span>

                            </td>

                            <td class="text-center">

                                <a
                                    href="{{ route(
                                        'admin.izin-keluar.show',
                                        $item->id
                                    ) }}"
                                    class="action-btn"
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
                                class="empty-state"
                            >

                                <div class="empty-state-icon">
                                    <i class="bi bi-inbox"></i>
                                </div>

                                <div class="empty-state-title">
                                    Belum ada izin keluar
                                </div>

                                <p class="empty-state-text">
                                    Data izin keluar belum tersedia atau tidak sesuai dengan filter.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

            <div class="pagination-wrapper">

                {{ $izinKeluar->links() }}

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')

<script>
document.addEventListener('DOMContentLoaded', function () {

    const searchInput =
        document.getElementById('searchIzinKeluar');

    const statusInput =
        document.getElementById('statusIzinKeluar');

    const content =
        document.getElementById('izinKeluarContent');

    let timer = null;

    function loadData(url = null) {

        if (!url) {

            const params = new URLSearchParams();

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
                "{{ route('admin.izin-keluar.index') }}";

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
                    '#izinKeluarContent'
                );

            if (newContent) {

                content.innerHTML =
                    newContent.innerHTML;

            }

            content.style.opacity = '1';

            window.history.replaceState(
                {},
                '',
                url
            );

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
                    loadData();
                },
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