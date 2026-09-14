@extends('layouts.app')

@section('title', 'Dispensasi')

@section('content')

<div class="container-fluid py-4">

    {{-- ========================================================= --}}
    {{-- HEADER --}}
    {{-- ========================================================= --}}

    <div class="d-flex justify-content-between align-items-start mb-4">

        <div>

            <h3 class="fw-bold mb-1">
                Dispensasi
            </h3>

            <p class="text-muted mb-0">
                Kelola pengajuan dispensasi kamu.
            </p>

        </div>


        <a
            href="{{ route('siswa.dispen.create') }}"
            class="btn btn-success"
        >

            <i class="bi bi-plus-lg me-1"></i>

            Ajukan Dispensasi

        </a>

    </div>


    {{-- ========================================================= --}}
    {{-- HASIL --}}
    {{-- ========================================================= --}}

    <div id="dispenContent">

        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-hover align-middle mb-0">

                        <thead class="table-light">

                            <tr>

                                <th
                                    width="70"
                                    class="text-center"
                                >
                                    No
                                </th>

                                <th>
                                    Tanggal Dispensasi
                                </th>

                                <th>
                                    Alasan
                                </th>

                                <th
                                    width="130"
                                    class="text-center"
                                >
                                    Surat
                                </th>

                                <th
                                    width="110"
                                    class="text-center"
                                >
                                    Aksi
                                </th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($dispensasi as $index => $item)

                                <tr>

                                    {{-- NO --}}
                                    <td class="text-center">

                                        {{ $dispensasi->firstItem() + $index }}

                                    </td>


                                    {{-- TANGGAL --}}
                                    <td>

                                        <div class="fw-semibold">

                                            {{ $item->tanggal_mulai->format('d/m/Y') }}

                                            @if(
                                                $item->tanggal_mulai->format('Y-m-d')
                                                !=
                                                $item->tanggal_selesai->format('Y-m-d')
                                            )

                                                -

                                                {{ $item->tanggal_selesai->format('d/m/Y') }}

                                            @endif

                                        </div>

                                    </td>


                                    {{-- ALASAN --}}
                                    <td>

                                        <div style="max-width: 350px;">

                                            {{ \Illuminate\Support\Str::limit(
                                                $item->alasan,
                                                80
                                            ) }}

                                        </div>

                                    </td>


                                    {{-- SURAT --}}
                                    <td class="text-center">

                                        @if($item->surat)

                                            <a
                                                href="{{ asset('storage/' . $item->surat) }}"
                                                target="_blank"
                                                class="btn btn-sm btn-outline-success"
                                                title="Lihat Surat"
                                            >

                                                <i class="bi bi-file-earmark-text me-1"></i>

                                                Lihat

                                            </a>

                                        @else

                                            <span class="badge bg-secondary">

                                                Tidak Ada

                                            </span>

                                        @endif

                                    </td>


                                    {{-- AKSI --}}
                                    <td class="text-center">

                                        <a
                                            href="{{ route(
                                                'siswa.dispen.show',
                                                $item->id
                                            ) }}"
                                            class="btn btn-sm btn-outline-success"
                                            title="Lihat Detail"
                                        >

                                            <i class="bi bi-eye"></i>

                                        </a>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td
                                        colspan="5"
                                        class="text-center py-5"
                                    >

                                        <i
                                            class="bi bi-calendar-x fs-1 text-muted"
                                        ></i>

                                        <h5 class="mt-3">
                                            Belum Ada Pengajuan
                                        </h5>

                                        <p class="text-muted mb-3">
                                            Kamu belum memiliki pengajuan dispensasi.
                                        </p>

                                        <a
                                            href="{{ route('siswa.dispen.create') }}"
                                            class="btn btn-success"
                                        >

                                            <i class="bi bi-plus-lg me-1"></i>

                                            Ajukan Dispensasi

                                        </a>

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>


                {{-- ================================================= --}}
                {{-- PAGINATION --}}
                {{-- ================================================= --}}

                @if($dispensasi->hasPages())

                    <div
                        class="d-flex
                               justify-content-between
                               align-items-center
                               flex-wrap
                               gap-3
                               p-4
                               border-top"
                    >

                        <div class="text-muted small">

                            Menampilkan

                            <strong>
                                {{ $dispensasi->firstItem() }}
                            </strong>

                            sampai

                            <strong>
                                {{ $dispensasi->lastItem() }}
                            </strong>

                            dari

                            <strong>
                                {{ $dispensasi->total() }}
                            </strong>

                            pengajuan

                        </div>


                        <div>

                            {{ $dispensasi->links() }}

                        </div>

                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection