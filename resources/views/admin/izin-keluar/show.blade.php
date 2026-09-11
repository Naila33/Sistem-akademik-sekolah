@extends('layouts.app')

@section('title', 'Detail Izin Keluar')

@section('content')

<div class="container-fluid py-4">

    <a
        href="{{ route('admin.izin-keluar.index') }}"
        class="btn btn-light border mb-3">

        ← Kembali

    </a>

    <h3 class="fw-bold mb-4">
        Detail Izin Keluar
    </h3>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="25%">Nama Siswa</th>
                    <td>
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
                    <td>
                        {{ $izinKeluar->tanggal?->format('d-m-Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Jam Keluar</th>
                    <td>
                        {{ $izinKeluar->jam_mulai }}
                        -
                        {{ $izinKeluar->jam_selesai }}
                    </td>
                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>
                        {{ $izinKeluar->alasan }}
                    </td>
                </tr>

                <tr>
                    <th>Dokumen</th>
                    <td>

                        @if($izinKeluar->dokumen)

                            <a
                                href="{{ asset('storage/'.$izinKeluar->dokumen) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">

                                Lihat Surat

                            </a>

                        @else

                            Tidak ada dokumen

                        @endif

                    </td>
                </tr>

            </table>

        </div>

    </div>


    <div class="row g-4 mt-1">

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Verifikasi Kesiswaan
                    </h5>

                    <span class="badge text-bg-secondary">
                        {{ ucfirst(
                            $izinKeluar->status_kesiswaan
                            ?? 'pending'
                        ) }}
                    </span>

                    <p class="mt-3 mb-0">
                        {{ $izinKeluar->catatan_kesiswaan ?? '-' }}
                    </p>

                </div>

            </div>

        </div>


        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold">
                        Verifikasi Guru Mapel
                    </h5>

                    <span class="badge text-bg-secondary">
                        {{ ucfirst(
                            $izinKeluar->status_guru_mapel
                            ?? 'pending'
                        ) }}
                    </span>

                    <p class="mt-3 mb-0">
                        {{ $izinKeluar->catatan_guru_mapel ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection