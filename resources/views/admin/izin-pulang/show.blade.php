@extends('layouts.app')

@section('title', 'Detail Izin Pulang')

@section('content')

<div class="container-fluid py-4">

    <a
        href="{{ route('admin.izin-pulang.index') }}"
        class="btn btn-light border mb-3">

        ← Kembali

    </a>

    <h3 class="fw-bold mb-4">
        Detail Izin Pulang
    </h3>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="25%">Nama Siswa</th>
                    <td>
                        {{ $izinPulang->siswa->nama ?? '-' }}
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
                        {{ $izinPulang->tanggal?->format('d-m-Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Jam Pulang</th>
                    <td>
                        {{ $izinPulang->jam_mulai }}
                        -
                        {{ $izinPulang->jam_selesai }}
                    </td>
                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>
                        {{ $izinPulang->alasan }}
                    </td>
                </tr>

                <tr>
                    <th>Dokumen</th>
                    <td>

                        @if($izinPulang->dokumen)

                            <a
                                href="{{ asset('storage/'.$izinPulang->dokumen) }}"
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
                            $izinPulang->status_kesiswaan
                            ?? 'pending'
                        ) }}
                    </span>

                    <p class="mt-3 mb-0">
                        {{ $izinPulang->catatan_kesiswaan ?? '-' }}
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
                            $izinPulang->status_guru_mapel
                            ?? 'pending'
                        ) }}
                    </span>

                    <p class="mt-3 mb-0">
                        {{ $izinPulang->catatan_guru_mapel ?? '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection