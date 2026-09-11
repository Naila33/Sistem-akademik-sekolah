<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perizinan Sakit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <style>
        body {
            margin: 0;
            background: #f5f6fa;
            color: #333;
            font-family: Arial, sans-serif;
        }

        .content {
            margin-left: 250px;
            min-height: 100vh;
            padding: 30px;
        }

        @media (max-width: 768px) {
            .content {
                margin-left: 210px;
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    @include('layouts.sidebar-siswa')

    <main class="content">

        <div class="container-fluid">

            {{-- Header --}}
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Perizinan</h4>
                    <p class="text-muted mb-0">
                        Riwayat pengajuan izin sakit kamu.
                    </p>
                </div>

                <a href="{{ route('siswa.perizinan.sakit.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Ajukan perizinan
                </a>
            </div>


            {{-- Alert sukses --}}
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}

                    <button type="button" class="btn-close" data-bs-dismiss="alert">
                    </button>
                </div>
            @endif


            {{-- Error --}}
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif


            {{-- Tabel --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    <div class="table-responsive">

                        <table class="table align-middle">

                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <th>Alasan</th>
                                    <th>Dokumen</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>

                            <tbody>

                                @forelse($dataSakit as $item)

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            {{ $item->tanggal?->format('d M Y') }}
                                        </td>


                                        <td>
                                            {{ $item->alasan }}
                                        </td>

                                        <td>

                                            @if($item->dokumen)

                                                <a href="{{ asset('storage/' . $item->dokumen) }}" target="_blank"
                                                    class="btn btn-sm btn-outline-secondary">
                                                    <i class="fas fa-file"></i>
                                                    Lihat
                                                </a>

                                            @else

                                                <span class="text-muted">
                                                    Tidak ada
                                                </span>

                                            @endif

                                        </td>

                                        <td>

                                            @if($item->status === 'menunggu_walikelas')

                                                <span class="badge bg-warning text-dark">
                                                    Menunggu Wali Kelas
                                                </span>

                                            @elseif($item->status === 'disetujui_walikelas')

                                                <span class="badge bg-success">
                                                    Disetujui
                                                </span>

                                            @elseif($item->status === 'ditolak_walikelas')

                                                <span class="badge bg-danger">
                                                    Ditolak
                                                </span>

                                            @else

                                                <span class="badge bg-secondary">
                                                    {{ $item->status }}
                                                </span>

                                            @endif

                                        </td>

                                        <td>
                                            @if($item->status === 'menunggu_walikelas')
                                                <div class="d-flex gap-1">
                                                    <a href="{{ route('siswa.perizinan.sakit.edit', $item->id) }}"
                                                        class="btn btn-sm btn-outline-primary">
                                                        Edit
                                                    </a>

                                                    <form action="{{ route('siswa.perizinan.sakit.destroy', $item->id) }}"
                                                        method="POST" onsubmit="return confirm('Hapus pengajuan sakit ini?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="6" class="text-center text-muted py-5">

                                            Belum ada pengajuan sakit.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                </div>
            </div>

        </div>

    </main>

</body>

</html>