@extends('layouts.app')

@section('title', 'Edit Penilaian PJBL')

@section('content')

<div class="container-fluid py-4">

    <div class="mb-4">
        <h3 class="fw-bold">Edit Penilaian PJBL</h3>
        <p class="text-muted">
            Perbarui nilai PJBL siswa
        </p>
    </div>

    <div class="card border-0 shadow-sm">

        <div class="card-body">

            <form action="{{ route('admin.penilaian.pjbl.update', $penilaian->id) }}"
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
                        PJBL
                    </label>

                    <select name="pjbl_id"
                            class="form-select"
                            required>

                        @foreach($pjbl as $item)

                            <option value="{{ $item->id }}"
                                {{ $penilaian->pjbl_id == $item->id ? 'selected' : '' }}>

                                PJBL #{{ $item->id }}

                                @if($item->kelas)
                                    - {{ $item->kelas->tingkat }}
                                    {{ $item->kelas->nama_kelas }}
                                @endif

                            </option>

                        @endforeach

                    </select>

                </div>


                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        ID Penguji
                    </label>

                    <input type="number"
                           name="pjbl_penguji_id"
                           class="form-control"
                           value="{{ $penilaian->pjbl_penguji_id }}"
                           required>

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

                    <a href="{{ route('admin.penilaian.pjbl.index') }}"
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