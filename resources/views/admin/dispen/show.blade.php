@extends('layouts.app')

@section('title', 'Detail Dispensasi')

@section('content')

<div class="container-fluid py-4">

    <a
        href="{{ route('admin.dispen.index') }}"
        class="btn btn-light border mb-3">

        ← Kembali

    </a>

    <h3 class="fw-bold mb-4">
        Detail Dispensasi
    </h3>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <table class="table">

                <tr>
                    <th width="25%">Nama Siswa</th>
                    <td>
                        {{ $dispen->siswa->nama ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>NIS</th>
                    <td>
                        {{ $dispen->siswa->nis ?? '-' }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Mulai</th>
                    <td>
                        {{ $dispen->tanggal_mulai?->format('d-m-Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Tanggal Selesai</th>
                    <td>
                        {{ $dispen->tanggal_selesai?->format('d-m-Y') }}
                    </td>
                </tr>

                <tr>
                    <th>Alasan</th>
                    <td>
                        {{ $dispen->alasan }}
                    </td>
                </tr>

                <tr>
                    <th>Dokumen</th>
                    <td>

                        @if($dispen->dokumen)

                            <a
                                href="{{ asset('storage/'.$dispen->dokumen) }}"
                                target="_blank"
                                class="btn btn-sm btn-outline-primary">

                                Lihat Surat

                            </a>

                        @else

                            Tidak ada dokumen

                        @endif

                    </td>
                </tr>

                <tr>
                    <th>Status Kesiswaan</th>
                    <td>

                        <span class="badge text-bg-secondary">

                            {{ ucfirst(
                                $dispen->status_kesiswaan
                                ?? 'pending'
                            ) }}

                        </span>

                    </td>
                </tr>

                <tr>
                    <th>Catatan</th>
                    <td>
                        {{ $dispen->catatan_kesiswaan ?? '-' }}
                    </td>
                </tr>

            </table>

        </div>

    </div>

</div>

@endsection