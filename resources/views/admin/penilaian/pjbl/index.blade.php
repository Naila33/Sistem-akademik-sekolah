@extends('layouts.app')

@section('title', 'Penilaian PJBL')

@push('styles')
    <style>

        body {
            font-family: 'Poppins', sans-serif;
        }
        
        .academic-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
            margin-bottom: 24px;
        }

        .academic-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 20px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
            flex-wrap: wrap;
            gap: 12px;
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

        .btn-action-primary {
            background-color: #2563eb !important;
            color: #ffffff !important;
            border: 1px solid #2563eb !important;
            padding: 9px 16px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s;
            cursor: pointer;
        }

        .btn-action-primary:hover {
            background-color: #1d4ed8 !important;
            border-color: #1d4ed8 !important;
            color: #ffffff !important;
        }

        .btn-action-secondary {
            background-color: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 8px 12px;
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
            background-color: #f8fafc;
            color: #1e293b;
            border-color: #94a3b8;
        }

        .filter-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            margin-bottom: 20px;
        }

        .filter-field label {
            font-size: 13px;
            font-weight: 600;
            color: #334155;
            margin-bottom: 6px;
            display: block;
        }

        .filter-field select,
        .filter-field input {
            width: 100%;
            padding: 8px 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            background-color: #ffffff;
            font-size: 14px;
            color: #1e293b;
            outline: none;
            transition: all 0.2s;
        }

        .filter-field select:focus,
        .filter-field input:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
        }

        .item-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 20px;
            text-decoration: none;
            display: block;
            transition: all 0.2s ease-in-out;
            height: 100%;
        }

        .item-card:hover {
            border-color: #2563eb;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.12);
            transform: translateY(-2px);
        }

        .item-icon {
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background-color: #eff6ff;
            color: #2563eb;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .item-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .item-subtitle {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 16px;
        }

        .item-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 12px;
            color: #64748b;
            padding-top: 12px;
            border-top: 1px solid #f1f5f9;
        }

        .item-link-text {
            color: #2563eb;
            font-weight: 600;
        }
    </style>
@endpush

@section('content')
<div class="academic-container">
    <div class="academic-card">
        
        <div class="academic-header">
            <div>
                <h1>Penilaian PJBL</h1>
                <p>Pilih kelas untuk melihat penilaian Project Based Learning.</p>
            </div>
            <a href="{{ route('admin.penilaian.pjbl.waktu.edit') }}" class="btn-action-primary">
                <i class="bi bi-clock"></i> Atur Batas Waktu Semua PJBL
            </a>
        </div>

        <div class="filter-section">
            <div class="row g-3 align-items-end">
                <div class="col-md-7 filter-field">
                    <label for="searchKelas">Cari Kelas</label>
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input type="text" id="searchKelas" class="border-start-0 ps-0" placeholder="Cari tingkat, jurusan, atau nama kelas..." autocomplete="off">
                    </div>
                </div>

                <div class="col-md-3 filter-field">
                    <label for="filterTingkat">Jenjang</label>
                    <select id="filterTingkat">
                        <option value="">Semua Jenjang</option>
                        @foreach($kelas->pluck('tingkat')->filter()->unique()->sort() as $tingkat)
                            <option value="{{ $tingkat }}">{{ $tingkat }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2 filter-field">
                    <button type="button" id="resetFilter" class="btn-action-secondary w-100 justify-content-center">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                </div>
            </div>
        </div>

        <div class="mb-3">
            <small class="text-muted">
                Menampilkan <span id="jumlahKelas" class="fw-semibold text-dark">{{ $kelas->count() }}</span> kelas
            </small>
        </div>

        <div class="row g-4" id="kelasContainer">
            @forelse($kelas as $k)
                @php
                    $searchText = strtolower(
                        $k->tingkat . ' ' .
                        ($k->jurusan?->nama_jurusan ?? '') . ' ' .
                        $k->nama_kelas
                    );
                @endphp

                <div class="col-xl-3 col-lg-4 col-md-6 kelas-card" data-search="{{ $searchText }}" data-tingkat="{{ $k->tingkat }}">
                    <a href="{{ route('admin.penilaian.pjbl.kelas', $k->id) }}" class="item-card">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div class="item-icon">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                            <i class="bi bi-arrow-right text-muted"></i>
                        </div>

                        <div class="item-title">
                            {{ $k->tingkat }} {{ $k->nama_kelas }}
                        </div>

                        <div class="item-subtitle">
                            {{ $k->jurusan?->nama_jurusan ?? 'Umum' }}
                        </div>

                        <div class="item-footer">
                            <span>
                                <i class="bi bi-people me-1"></i>
                                {{ $k->siswa_kelas_count }} Siswa
                            </span>
                            <span class="item-link-text">
                                Lihat PJBL
                            </span>
                        </div>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center py-5 border rounded bg-light">
                        <i class="bi bi-mortarboard fs-1 text-muted"></i>
                        <h5 class="mt-3 text-dark">Belum ada data kelas</h5>
                        <p class="text-muted mb-0">Data kelas belum tersedia.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <div id="kelasEmpty" class="card border-0 shadow-sm mt-4" style="display: none;">
            <div class="card-body text-center py-5">
                <i class="bi bi-search fs-1 text-muted"></i>
                <h5 class="mt-3 text-dark">Kelas tidak ditemukan</h5>
                <p class="text-muted mb-0">Coba gunakan kata pencarian atau jenjang yang berbeda.</p>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const searchInput = document.getElementById('searchKelas');
        const filterTingkat = document.getElementById('filterTingkat');
        const resetButton = document.getElementById('resetFilter');
        const cards = document.querySelectorAll('.kelas-card');
        const emptyMessage = document.getElementById('kelasEmpty');
        const jumlahKelas = document.getElementById('jumlahKelas');

        function filterKelas() {
            const keyword = searchInput.value.trim().toLowerCase();
            const tingkat = filterTingkat.value.trim().toLowerCase();
            let jumlahTampil = 0;

            cards.forEach(function (card) {
                const searchText = (card.dataset.search || '').toLowerCase();
                const cardTingkat = (card.dataset.tingkat || '').toLowerCase();

                const cocokSearch = keyword === '' || searchText.includes(keyword);
                const cocokTingkat = tingkat === '' || cardTingkat === tingkat;

                if (cocokSearch && cocokTingkat) {
                    card.style.display = '';
                    jumlahTampil++;
                } else {
                    card.style.display = 'none';
                }
            });

            if (jumlahKelas) {
                jumlahKelas.textContent = jumlahTampil;
            }

            if (emptyMessage) {
                emptyMessage.style.display = jumlahTampil === 0 ? 'block' : 'none';
            }
        }

        if (searchInput) searchInput.addEventListener('input', filterKelas);
        if (filterTingkat) filterTingkat.addEventListener('change', filterKelas);

        if (resetButton) {
            resetButton.addEventListener('click', function () {
                searchInput.value = '';
                filterTingkat.value = '';
                filterKelas();
                searchInput.focus();
            });
        }

        filterKelas();
    });
</script>
@endpush