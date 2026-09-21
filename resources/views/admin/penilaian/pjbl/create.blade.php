@extends('layouts.app')

@section('title', 'Tambah Penilaian PJBL')

@push('styles')
    <style>
        body {
            background-color: #f8fafc;
            font-family: 'Poppins', sans-serif;
        }

        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
            max-width: 800px;
            margin-left: auto;
            margin-right: auto;
        }

        .academic-header {
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .academic-header h1 {
            font-size: 20px;
            font-weight: 700;
            color: #0f172a;
            margin: 0 0 4px 0;
        }

        .academic-header p {
            font-size: 13px;
            color: #64748b;
            margin: 0;
        }

        .btn-back-link {
            color: #64748b;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 12px;
            transition: color 0.2s;
        }

        .btn-back-link:hover {
            color: #2563eb;
        }

        /* Form Controls Styling */
        .form-group-custom {
            margin-bottom: 18px;
        }

        .form-group-custom label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .form-group-custom .form-control,
        .form-group-custom .form-select {
            width: 100%;
            padding: 9px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .form-group-custom .form-control:focus,
        .form-group-custom .form-select:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        /* Buttons */
        .btn-action-primary {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background: #1d4ed8;
            color: #ffffff;
        }

        .btn-action-secondary {
            background: #f1f5f9;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 18px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
        }

        .btn-action-secondary:hover {
            background: #e2e8f0;
            color: #1e293b;
        }
    </style>
@endpush

@section('content')
    <div class="academic-container">
        <div class="academic-card">


        
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

                <form action="{{ route('admin.penilaian.pjbl.store', [
        'kelasId' => $kelas->id,
        'pjblId' => $pjbl->id,
    ]) }}" method="POST">

                    @csrf


                    
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Siswa
                        </label>

                        <select name="siswa_id" class="form-select" required>

                            <option value="">
                                -- Pilih Siswa --
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group-custom">
                    <label for="pjbl_id">PJBL <span class="text-danger">*</span></label>
                    <select name="pjbl_id" id="pjbl_id" class="form-select" required>
                        <option value="{{ $pjbl->id }}" selected>
                            PJBL - {{ ucfirst(str_replace('_', ' ', $pjbl->periode)) }}
                            @if($pjbl->tahunAjaran)
                                - {{ $pjbl->tahunAjaran->tahun_ajaran }}
                            @endif
                        </option>
                    </select>
                </div>

                <div class="form-group-custom">
                    <label for="kelas_id">Kelas <span class="text-danger">*</span></label>
                    <select name="kelas_id" id="kelas_id" class="form-select" required>
                        <option value="{{ $kelas->id }}" selected>
                            {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
                        </option>
                    </select>
                </div>

                                    {{ $item->nama }}
                                    @if(!empty($item->nis))
                                        ({{ $item->nis }})
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            PJBL
                        </label>

                        <select name="pjbl_id" class="form-select" required>

                            <option value="">
                                -- Pilih Semester PJBL --
                            </option>
                        @endforeach
                    </select>
                </div>


                    
                    <div class="mb-3">

                <div class="d-flex gap-2 justify-content-end pt-3 border-top">
                    <a href="{{ route('admin.penilaian.pjbl.penilaian', ['kelasId' => $kelas->id, 'pjblId' => $pjbl->id]) }}"
                        class="btn-action-secondary"> Batal
                    </a>
                    <button type="submit" class="btn-action-primary">Simpan Penilaian
                    </button>
                </div>

                        <select name="kelas_id" class="form-select" required>

                            <option value="">
                                -- Pilih Kelas --
                            </option>

                            @foreach($kelas as $item)

                                <option value="{{ $item->id }}" {{ old('kelas_id') == $item->id ? 'selected' : '' }}>

                                    {{ $item->tingkat }}
                                    {{ $item->nama_kelas }}

                                </option>

                            @endforeach

                        </select>

                    </div>


                    
                    <div class="mb-3">

                        <label class="form-label fw-semibold">
                            Penguji PJBL
                        </label>

                        <select name="pjbl_penguji_id" class="form-select" required>

                            <option value="">
                                -- Pilih Penguji --
                            </option>

                            @foreach($penguji as $item)

                                <option value="{{ $item->id }}" {{ old('pjbl_penguji_id') == $item->id ? 'selected' : '' }}>

                                    {{ $item->guru?->nama ?? 'Guru #' . $item->guru_id }}

                                    @if($item->guru?->nip)
                                        - NIP {{ $item->guru->nip }}
                                    @endif

                                </option>

                            @endforeach

                        </select>

                    </div>


                    
                    <div class="mb-4">

                        <label class="form-label fw-semibold">
                            Nilai
                        </label>

                        <input type="number" name="nilai" class="form-control" min="0" max="100" step="0.01"
                            value="{{ old('nilai') }}" placeholder="Masukkan nilai 0 - 100" required>

                    </div>


                    
                    <div class="d-flex gap-2">

                        <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn btn-secondary">

                            <i class="bi bi-arrow-left"></i>
                            Kembali

                        </a>

                        <button type="submit" class="btn btn-success">

                            <i class="bi bi-save"></i>
                            Simpan

                        </button>

                    </div>

                </form>

            </div>

        </div>
    </div>
@endsection