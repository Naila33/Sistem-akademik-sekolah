@extends('layouts.app')

@section('title', 'Penilaian ' . $mataPelajaran->nama_mapel)

@section('content')

<div class="container-fluid py-4">

    {{-- BACK --}}
    <div class="mb-3">

        <a href="{{ route(
            'admin.penilaian.mapel.kelas',
            $kelas->id
        ) }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left"></i>
            Kembali ke Mata Pelajaran

        </a>

    </div>


    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h3 class="fw-bold mb-1">

                {{ $mataPelajaran->nama_mapel }}

            </h3>

            <p class="text-muted mb-0">

                Penilaian
                {{ $kelas->tingkat }}
                {{ $kelas->nama_kelas }}

                @if($kelas->jurusan)
                    — {{ $kelas->jurusan->nama_jurusan }}
                @endif

            </p>

        </div>


        <a href="{{ route(
            'admin.penilaian.mapel.create',
            [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id
            ]
        ) }}"
           class="btn btn-success">

            <i class="bi bi-plus-lg me-1"></i>

            Tambah Penilaian

        </a>

    </div>


    {{-- SUCCESS --}}
    @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            <i class="bi bi-check-circle me-1"></i>

            {{ session('success') }}

            <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert">
            </button>

        </div>

    @endif


    {{-- FILTER --}}
    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <form method="GET"
                  action="{{ route(
                      'admin.penilaian.mapel.mapel',
                      [
                          'kelasId' => $kelas->id,
                          'mapelId' => $mataPelajaran->id
                      ]
                  ) }}">

                <div class="row g-3">

                    {{-- SEARCH SISWA --}}
                    <div class="col-md-5">

                        <label class="form-label fw-semibold">
                            Cari Siswa
                        </label>

                        <div class="input-group">

                            <span class="input-group-text">

                                <i class="bi bi-search"></i>

                            </span>

                            <input type="text"
                                   name="search"
                                   value="{{ request('search') }}"
                                   class="form-control"
                                   placeholder="Nama, NIS, atau NISN">

                        </div>

                    </div>


                    {{-- JENIS NILAI --}}
                    <div class="col-md-3">

                        <label class="form-label fw-semibold">
                            Jenis Nilai
                        </label>

                        <select name="jenis_nilai"
                                class="form-select">

                            <option value="">
                                Semua Jenis
                            </option>

                            <option value="harian"
                                {{ request('jenis_nilai') == 'harian'
                                    ? 'selected'
                                    : '' }}>

                                Harian

                            </option>

                            <option value="ujian"
                                {{ request('jenis_nilai') == 'ujian'
                                    ? 'selected'
                                    : '' }}>

                                Ujian

                            </option>

                        </select>

                    </div>


                    {{-- TANGGAL --}}
                    <div class="col-md-2">

                        <label class="form-label fw-semibold">
                            Tanggal
                        </label>

                        <input type="date"
                               name="tanggal"
                               value="{{ request('tanggal') }}"
                               class="form-control">

                    </div>


                    {{-- BUTTON --}}
                    <div class="col-md-2 d-flex align-items-end">

                        <div class="d-flex gap-2 w-100">

                            <button type="submit"
                                    class="btn btn-success flex-fill">

                                <i class="bi bi-funnel"></i>

                            </button>

                            <a href="{{ route(
                                'admin.penilaian.mapel.mapel',
                                [
                                    'kelasId' => $kelas->id,
                                    'mapelId' => $mataPelajaran->id
                                ]
                            ) }}"
                               class="btn btn-secondary">

                                <i class="bi bi-arrow-counterclockwise"></i>

                            </a>

                        </div>

                    </div>

                </div>

            </form>

        </div>

    </div>


    {{-- TABLE --}}
    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead>

                        <tr>

                            <th width="60">
                                No
                            </th>

                            <th>
                                NIS
                            </th>

                            <th>
                                Siswa
                            </th>

                            <th>
                                Jenis Nilai
                            </th>

                            <th>
                                Nilai
                            </th>

                            <th>
                                Tanggal
                            </th>

                            <th width="180">
                                Aksi
                            </th>

                        </tr>

                    </thead>


                    <tbody>

                    @forelse($penilaian as $item)

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>


                            <td>
                                {{ $item->siswa?->nis ?? '-' }}
                            </td>


                            <td>

                                <div class="fw-semibold">

                                    {{ $item->siswa?->nama ?? '-' }}

                                </div>

                            </td>


                            <td>

                                @if($item->jenis_nilai === 'harian')

                                    <span class="badge bg-info">
                                        Harian
                                    </span>

                                @elseif($item->jenis_nilai === 'ujian')

                                    <span class="badge bg-warning text-dark">
                                        Ujian
                                    </span>

                                @endif

                            </td>


                            <td>

                                <span class="fw-bold fs-5">

                                    {{ $item->nilai }}

                                </span>

                            </td>


                            <td>

                                {{ $item->created_at?->format('d/m/Y') ?? '-' }}

                            </td>


                            <td>

                                <div class="d-flex gap-1">

                                    <a href="{{ route(
                                        'admin.penilaian.mapel.edit',
                                        [
                                            'kelasId' => $kelas->id,
                                            'mapelId' => $mataPelajaran->id,
                                            'id' => $item->id
                                        ]
                                    ) }}"
                                       class="btn btn-sm btn-warning">

                                        <i class="bi bi-pencil"></i>
                                        Edit

                                    </a>


                                    <form action="{{ route(
                                        'admin.penilaian.mapel.destroy',
                                        [
                                            'kelasId' => $kelas->id,
                                            'mapelId' => $mataPelajaran->id,
                                            'id' => $item->id
                                        ]
                                    ) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin ingin menghapus nilai ini?')">

                                            <i class="bi bi-trash"></i>
                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-5">

                                <i class="bi bi-clipboard-x fs-1 text-muted"></i>

                                <h6 class="mt-3">
                                    Belum ada penilaian
                                </h6>

                                <p class="text-muted mb-3">
                                    Belum ada nilai untuk mata pelajaran ini.
                                </p>

                                <a href="{{ route(
                                    'admin.penilaian.mapel.create',
                                    [
                                        'kelasId' => $kelas->id,
                                        'mapelId' => $mataPelajaran->id
                                    ]
                                ) }}"
                                   class="btn btn-success">

                                    <i class="bi bi-plus-lg"></i>
                                    Tambah Penilaian

                                </a>

                            </td>

                        </tr>

                    @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>

@endsection