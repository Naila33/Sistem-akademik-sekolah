@extends('layouts.app')

@section('title', 'Input Nilai')

@section('content')

<div class="page-header">
    <h1>Input Nilai Harian</h1>

    <p>
        {{ $jadwal->kelas->tingkat ?? '-' }}
        {{ $jadwal->kelas->nama_kelas ?? '-' }}
        —
        {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
    </p>
</div>

<div class="card">

    
    <div class="schedule-info">
        <div>
            <strong>Hari</strong>
            <span>{{ $jadwal->hari }}</span>
        </div>

        <div>
            <strong>Jam Pelajaran</strong>
            <span>JP {{ $jadwal->jp_mulai }}–{{ $jadwal->jp_selesai }}</span>
        </div>

        <div>
            <strong>Mata Pelajaran</strong>
            <span>
                {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
            </span>
        </div>
    </div>

    <form
        action="{{ route('wali-kelas.simpan-nilai', $jadwal->id) }}"
        method="POST"
    >
        @csrf

        <div class="table-wrapper">

            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NISN</th>
                        <th>Nama Siswa</th>
                        <th>Nilai Harian</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($siswa as $item)

                        @php
                            $siswaData = $item->siswa;
                            $nilaiSiswa = $nilai->get($siswaData->id);
                        @endphp

                        <tr>

                            <td>
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $siswaData->nisn ?? '-' }}
                            </td>

                            <td>
                                {{ $siswaData->nama ?? '-' }}
                            </td>

                            <td>

                                <input
                                    type="number"
                                    name="nilai[{{ $siswaData->id }}]"
                                    value="{{ old(
                                        'nilai.' . $siswaData->id,
                                        $nilaiSiswa->nilai ?? ''
                                    ) }}"
                                    min="0"
                                    max="100"
                                    step="0.01"
                                    placeholder="0–100"
                                    class="nilai-input"
                                >

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="4" class="empty">
                                Belum ada siswa di kelas ini.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

        @if($siswa->isNotEmpty())

            <div class="form-actions">

                <a
                    href="{{ route('wali-kelas.kelas-mengajar') }}"
                    class="btn btn-secondary"
                >
                    Kembali
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                >
                    Simpan Nilai
                </button>

            </div>

        @endif

    </form>

</div>

@endsection


@push('styles')

<style>

    .schedule-info {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
        margin-bottom: 25px;
    }

    .schedule-info div {
        background: 
        border: 1px solid 
        border-radius: 8px;
        padding: 14px;
    }

    .schedule-info strong {
        display: block;
        font-size: 12px;
        color: 
        margin-bottom: 6px;
    }

    .schedule-info span {
        font-size: 14px;
        font-weight: 600;
    }

    .nilai-input {
        width: 100px;
        padding: 8px 10px;
        border: 1px solid 
        border-radius: 6px;
        font-size: 14px;
    }

    .nilai-input:focus {
        outline: none;
        border-color: 
    }

    .form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        margin-top: 20px;
    }

    .empty {
        text-align: center;
        color: 
        padding: 30px;
    }

    @media (max-width: 768px) {

        .schedule-info {
            grid-template-columns: 1fr;
        }

    }

</style>

@endpush