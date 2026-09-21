@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a
            href="{{ route('admin.absensi.index') }}"
            class="btn btn-light border mb-3">

            ← Kembali

        </a>

        <h3 class="fw-bold">
            Detail Absensi
        </h3>

    </div>


    <div class="row g-4">

        

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Data Siswa
                    </h5>

                    <table class="table">

                        <tr>
                            <th width="35%">Nama</th>
                            <td>
                                {{ $absensi->siswa->nama ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>NIS</th>
                            <td>
                                {{ $absensi->siswa->nis ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>NISN</th>
                            <td>
                                {{ $absensi->siswa->nisn ?? '-' }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>


        

        <div class="col-md-6">

            <div class="card border-0 shadow-sm">

                <div class="card-body">

                    <h5 class="fw-bold mb-4">
                        Data Kehadiran
                    </h5>

                    <table class="table">

                        <tr>
                            <th width="35%">Tanggal</th>
                            <td>
                                {{ $absensi->sesi?->tanggal?->format('d-m-Y') ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Waktu</th>
                            <td>
                                {{ $absensi->waktu_absen?->format('H:i:s') ?? '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge text-bg-primary">
                                    {{ $absensi->status }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Keterangan</th>
                            <td>
                                {{ $absensi->keterangan ?? '-' }}
                            </td>
                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection