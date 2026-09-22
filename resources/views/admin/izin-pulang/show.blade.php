@extends('layouts.app')

@section('title', 'Detail Izin Pulang')

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
        margin-bottom: 20px;
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
        background: #eff6ff;
        border-color: #bfdbfe;
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
        padding: 14px 16px;
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
        vertical-align: middle;
    }

    .detail-table td {
        padding: 14px 16px;
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

    .no-document {
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

    .status-default {
        background: #f1f5f9;
        color: #64748b;
    }

    .note-label {
        margin-top: 18px;
        margin-bottom: 7px;
        color: #64748b;
        font-size: 11px;
        font-weight: 600;
    }

    .note-box {
        min-height: 70px;
        padding: 12px 13px;
        border: 1px solid #e2e8f0;
        border-radius: 7px;
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        line-height: 1.6;
    }

    @media (max-width: 768px) {
        .academic-container {
            padding: 18px 10px;
        }

        .page-header h3 {
            font-size: 20px;
        }

        .detail-card-header,
        .verification-card-header {
            padding: 16px;
        }

        .detail-card-body,
        .verification-body {
            padding: 16px;
        }

        .detail-table {
            display: block;
            overflow-x: auto;
        }

        .detail-table th {
            width: 150px;
            min-width: 150px;
        }

        .detail-table td {
            min-width: 220px;
        }
    }
</style>
@endpush

@section('content')

<div class="academic-container">

    <a
        href="{{ route('admin.izin-pulang.index') }}"
        class="btn-back"
    >
        <i class="bi bi-arrow-left"></i>
        Kembali
    </a>

    <div class="page-header">
        <h3>Detail Izin Pulang</h3>
        <p>Informasi lengkap pengajuan izin pulang siswa.</p>
    </div>

    <div class="detail-card">

        <div class="detail-card-header">

            <div class="detail-card-icon">
                <i class="bi bi-box-arrow-left"></i>
            </div>

            <h5 class="detail-card-title">
                Data Izin Pulang
            </h5>

        </div>

        <div class="detail-card-body">

            <table class="detail-table">

                <tr>
                    <th>Nama Siswa</th>
                    <td>
                        <span class="student-name">
                            {{ $izinPulang->siswa->nama ?? '-' }}
                        </span>
                    </td>
                </tr>

                <tr>
                    <th>NIS</th>
                    <td>
                        {{ $izinPulang->siswa->nis ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal</th>
                    <td>
                        {{ $izinPulang->tanggal?->format('d-m-Y') ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Jam Pulang</th>
                    <td>
                        {{ $izinPulang->jam_mulai ?? '-' }}
                        <span class="text-muted mx-1">-</span>
                        {{ $izinPulang->jam_selesai ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>
                        {{ $izinPulang->alasan ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Dokumen</th>
                    <td>

                        @if($izinPulang->dokumen)

                            <a
                                href="{{ asset('storage/'.$izinPulang->dokumen) }}"
                                target="_blank"
                                class="document-btn"
                            >
                                <i class="bi bi-file-earmark-text"></i>
                                Lihat Surat
                            </a>

                        @else

                            <span class="no-document">
                                Tidak ada dokumen
                            </span>

                        @endif

                    </td>
                </tr>

            </table>

        </div>

    </div>

    <div class="row g-4">

        <div class="col-md-6">

            @php
                $statusKesiswaan = $izinPulang->status_kesiswaan ?? 'pending';

                $badgeKesiswaan = match($statusKesiswaan) {
                    'diterima' => 'status-success',
                    'ditolak' => 'status-danger',
                    default => 'status-warning'
                };
            @endphp

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

                    <span class="status-badge {{ $badgeKesiswaan }}">
                        {{ ucfirst($statusKesiswaan) }}
                    </span>

                    <div class="note-label">
                        Catatan
                    </div>

                    <div class="note-box">
                        {{ $izinPulang->catatan_kesiswaan ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

        <div class="col-md-6">

            @php
                $statusGuru = $izinPulang->status_guru_mapel ?? 'pending';

                $badgeGuru = match($statusGuru) {
                    'diterima' => 'status-success',
                    'ditolak' => 'status-danger',
                    default => 'status-warning'
                };
            @endphp

            <div class="verification-card">

                <div class="verification-card-header">

                    <div class="verification-icon">
                        <i class="bi bi-person-badge"></i>
                    </div>

                    <h5 class="verification-title">
                        Verifikasi Guru Mapel
                    </h5>

                </div>

                <div class="verification-body">

                    <span class="status-badge {{ $badgeGuru }}">
                        {{ ucfirst($statusGuru) }}
                    </span>

                    <div class="note-label">
                        Catatan
                    </div>

                    <div class="note-box">
                        {{ $izinPulang->catatan_guru_mapel ?? '-' }}
                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection