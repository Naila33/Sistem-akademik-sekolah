@extends('layouts.app')

@section('title', 'Detail Pengajuan Sakit')

@section('content')

<div class="container-fluid py-4">

    <a
        href="{{ route('admin.sakit.index') }}"
        class="btn btn-light border mb-3">

        ← Kembali

    </a>

    <h3 class="fw-bold mb-4">
        Detail Pengajuan Sakit
    </h3>


    {{-- DATA SISWA --}}

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <h5 class="fw-bold mb-3">
                Data Siswa
            </h5>

            <table class="table">

                <tr>
                    <th width="25%">Nama</th>
                    <td>{{ $sakit->siswa->nama ?? '-' }}</td>
                </tr>

                <tr>
                    <th>NIS</th>
                    <td>{{ $sakit->siswa->nis ?? '-' }}</td>
                </tr>

                <tr>
                    <th>NISN</th>
                    <td>{{ $sakit->siswa->nisn ?? '-' }}</td>
                </tr>

                <tr>
                    <th>Periode</th>
                    <td>
                        {{ $sakit->tanggal_mulai?->format('d-m-Y') }}
                        -
                        {{ $sakit->tanggal_selesai?->format('d-m-Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>{{ $sakit->alasan }}</td>
                </tr>

                <tr>
                    <th>Dokumen</th>
                    <td>

                        @if($sakit->dokumen)

                            <a
                                href="{{ asset('storage/'.$sakit->dokumen) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">

                                Lihat Dokumen

                            </a>

                        @else

                            <span class="text-muted">
                                Tidak ada dokumen
                            </span>

                        @endif

                    </td>
                </tr>

            </table>

        </div>

    </div>


    {{-- VERIFIKASI --}}

    <div class="row g-4">

        <div class="col-md-4">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Wali Kelas
                    </h5>

                    <span class="badge text-bg-secondary mb-3">
                        {{ ucfirst($sakit->status_wali_kelas ?? 'pending') }}
                    </span>

                    <p class="mb-0">
                        {{ $sakit->catatan_wali_kelas ?? 'Tidak ada catatan.' }}
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-8">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-3">
                        Guru Mata Pelajaran
                    </h5>

                    <div class="table-responsive">

                        <table class="table">

                            <thead>

                                <tr>
                                    <th>Guru</th>
                                    <th>Jadwal</th>
                                    <th>Status</th>
                                    <th>Catatan</th>
                                </tr>

                            </thead>

                            <tbody>

                            @forelse($sakit->guru as $item)

                                <tr>

                                    <td>
                                        {{ $item->guru->nama ?? '-' }}
                                    </td>

                                    <td>
                                        {{ $item->jadwal->jam_mulai ?? '-' }}
                                        -
                                        {{ $item->jadwal->jam_selesai ?? '-' }}
                                    </td>

                                    <td>
                                        {{ ucfirst($item->status ?? 'pending') }}
                                    </td>

                                    <td>
                                        {{ $item->catatan ?? '-' }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4"
                                        class="text-center text-muted">
                                        Belum ada guru mapel.
                                    </td>
                                </tr>

                            @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection