@extends('layouts.app')

@section('title', 'Tambah Penilaian Mata Pelajaran')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold">Tambah Penilaian</h3>
        <p class="text-muted">
            Tambahkan nilai mata pelajaran siswa
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.penilaian.mapel.store') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-semibold">
                        Siswa
                    </label>

                    <select name="siswa_id" class="form-select" required>
                        <option value="">-- Pilih Siswa --</option>

                        @foreach($siswa as $item)
                            <option value="{{ $item->id }}"
                                {{ old('siswa_id') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                                ({{ $item->nis }})
                            </option>
                        @endforeach

                    </select>

                    @error('siswa_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>


                <div class="mb-3">
    <label class="form-label fw-semibold">
        Jadwal / Mata Pelajaran
    </label>

    <select name="jadwal_pelajaran_id"
            class="form-select"
            required>

        <option value="">
            -- Pilih Mata Pelajaran --
        </option>

        @foreach($jadwal as $item)
            <option value="{{ $item->id }}">
                {{ $item->mataPelajaran->nama_mapel ?? 'Mapel tidak ditemukan' }}
                -
                Kelas {{ $item->kelas->tingkat ?? '' }}
                {{ $item->kelas->nama_kelas ?? '' }}
            </option>
        @endforeach

    </select>
</div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jenis Nilai
                    </label>

                    <select name="jenis_nilai"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Jenis Nilai --
                        </option>

                        <option value="harian"
                            {{ old('jenis_nilai') == 'harian' ? 'selected' : '' }}>
                            Harian
                        </option>

                        <option value="ujian"
                            {{ old('jenis_nilai') == 'ujian' ? 'selected' : '' }}>
                            Ujian
                        </option>

                    </select>

                </div>


                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Nilai
                    </label>

                    <input type="number"
                           name="nilai"
                           class="form-control"
                           min="0"
                           max="100"
                           step="0.01"
                           value="{{ old('nilai') }}"
                           required>

                    @error('nilai')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route('admin.penilaian.mapel.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-success">
                        Simpan
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection