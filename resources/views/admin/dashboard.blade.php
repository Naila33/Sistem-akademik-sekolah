@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')

@php
    \Carbon\Carbon::setLocale('id');
@endphp

<div class="dashboard">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="dashboard-header">

        <div>
            <h1>Dashboard</h1>

            <p>
                Selamat datang di Sistem Akademik Sekolah.
                Pantau aktivitas dan data sekolah dari halaman ini.
            </p>
        </div>

        <div class="date-box">

            <i class="bi bi-calendar3"></i>

            {{ now()->translatedFormat('l, d F Y') }}

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- STATISTIK DATA UTAMA --}}
    {{-- ========================================================= --}}

    <div class="stats-grid">

        {{-- SISWA --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-people"></i>
            </div>

            <div class="stat-content">

                <span>Total Siswa</span>

                <h2>
                    {{ number_format($totalSiswa) }}
                </h2>

                <small>
                    Data siswa terdaftar
                </small>

            </div>

        </div>


        {{-- GURU --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-person-badge"></i>
            </div>

            <div class="stat-content">

                <span>Total Guru</span>

                <h2>
                    {{ number_format($totalGuru) }}
                </h2>

                <small>
                    Data guru terdaftar
                </small>

            </div>

        </div>


        {{-- KELAS --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-building"></i>
            </div>

            <div class="stat-content">

                <span>Total Kelas</span>

                <h2>
                    {{ number_format($totalKelas) }}
                </h2>

                <small>
                    Kelas tersedia
                </small>

            </div>

        </div>


        {{-- MAPEL --}}
        <div class="stat-card">

            <div class="stat-icon">
                <i class="bi bi-book"></i>
            </div>

            <div class="stat-content">

                <span>Mata Pelajaran</span>

                <h2>
                    {{ number_format($totalMapel) }}
                </h2>

                <small>
                    Mata pelajaran tersedia
                </small>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- PRESENSI HARI INI --}}
    {{-- ========================================================= --}}

    <div class="section-title">

        <div>

            <h2>Presensi Hari Ini</h2>

            <p>
                Ringkasan kehadiran siswa pada
                {{ now()->translatedFormat('l, d F Y') }}.
            </p>

        </div>

    </div>


    <div class="attendance-grid">

        {{-- HADIR --}}
        <div class="attendance-card hadir">

            <div class="attendance-icon">
                <i class="bi bi-check-circle"></i>
            </div>

            <div>

                <span>Hadir</span>

                <strong>
                    {{ number_format($absensiHadir) }}
                </strong>

            </div>

        </div>


        {{-- TERLAMBAT --}}
        <div class="attendance-card terlambat">

            <div class="attendance-icon">
                <i class="bi bi-clock"></i>
            </div>

            <div>

                <span>Terlambat</span>

                <strong>
                    {{ number_format($absensiTerlambat) }}
                </strong>

            </div>

        </div>


        {{-- IZIN --}}
        <div class="attendance-card izin">

            <div class="attendance-icon">
                <i class="bi bi-envelope"></i>
            </div>

            <div>

                <span>Izin</span>

                <strong>
                    {{ number_format($absensiIzin) }}
                </strong>

            </div>

        </div>


        {{-- SAKIT --}}
        <div class="attendance-card sakit">

            <div class="attendance-icon">
                <i class="bi bi-heart-pulse"></i>
            </div>

            <div>

                <span>Sakit</span>

                <strong>
                    {{ number_format($absensiSakit) }}
                </strong>

            </div>

        </div>


        {{-- ALPHA --}}
        <div class="attendance-card alpha">

            <div class="attendance-icon">
                <i class="bi bi-x-circle"></i>
            </div>

            <div>

                <span>Alpha</span>

                <strong>
                    {{ number_format($absensiAlpha) }}
                </strong>

            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- MONITORING --}}
    {{-- ========================================================= --}}

    <div class="monitor-grid">


        {{-- ===================================================== --}}
        {{-- PENGAJUAN TERBARU --}}
        {{-- ===================================================== --}}

        <div class="dashboard-card">

            <div class="card-header-dashboard">

                <div>

                    <h3>Pengajuan Terbaru</h3>

                    <p>
                        Pengajuan absensi terbaru dari siswa.
                    </p>

                </div>

            </div>


            <div class="dashboard-table-wrapper">

                <table class="dashboard-table">

                    <thead>

                        <tr>

                            <th>No</th>

                            <th>Siswa</th>

                            <th>Jenis</th>

                            <th>Tanggal</th>

                            <th>Status</th>

                        </tr>

                    </thead>


                    <tbody>

                        @forelse($pengajuanTerbaru as $index => $item)

                            <tr>

                                <td>
                                    {{ $index + 1 }}
                                </td>

                                <td>

                                    <strong>
                                        {{ $item->siswa }}
                                    </strong>

                                </td>

                                <td>

                                    @if($item->jenis === 'Sakit')

                                        <span class="type-badge sakit-badge">
                                            Sakit
                                        </span>

                                    @elseif($item->jenis === 'Izin Keluar')

                                        <span class="type-badge keluar-badge">
                                            Izin Keluar
                                        </span>

                                    @elseif($item->jenis === 'Izin Pulang')

                                        <span class="type-badge pulang-badge">
                                            Izin Pulang
                                        </span>

                                    @else

                                        <span class="type-badge dispen-badge">
                                            Dispensasi
                                        </span>

                                    @endif

                                </td>

                                <td>

                                    @if($item->tanggal)

                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') }}

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    @php
                                        $status = $item->status ?? 'menunggu';

                                        $statusLabel = match ($status) {

                                            'disetujui' => 'Disetujui',

                                            'ditolak' => 'Ditolak',

                                            'menunggu',
                                            'menunggu_walikelas',
                                            'menunggu_guru',
                                            'menunggu_kesiswaan'
                                                => 'Menunggu',

                                            default => ucfirst(str_replace('_', ' ', $status)),
                                        };
                                    @endphp


                                    @if($status === 'disetujui')

                                        <span class="status-badge status-approved">
                                            {{ $statusLabel }}
                                        </span>

                                    @elseif($status === 'ditolak')

                                        <span class="status-badge status-rejected">
                                            {{ $statusLabel }}
                                        </span>

                                    @else

                                        <span class="status-badge status-pending">
                                            {{ $statusLabel }}
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="empty-data">

                                    Belum ada pengajuan.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- ===================================================== --}}
        {{-- DISPENSASI --}}
        {{-- ===================================================== --}}

        <div class="dashboard-card">

            <div class="card-header-dashboard">

                <div>

                    <h3>Ringkasan Dispensasi</h3>

                    <p>
                        Data dispensasi siswa.
                    </p>

                </div>

            </div>


            <div class="dispen-summary">


                <div class="dispen-item">

                    <div class="dispen-item-icon">
                        <i class="bi bi-file-earmark-text"></i>
                    </div>

                    <div>

                        <span>Total Dispensasi</span>

                        <strong>
                            {{ number_format($totalDispen) }}
                        </strong>

                    </div>

                </div>


                <div class="dispen-item">

                    <div class="dispen-item-icon">
                        <i class="bi bi-file-earmark-check"></i>
                    </div>

                    <div>

                        <span>Memiliki Surat</span>

                        <strong>
                            {{ number_format($dispenDenganSurat) }}
                        </strong>

                    </div>

                </div>


                <div class="dispen-item">

                    <div class="dispen-item-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>

                    <div>

                        <span>Pengajuan Hari Ini</span>

                        <strong>
                            {{ number_format($dispenHariIni) }}
                        </strong>

                    </div>

                </div>


            </div>

        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- RINGKASAN PENGAJUAN --}}
    {{-- ========================================================= --}}

    <div class="dashboard-card full-card">

        <div class="card-header-dashboard">

            <div>

                <h3>Ringkasan Pengajuan Absensi</h3>

                <p>
                    Jumlah pengajuan yang tercatat di sistem.
                </p>

            </div>

        </div>


        <div class="request-grid">


            {{-- SAKIT --}}
            <div class="request-card">

                <div class="request-icon">
                    <i class="bi bi-heart-pulse"></i>
                </div>

                <div class="request-content">

                    <span>Pengajuan Sakit</span>

                    <strong>
                        {{ number_format($totalPengajuanSakit) }}
                    </strong>

                    <small>
                        Total pengajuan
                    </small>

                </div>

            </div>


            {{-- IZIN KELUAR --}}
            <div class="request-card">

                <div class="request-icon">
                    <i class="bi bi-box-arrow-right"></i>
                </div>

                <div class="request-content">

                    <span>Izin Keluar</span>

                    <strong>
                        {{ number_format($totalIzinKeluar) }}
                    </strong>

                    <small>
                        Total pengajuan
                    </small>

                </div>

            </div>


            {{-- IZIN PULANG --}}
            <div class="request-card">

                <div class="request-icon">
                    <i class="bi bi-house-door"></i>
                </div>

                <div class="request-content">

                    <span>Izin Pulang</span>

                    <strong>
                        {{ number_format($totalIzinPulang) }}
                    </strong>

                    <small>
                        Total pengajuan
                    </small>

                </div>

            </div>


            {{-- DISPEN --}}
            <div class="request-card">

                <div class="request-icon">
                    <i class="bi bi-file-earmark-text"></i>
                </div>

                <div class="request-content">

                    <span>Dispensasi</span>

                    <strong>
                        {{ number_format($totalDispen) }}
                    </strong>

                    <small>
                        Total pengajuan
                    </small>

                </div>

            </div>


        </div>

    </div>


    {{-- ========================================================= --}}
    {{-- INFORMASI SISTEM --}}
    {{-- ========================================================= --}}

    <div class="dashboard-card full-card">

        <div class="card-header-dashboard">

            <div>

                <h3>Informasi Sistem</h3>

                <p>
                    Informasi umum data akademik sekolah.
                </p>

            </div>

        </div>


        <div class="system-info-grid">


            <div class="system-info-item">

                <span>Tahun Ajaran Aktif</span>

                <strong>
                    {{ $tahunAjaranAktif }}
                </strong>

            </div>


            <div class="system-info-item">

                <span>Jumlah Siswa</span>

                <strong>
                    {{ number_format($totalSiswa) }} Siswa
                </strong>

            </div>


            <div class="system-info-item">

                <span>Jumlah Guru</span>

                <strong>
                    {{ number_format($totalGuru) }} Guru
                </strong>

            </div>


            <div class="system-info-item">

                <span>Jumlah Kelas</span>

                <strong>
                    {{ number_format($totalKelas) }} Kelas
                </strong>

            </div>


            <div class="system-info-item">

                <span>Mata Pelajaran</span>

                <strong>
                    {{ number_format($totalMapel) }} Mapel
                </strong>

            </div>


            <div class="system-info-item">

                <span>Status Sistem</span>

                <strong class="system-active">

                    <span class="status-dot"></span>

                    Aktif

                </strong>

            </div>


        </div>

    </div>

</div>

@endsection


{{-- ============================================================= --}}
{{-- STYLE --}}
{{-- ============================================================= --}}

@push('styles')

<style>

.dashboard {
    width: 100%;
}


/* ============================================================= */
/* HEADER */
/* ============================================================= */

.dashboard-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: 28px;
}

.dashboard-header h1 {
    font-size: 26px;
    font-weight: 700;
    margin-bottom: 6px;
    color: #1e293b;
}

.dashboard-header p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}

.date-box {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 12px 18px;
    min-width: 190px;
    text-align: center;
    color: #475569;
    font-size: 13px;
}

.date-box i {
    color: #2563eb;
    margin-right: 5px;
}


/* ============================================================= */
/* STATISTIK */
/* ============================================================= */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 18px;
    margin-bottom: 30px;
}

.stat-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
    display: flex;
    align-items: center;
    gap: 15px;
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 9px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 21px;
    flex-shrink: 0;
}

.stat-content span {
    display: block;
    font-size: 13px;
    color: #64748b;
    margin-bottom: 3px;
}

.stat-content h2 {
    margin: 0 0 3px;
    font-size: 25px;
    color: #1e293b;
}

.stat-content small {
    font-size: 11px;
    color: #94a3b8;
}


/* ============================================================= */
/* SECTION */
/* ============================================================= */

.section-title {
    margin-bottom: 15px;
}

.section-title h2 {
    font-size: 19px;
    margin: 0 0 4px;
    color: #1e293b;
}

.section-title p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}


/* ============================================================= */
/* PRESENSI */
/* ============================================================= */

.attendance-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: 15px;
    margin-bottom: 30px;
}

.attendance-card {
    background: white;
    border-radius: 10px;
    padding: 17px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
    display: flex;
    align-items: center;
    gap: 12px;
}

.attendance-icon {
    width: 42px;
    height: 42px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.attendance-card span {
    display: block;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 3px;
}

.attendance-card strong {
    display: block;
    font-size: 21px;
    color: #1e293b;
}

.attendance-card.hadir .attendance-icon {
    background: #dcfce7;
    color: #16a34a;
}

.attendance-card.terlambat .attendance-icon {
    background: #fef3c7;
    color: #d97706;
}

.attendance-card.izin .attendance-icon {
    background: #dbeafe;
    color: #2563eb;
}

.attendance-card.sakit .attendance-icon {
    background: #fce7f3;
    color: #db2777;
}

.attendance-card.alpha .attendance-icon {
    background: #fee2e2;
    color: #dc2626;
}


/* ============================================================= */
/* MONITORING */
/* ============================================================= */

.monitor-grid {
    display: grid;
    grid-template-columns: 1.6fr 1fr;
    gap: 20px;
    margin-bottom: 20px;
}


/* ============================================================= */
/* CARD */
/* ============================================================= */

.dashboard-card {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 8px rgba(0, 0, 0, .05);
}

.full-card {
    margin-bottom: 20px;
}

.card-header-dashboard {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 18px;
}

.card-header-dashboard h3 {
    margin: 0 0 4px;
    font-size: 17px;
    color: #1e293b;
}

.card-header-dashboard p {
    margin: 0;
    color: #64748b;
    font-size: 12px;
}


/* ============================================================= */
/* TABLE */
/* ============================================================= */

.dashboard-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.dashboard-table {
    width: 100%;
    border-collapse: collapse;
}

.dashboard-table th,
.dashboard-table td {
    padding: 11px 10px;
    border-bottom: 1px solid #e5e7eb;
    font-size: 13px;
    text-align: left;
    white-space: nowrap;
}

.dashboard-table th {
    background: #f8fafc;
    color: #475569;
    font-weight: 600;
}

.dashboard-table td {
    color: #475569;
}

.dashboard-table td strong {
    color: #1e293b;
}

.dashboard-table tbody tr:hover {
    background: #f8fafc;
}

.empty-data {
    text-align: center !important;
    color: #94a3b8 !important;
    padding: 25px !important;
}


/* ============================================================= */
/* BADGE JENIS */
/* ============================================================= */

.type-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 600;
}

.sakit-badge {
    background: #fce7f3;
    color: #be185d;
}

.keluar-badge {
    background: #dbeafe;
    color: #1d4ed8;
}

.pulang-badge {
    background: #f1f5f9;
    color: #475569;
}

.dispen-badge {
    background: #ede9fe;
    color: #6d28d9;
}


/* ============================================================= */
/* STATUS */
/* ============================================================= */

.status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 5px;
    font-size: 11px;
    font-weight: 600;
}

.status-approved {
    background: #dcfce7;
    color: #166534;
}

.status-rejected {
    background: #fee2e2;
    color: #991b1b;
}

.status-pending {
    background: #fef3c7;
    color: #92400e;
}


/* ============================================================= */
/* DISPENSASI */
/* ============================================================= */

.dispen-summary {
    display: flex;
    flex-direction: column;
    gap: 13px;
}

.dispen-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 13px;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
}

.dispen-item-icon {
    width: 40px;
    height: 40px;
    border-radius: 8px;
    background: #eff6ff;
    color: #2563eb;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 17px;
}

.dispen-item span {
    display: block;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 3px;
}

.dispen-item strong {
    font-size: 19px;
    color: #1e293b;
}


/* ============================================================= */
/* REQUEST */
/* ============================================================= */

.request-grid {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 15px;
}

.request-card {
    border: 1px solid #e5e7eb;
    border-radius: 9px;
    padding: 17px;
    display: flex;
    align-items: center;
    gap: 12px;
}

.request-icon {
    width: 42px;
    height: 42px;
    background: #f1f5f9;
    color: #475569;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
}

.request-content span {
    display: block;
    font-size: 12px;
    color: #64748b;
    margin-bottom: 3px;
}

.request-content strong {
    display: block;
    font-size: 21px;
    color: #1e293b;
    margin-bottom: 2px;
}

.request-content small {
    color: #94a3b8;
    font-size: 10px;
}


/* ============================================================= */
/* INFORMASI SISTEM */
/* ============================================================= */

.system-info-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.system-info-item {
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    padding: 15px;
}

.system-info-item span {
    display: block;
    color: #64748b;
    font-size: 12px;
    margin-bottom: 6px;
}

.system-info-item strong {
    color: #1e293b;
    font-size: 14px;
}

.system-active {
    display: flex !important;
    align-items: center;
    gap: 7px;
}

.status-dot {
    width: 8px;
    height: 8px;
    background: #16a34a;
    border-radius: 50%;
    display: inline-block;
}


/* ============================================================= */
/* RESPONSIVE */
/* ============================================================= */

@media (max-width: 1100px) {

    .stats-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .attendance-grid {
        grid-template-columns: repeat(3, 1fr);
    }

    .request-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .system-info-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .monitor-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 768px) {

    .dashboard-header {
        flex-direction: column;
        gap: 15px;
    }

    .date-box {
        width: 100%;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }

    .attendance-grid {
        grid-template-columns: repeat(2, 1fr);
    }

    .request-grid {
        grid-template-columns: 1fr;
    }

    .system-info-grid {
        grid-template-columns: 1fr;
    }

}


@media (max-width: 500px) {

    .attendance-grid {
        grid-template-columns: 1fr;
    }

}

</style>

@endpush