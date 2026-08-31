<!DOCTYPE html>

<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Penilaian</title>
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

<style>
    body {
        margin: 0;
        background: #f5f6fa;
        color: #333;
        font-family: Arial, sans-serif;
    }

    .container-fluid {
        box-sizing: border-box;
        margin-left: 250px;
        padding: 30px;
        min-height: 100vh;
    }

    .d-flex { display: flex; }
    .justify-content-between { justify-content: space-between; }
    .align-items-center { align-items: center; }
    .mb-1 { margin-bottom: 4px; }
    .mb-3 { margin-bottom: 16px; }
    .mb-4 { margin-bottom: 24px; }
    .fw-bold { font-weight: 700; }
    .fw-semibold { font-weight: 600; }
    .text-muted { color: #64748b; }
    .text-start { text-align: left; }
    .text-center { text-align: center; }
    .d-block { display: block; }

    .card {
        overflow: hidden;
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(15, 23, 42, .06);
    }

    .card-body { padding: 20px; }
    .card-body.p-0 { padding: 0; }
    .card-footer { padding: 14px 20px; border-top: 1px solid #e2e8f0; }

    .row { display: flex; gap: 24px; }
    .col-md-4 { flex: 1; }
    small { display: block; margin-bottom: 6px; font-size: 12px; }

    .btn {
        display: inline-block;
        padding: 9px 14px;
        border: 1px solid transparent;
        border-radius: 4px;
        text-decoration: none;
        cursor: pointer;
        font-size: 14px;
    }

    .btn-primary { background: #176b87; color: #fff; }
    .btn-success { background: #198754; color: #fff; }
    .btn-secondary { background: #6c757d; color: #fff; }
    .btn-outline-secondary { border-color: #6c757d; color: #6c757d; }

    .table-responsive { overflow-x: auto; }
    .table { width: 100%; min-width: 700px; border-collapse: collapse; }
    .table th, .table td { padding: 10px 12px; border: 1px solid #dee2e6; }
    .table th { background: #f1f5f9; }
    .form-control { box-sizing: border-box; width: 100%; padding: 8px; border: 1px solid #cbd5e1; border-radius: 4px; }
    .nilai-input { text-align: right; }
    .nilai-cell { text-align: right; }
    .py-5 { padding-top: 48px; padding-bottom: 48px; }
    .filter-form { display: flex; align-items: end; gap: 10px; margin-bottom: 20px; }
    .filter-form label { display: block; margin-bottom: 6px; font-size: 13px; font-weight: 600; }
    .filter-form select { min-width: 180px; padding: 9px; border: 1px solid #cbd5e1; border-radius: 4px; }
    .pagination { display: flex; gap: 6px; align-items: center; padding: 14px 20px; }
    .pagination a, .pagination span { padding: 6px 10px; border: 1px solid #cbd5e1; border-radius: 4px; text-decoration: none; color: #176b87; }
    .pagination .active span { background: #176b87; color: #fff; }

    @media (max-width: 768px) {
        .container-fluid { margin-left: 210px; padding: 15px; }
        .row { flex-direction: column; gap: 14px; }
        .d-flex { align-items: flex-start; flex-direction: column; gap: 12px; }
    }
</style>
</head>
<body>

@include('layouts.sidebar-guru')

    <div class="container-fluid py-4">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h3 class="fw-bold mb-1">Detail Penilaian</h3>
                <p class="text-muted mb-0">
                    {{ $jadwal->mapel->nama_mapel ?? '-' }}
                    - Kelas
                    {{ $jadwal->kelas?->tingkat ?? '-' }}
                    {{ $jadwal->kelas?->jurusan?->kode_jurusan ?? '-' }}
                    {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                </p>
            </div>

            <a href="{{ route('guru.penilaian.index') }}" class="btn btn-outline-secondary">
                ← Kembali
            </a>
        </div>


        {{-- Informasi --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <div class="row">

                    <div class="col-md-4">
                        <small class="text-muted">Mata Pelajaran</small>
                        <div class="fw-semibold">
                            {{ $jadwal->mapel->nama_mapel ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Kelas</small>
                        <div class="fw-semibold">
                            {{ $jadwal->kelas?->tingkat ?? '-' }}
                    {{ $jadwal->kelas?->jurusan?->kode_jurusan ?? '-' }}
                    {{ $jadwal->kelas?->nama_kelas ?? '-' }}
                        </div>
                    </div>

                    <div class="col-md-4">
                        <small class="text-muted">Semester</small>
                        <div class="fw-semibold">
                            {{ $jadwal->kelas->tahunAjaran->semester ?? '-' }}
                        </div>
                    </div>

                </div>
            </div>
        </div>


        {{-- Tombol --}}
        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="fw-bold mb-0">
                Daftar Nilai Siswa
            </h5>

            <a href="{{ route('guru.penilaian.create', $jadwal->id) }}" class="btn btn-primary">
                + Tambah Penilaian
            </a>

        </div>

        <form action="{{ route('guru.penilaian.detail', $jadwal->id) }}" method="GET" class="filter-form">
            <div>
                <label for="jenis_nilai">Filter Jenis Penilaian</label>
                <select name="jenis_nilai" id="jenis_nilai">
                    <option value="">Semua</option>
                    <option value="harian" @selected($jenisNilai === 'harian')>Harian</option>
                    <option value="ujian" @selected($jenisNilai === 'ujian')>Ujian</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tampilkan</button>
            @if($jenisNilai)
                <a href="{{ route('guru.penilaian.detail', $jadwal->id) }}" class="btn btn-outline-secondary">Reset</a>
            @endif
        </form>


        {{-- Tabel Nilai --}}
        <div class="card border-0 shadow-sm">

            <div class="card-body p-0">

                <div class="table-responsive">

                    <table class="table table-bordered align-middle mb-0">

                        <thead class="table-light text-center">

                            <tr>
                                <th width="60">No</th>
                                <th width="120">NIS</th>
                                <th class="text-start">Nama Siswa</th>

                                @php $urutanJenis = []; @endphp
                                @foreach($jenisPenilaian as $jenis)
                                    @php
                                        $namaJenis = strtolower($jenis->jenis_nilai);
                                        $urutanJenis[$namaJenis] = ($urutanJenis[$namaJenis] ?? 0) + 1;
                                        $tanggalJenis = \Carbon\Carbon::parse($jenis->tanggal_penilaian)->format('d-m-Y');
                                    @endphp
                                    <th width="160">
                                        <span class="d-block fw-semibold">
                                            {{ ucfirst($jenis->jenis_nilai) }} {{ $urutanJenis[$namaJenis] }}
                                        </span>
                                        <small class="text-muted d-block mt-1">
                                            {{ $tanggalJenis }}
                                        </small>
                                    </th>
                                    @endforeach
                                    <th width="100">Aksi</th>

                            </tr>

                        </thead>


                        <tbody>

                            @forelse($siswa as $index => $item)

                                <tr>

                                    <td class="text-center">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="text-center">
                                        {{ $item->nisn ?? '-' }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $item->nama }}
                                        </strong>


                                    {{-- Nilai --}}
                                    @foreach($jenisPenilaian as $jenis)
    @php
        $nilai = $nilaiSiswa
            ->where('siswa_id', $item->id)
            ->where('jenis_nilai', $jenis->jenis_nilai)
            ->where('tanggal_penilaian', $jenis->tanggal_penilaian)
            ->first();
    @endphp

    <td class="nilai-cell">
        <input
            type="number"
            min="0"
            max="100"
            class="form-control nilai-input"
            name="nilai[{{ $item->id }}][{{ $jenis->id }}]"
            value="{{ $nilai->nilai ?? '' }}"
            placeholder="-"
        >
    </td>

                                    @endforeach

                                    <td class="text-center">
    <a href="{{ route('guru.penilaian.editSiswa', [
        'jadwal' => $jadwal->id,
        'siswa' => $item->id
    ]) }}"
       class="btn btn-primary">
        Edit
    </a>
</td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="{{ 3 + $jenisPenilaian->count() }}" class="text-center py-5 text-muted">

                                        Belum ada siswa pada kelas ini.

                                    </td>

                                </tr>

                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Footer --}}
            @if($siswa->count() > 0)

                <div class="card-footer bg-white text-end">

                </div>

            @endif

            @if($siswa->hasPages())
                <div class="pagination">
                    {{ $siswa->links() }}
                </div>
            @endif

        </div>

    </div>



    {{-- Modal Tambah Penilaian --}}
    <div class="modal fade" id="modalTambahPenilaian" tabindex="-1">

        <div class="modal-dialog">

            <form action="{{ route('guru.penilaian.create', $jadwal->id) }}" method="GET">

                <div class="modal-content">

                    <div class="modal-header">

                        <h5 class="modal-title">
                            Tambah Penilaian
                        </h5>

                        <button type="button" class="btn-close" data-bs-dismiss="modal">
                        </button>

                    </div>


                    <div class="modal-body">

                        <div class="mb-3">

                            <label class="form-label">
                                Nama Penilaian
                            </label>

                            
                        </div>

                        <div class="mb-3">

                            <label class="form-label">
                                Tanggal
                            </label>

                        </div>

                    </div>


                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">

                            Batal

                        </button>

                        <button type="submit" class="btn btn-primary">

                            Simpan

                        </button>

                    </div>

                </div>

            </form>

        </div>

    </div>


</body>
</html>