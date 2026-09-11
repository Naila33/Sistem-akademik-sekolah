@extends('layouts.app')

@section('content')

    <div class="container py-4">

        <div class="card shadow-sm">
            <div class="card-body">

                <h4 class="mb-3">Absensi Siswa</h4>

                {{-- Informasi Jadwal --}}
                <div class="mb-4">
                    <p class="mb-1">
                        <strong>Mata Pelajaran:</strong>
                        {{ $jadwal->mataPelajaran->nama_mapel ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Kelas:</strong>
                        {{ $jadwal->kelas->nama_kelas ?? '-' }}
                    </p>

                    <p class="mb-1">
                        <strong>Jam Pelajaran:</strong>
                        JP
                        {{ $jadwal->jamPelajaran->jp ?? '-' }}-{{ ($jadwal->jamPelajaran->jp ?? 0) + ($jadwal->jumlah_jp ?? 1) - 1 }}
                    </p>

                    <p class="mb-0">
                        <strong>Tanggal:</strong>
                        {{ now()->format('d-m-Y') }}
                    </p>
                </div>


                {{-- Pesan Berhasil --}}
                @if(session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif


                {{-- Pesan Error --}}
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif


                {{-- Jika sesi sudah dibuka / baru dibuka --}}
                @if($sesi)

                    <div class="text-center my-4 p-3 bg-light rounded">
                        <p class="mb-2">
                            <strong>Kode Absensi</strong>
                        </p>

                        <h1 class="fw-bold text-primary">
                            {{ $sesi->token }}
                        </h1>

                        <p class="text-muted mb-0">
                            Berikan kode ini kepada siswa untuk melakukan absensi.
                        </p>
                    </div>

                    {{-- Tabel Absensi --}}
                    <h5 class="mt-4 mb-3">Data Absensi Siswa</h5>
                    <div class="table-responsive">
                        <table class="table table-striped table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th width="5%">No</th>
                                    <th width="12%">NIS</th>
                                    <th width="30%">Nama Siswa</th>
                                    <th width="15%">Status</th>
                                    <th width="18%">Jam Masuk</th>
                                    <th width="20%">Keterangan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sesi->absensi ?? [] as $absen)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $absen->siswa?->nis ?? '-' }}</td>
                                        <td>{{ $absen->siswa?->nama ?? 'N/A' }}</td>
                                        <td>
                                            <span class="badge 
                                                            @if($absen->status == 'hadir') bg-success
                                                            @elseif($absen->status == 'izin') bg-warning text-dark
                                                            @elseif($absen->status == 'sakit') bg-info
                                                            @else bg-danger
                                                            @endif">
                                                {{ ucfirst($absen->status) ?? 'Belum Absen' }}
                                            </span>
                                        </td>
                                        <td>{{ $absen->jam_masuk ?? '-' }}</td>
                                        <td>{{ $absen->keterangan ?? '-' }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-4">
                                            <em>Sesi absensi telah dibuka. Menunggu siswa melakukan absensi...</em>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                @else

                    {{-- Tombol buka absensi --}}
                    <form action="{{ route('absensi.buka', $jadwal->id) }}" method="POST">
                        @csrf

                        <button type="submit" class="btn btn-primary">
                            Buka Absensi
                        </button>
                    </form>

                @endif

            </div>
        </div>

    </div>

@endsection