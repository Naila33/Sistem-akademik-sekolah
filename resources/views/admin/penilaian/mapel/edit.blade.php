@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">

        <a href="{{ route(
            'admin.penilaian.mapel.mapel',
            [
                'kelasId' => $kelas->id,
                'mapelId' => $mataPelajaran->id
            ]
        ) }}"
           class="text-decoration-none text-muted">

            <i class="bi bi-arrow-left"></i>
            Kembali

        </a>

    </div>


    <div class="mb-4">

        <h3 class="fw-bold mb-1">
            Edit Penilaian
        </h3>

        <p class="text-muted">
            {{ $kelas->tingkat }}
            {{ $kelas->nama_kelas }}
            —
            {{ $mataPelajaran->nama_mapel }}
        </p>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form method="POST"
                  action="{{ route(
                      'admin.penilaian.mapel.update',
                      [
                          'kelasId' => $kelas->id,
                          'mapelId' => $mataPelajaran->id,
                          'id' => $penilaian->id
                      ]
                  ) }}">

                @csrf
                @method('PUT')


                {{-- GURU / JADWAL --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Guru / Jadwal
                    </label>

                    <select name="jadwal_pelajaran_id"
                            class="form-select"
                            required>

                        @foreach($jadwal as $j)

                            <option value="{{ $j->id }}"
                                {{ $penilaian->jadwal_pelajaran_id == $j->id
                                    ? 'selected'
                                    : '' }}>

                                {{ $j->guru?->nama ?? '-' }}

                                @if($j->hari)
                                    — {{ $j->hari }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- SISWA --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Siswa
                    </label>

                    <select name="siswa_id"
                            class="form-select"
                            required>

                        @foreach($siswa as $s)

                            <option value="{{ $s->id }}"
                                {{ $penilaian->siswa_id == $s->id
                                    ? 'selected'
                                    : '' }}>

                                {{ $s->nis }}
                                —
                                {{ $s->nama }}

                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- JENIS --}}
                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Jenis Nilai
                    </label>

                    <select name="jenis_nilai"
                            class="form-select"
                            required>

                        <option value="harian"
                            {{ $penilaian->jenis_nilai == 'harian'
                                ? 'selected'
                                : '' }}>

                            Harian

                        </option>

                        <option value="ujian"
                            {{ $penilaian->jenis_nilai == 'ujian'
                                ? 'selected'
                                : '' }}>

                            Ujian

                        </option>

                    </select>

                </div>


                {{-- NILAI --}}
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

                    <a href="{{ route(
                        'admin.penilaian.mapel.mapel',
                        [
                            'kelasId' => $kelas->id,
                            'mapelId' => $mataPelajaran->id
                        ]
                    ) }}"
                       class="btn btn-secondary">

                        Batal

                    </a>


                    <button type="submit"
                            class="btn btn-success">

                        <i class="bi bi-save me-1"></i>
                        Simpan Perubahan

                    </button>

                </div>

            </form>

        </div>

    </div>

</div>

@endsection