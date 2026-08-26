@extends('layouts.app')

@section('content')

    <div class="container">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h3>Input Nilai</h3>

                <p class="mb-0">
                    {{ $jadwal->mapel?->nama ?? 'Mata pelajaran tidak tersedia' }}
                    -
                    - Kelas {{ $jadwal->kelas?->nama_kelas ?? 'Kelas tidak tersedia' }}
                    - Jurusan {{ $jadwal->kelas?->jurusan?->nama_jurusan ?? 'Jurusan tidak tersedia' }}
                </p>
            </div>

            <a href="{{ route('guru.penilaian.index') }}" class="btn btn-secondary">
                Kembali
            </a>

        </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('guru.penilaian.store', $jadwal->id) }}" method="POST">

            @csrf

            <div class="mb-3">

                <label class="form-label">
                    Jenis Nilai
                </label>

                <select name="jenis_nilai" class="form-select" style="max-width: 300px;" required>

                    <option value="">-- Pilih --</option>

                    <option value="harian">
                        Harian
                    </option>

                    <option value="ujian">
                        Ujian
                    </option>

                </select>

            </div>

            <div class="card">

                <div class="card-body p-0">

                    <div class="table-responsive">

                        <table class="table table-bordered mb-0">

                            <thead>
                                <tr>
                                    <th width="60">No</th>
                                    <th>NIS</th>
                                    <th>Nama Siswa</th>
                                    <th width="150">Nilai</th>
                                </tr>
                            </thead>

                            <tbody>

                                @foreach ($siswa as $index => $item)

                                    <tr>

                                        <td>
                                            {{ $index + 1 }}
                                        </td>

                                        <td>
                                            {{ $item->nisn }}
                                        </td>

                                        <td>
                                            {{ $item->nama_lengkap }}
                                        </td>

                                        <td>

                                            <input type="number" name="nilai[{{ $item->id }}]" class="form-control" min="0"
                                                max="100" step="0.01" placeholder="0-100">

                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                </div>

            </div>

            <div class="mt-3">

                <button type="submit" class="btn btn-primary">
                    Simpan Semua Nilai
                </button>

            </div>

        </form>

    </div>

@endsection