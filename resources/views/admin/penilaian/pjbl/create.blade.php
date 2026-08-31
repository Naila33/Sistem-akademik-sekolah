@extends('layouts.app')

@section('title', 'Tambah Penilaian PJBL')

@section('content')

<div class="container-fluid py-4">

```
<div class="mb-4">
    <h3 class="fw-bold">Tambah Penilaian PJBL</h3>

    <p class="text-muted">
        Tambahkan nilai PJBL siswa
    </p>
</div>


{{-- ERROR VALIDATION --}}
@if($errors->any())

    <div class="alert alert-danger">

        <ul class="mb-0">

            @foreach($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif


<div class="card border-0 shadow-sm">

    <div class="card-body">

        <form action="{{ route('admin.penilaian.pjbl.store') }}"
              method="POST">

            @csrf


            {{-- SISWA --}}
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Siswa
                </label>

                <select name="siswa_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Siswa --
                    </option>

                    @foreach($siswa as $item)

                        <option value="{{ $item->id }}"
                            {{ old('siswa_id') == $item->id ? 'selected' : '' }}>

                            {{ $item->nama }}
                            @if(!empty($item->nis))
                                ({{ $item->nis }})
                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- PJBL --}}
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    PJBL
                </label>

                <select name="pjbl_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Semester PJBL --
                    </option>

                    @foreach($pjbl as $item)

                        <option value="{{ $item->id }}"
                            {{ old('pjbl_id') == $item->id ? 'selected' : '' }}>

                            PJBL -

                            {{ ucfirst(str_replace('_', ' ', $item->periode)) }}

                            @if($item->tahunAjaran)

                                -
                                {{ $item->tahunAjaran->tahun_ajaran }}

                            @endif

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- KELAS --}}
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Kelas
                </label>

                <select name="kelas_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Kelas --
                    </option>

                    @foreach($kelas as $item)

                        <option value="{{ $item->id }}"
                            {{ old('kelas_id') == $item->id ? 'selected' : '' }}>

                            {{ $item->tingkat }}
                            {{ $item->nama_kelas }}

                        </option>

                    @endforeach

                </select>

            </div>


            {{-- PENGUJI --}}
            <div class="mb-3">

                <label class="form-label fw-semibold">
                    Penguji PJBL
                </label>

                <select name="pjbl_penguji_id"
                        class="form-select"
                        required>

                    <option value="">
                        -- Pilih Penguji --
                    </option>

                    @foreach($penguji as $item)

                        <option value="{{ $item->id }}"
                            {{ old('pjbl_penguji_id') == $item->id ? 'selected' : '' }}>

                            {{ $item->guru?->nama ?? 'Guru #' . $item->guru_id }}

                            @if($item->guru?->nip)
                                - NIP {{ $item->guru->nip }}
                            @endif

                        </option>

                    @endforeach

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
                       value="{{ old('nilai') }}"
                       placeholder="Masukkan nilai 0 - 100"
                       required>

            </div>


            {{-- BUTTON --}}
            <div class="d-flex gap-2">

                <a href="{{ route('admin.penilaian.pjbl.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-arrow-left"></i>
                    Kembali

                </a>

                <button type="submit"
                        class="btn btn-success">

                    <i class="bi bi-save"></i>
                    Simpan

                </button>

            </div>

        </form>

    </div>

</div>
```

</div>

@endsection
