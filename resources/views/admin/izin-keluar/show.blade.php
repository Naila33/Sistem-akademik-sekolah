@extends('layouts.app')

@section('title', 'Detail Izin Keluar')

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

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        margin-bottom: 18px;
        padding: 8px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-back:hover {
        background: #f8fafc;
        border-color: #cbd5e1;
        color: #2563eb;
    }

    .detail-card {
        overflow: hidden;
        margin-bottom: 24px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .detail-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 22px;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-card-icon {
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

    .detail-card-title {
        margin: 0;
        color: #0f172a;
        font-size: 15px;
        font-weight: 700;
    }

    .detail-card-body {
        padding: 22px;
    }

    .detail-table {
        width: 100%;
        margin: 0;
        border-collapse: separate;
        border-spacing: 0;
    }

    .detail-table th {
        width: 25%;
        padding: 13px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        vertical-align: middle;
    }

    .detail-table td {
        padding: 13px 16px;
        border-bottom: 1px solid #f1f5f9;
        color: #334155;
        font-size: 13px;
        vertical-align: middle;
    }

    .detail-table tr:last-child th,
    .detail-table tr:last-child td {
        border-bottom: none;
    }

    .student-name {
        color: #0f172a;
        font-weight: 600;
    }

    .date-text,
    .time-text {
        color: #475569;
        font-weight: 500;
    }

    .reason-text {
        line-height: 1.7;
        color: #475569;
    }

    .document-btn {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 12px;
        border: 1px solid #bfdbfe;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .document-btn:hover {
        background: #2563eb;
        border-color: #2563eb;
        color: #ffffff;
    }

    .not-available {
        color: #94a3b8;
        font-size: 12px;
    }

    .verification-card {
        height: 100%;
        overflow: hidden;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
    }

    .verification-card-header {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 18px 20px;
        border-bottom: 1px solid #e2e8f0;
    }

    .verification-icon {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 8px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 15px;
    }

    .verification-title {
        margin: 0;
        color: #0f172a;
        font-size: 14px;
        font-weight: 700;
    }

    .verification-body {
        padding: 20px;
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

    .note-label {
        display: block;
        margin-top: 16px;
        margin-bottom: 6px;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .note-text {
        margin: 0;
        color: #475569;
        font-size: 12px;
        line-height: 1.7;
    }

    @media (max-width: 768px) {
        .academic-container {
            padding: 18px 10px;
        }

        .page-header h3 {
            font-size: 20px;
        }

        .detail-card-body,
        .verification-body {
            padding: 16px;
        }

        .detail-card-header,
        .verification-card-header {
            padding: 16px;
        }

        .detail-table th {
            width: 35%;
        }

        .detail-table th,
        .detail-table td {
            padding: 11px 12px;
        }
    }
</style>
@endpush

@section('content')

<div class="academic-container">

    <a
        href="{{ route('admin.izin-keluar.index') }}"
        class="btn-back"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    <div class="page-header">
        <h3>Detail Izin Keluar</h3>
        <p>Informasi lengkap izin keluar siswa dan proses verifikasi.</p>
    </div>

    <div class="detail-card">

        <div class="detail-card-header">

            <div class="detail-card-icon">
                <i class="bi bi-box-arrow-right"></i>
            </div>

            <h5 class="detail-card-title">
                Data Izin Keluar
            </h5>

        </div>

        <div class="detail-card-body">

            <div class="table-wrapper">

                <table class="detail-table">

                    <tr>
                        <th>Nama Siswa</th>
                        <td class="student-name">
                            {{ $izinKeluar->siswa->nama ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>NIS</th>
                        <td>
                            {{ $izinKeluar->siswa->nis ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Tanggal</th>
                        <td class="date-text">
                            {{ $izinKeluar->tanggal?->format('d-m-Y') ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Jam Keluar</th>
                        <td class="time-text">
                            {{ $izinKeluar->jam_mulai ?? '-' }}
                            <span class="text-muted mx-1">-</span>
                            {{ $izinKeluar->jam_selesai ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Alasan</th>
                        <td class="reason-text">
                            {{ $izinKeluar->alasan ?? '-' }}
                        </td>
                    </tr>

                    <tr>
                        <th>Dokumen</th>
                        <td>

                            @if($izinKeluar->dokumen)

                                <a
                                    href="{{ asset('storage/'.$izinKeluar->dokumen) }}"
                                    target="_blank"
                                    class="document-btn"
                                >
                                    <i class="bi bi-file-earmark-text"></i>
                                    Lihat Surat
                                </a>

                            @else

                                <span class="not-available">
                                    Tidak ada dokumen
                                </span>

                            @endif

                        </td>
                    </tr>

                </table>

            </div>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">

            <div class="verification-card">

                <div class="verification-card-header">

                    <div class="verification-icon">
                        <i class="bi bi-person-check"></i>
                    </div>

                    <h5 class="verification-title">
                        Verifikasi Kesiswaan
                    </h5>

                </div>

                <div class="verification-body">

                    @php
                        $statusKesiswaan = $izinKeluar->status_kesiswaan ?? 'pending';

                        $badgeKesiswaan = match($statusKesiswaan) {
                            'diterima' => 'status-success',
                            'ditolak' => 'status-danger',
                            default => 'status-warning'
                        };
                    @endphp

                    <span class="status-badge {{ $badgeKesiswaan }}">
                        {{ ucfirst($statusKesiswaan) }}
                    </span>

                    <span class="note-label">
                        Catatan
                    </span>

                    <p class="note-text">
                        {{ $izinKeluar->catatan_kesiswaan ?? 'Tidak ada catatan.' }}
                    </p>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            <div class="verification-card">

                <div class="verification-card-header">

                    <div class="verification-icon">
                        <i class="bi bi-person-workspace"></i>
                    </div>

                    <h5 class="verification-title">
                        Verifikasi Guru Mapel
                    </h5>

                </div>

                <div class="verification-body">

                    @php
                        $statusGuru = $izinKeluar->status_guru_mapel ?? 'pending';

                        $badgeGuru = match($statusGuru) {
                            'diterima' => 'status-success',
                            'ditolak' => 'status-danger',
                            default => 'status-warning'
                        };
                    @endphp

                    <span class="status-badge {{ $badgeGuru }}">
                        {{ ucfirst($statusGuru) }}
                    </span>

                    <span class="note-label">
                        Catatan
                    </span>

                    <p class="note-text">
                        {{ $izinKeluar->catatan_guru_mapel ?? 'Tidak ada catatan.' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection