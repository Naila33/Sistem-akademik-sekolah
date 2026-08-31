@extends('layouts.app')

@section('title', 'Edit Penilaian Mata Pelajaran')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold">Edit Penilaian</h3>
        <p class="text-muted">
            Perbarui nilai mata pelajaran siswa
        </p>
    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <form action="{{ route('admin.penilaian.mapel.update', $penilaian->id) }}"
                  method="POST">

                @csrf
                @method('PUT')


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Siswa
                    </label>

                    <select name="siswa_id"
                            class="form-select"
                            required>

                        @foreach($siswa as $item)

                            <option value="{{ $item->id }}"
                                {{ $penilaian->siswa_id == $item->id ? 'selected' : '' }}>

                                {{ $item->nama }}
                                ({{ $item->nis }})

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jadwal / Mata Pelajaran
                    </label>

                    <select name="jadwal_pelajaran_id"
                            class="form-select"
                            required>

                        @foreach($jadwal as $item)

                            <option value="{{ $item->id }}"
                                {{ $penilaian->jadwal_pelajaran_id == $item->id ? 'selected' : '' }}>

                                {{ $item->mataPelajaran->nama_mapel ?? '-' }}
                                -
                                {{ $item->kelas->tingkat ?? '' }}
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

                        <option value="harian"
                            {{ $penilaian->jenis_nilai == 'harian' ? 'selected' : '' }}>
                            Harian
                        </option>

                        <option value="ujian"
                            {{ $penilaian->jenis_nilai == 'ujian' ? 'selected' : '' }}>
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
                           value="{{ $penilaian->nilai }}"
                           required>

                </div>


                <div class="d-flex gap-2">

                    <a href="{{ route('admin.penilaian.mapel.index') }}"
                       class="btn btn-secondary">
                        Kembali
                    </a>

                    <button type="submit"
                            class="btn btn-success">
                        Update
                    </button>

                </div>

            </form>

        </div>
    </div>

</div>

@endsection