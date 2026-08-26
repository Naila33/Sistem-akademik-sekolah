<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <title>Pembagian Kelas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            margin-left: 250px;
            padding: 60px;
            color: #212529;
        }

        .container {
            background-color: white;
            padding: 25px;
            border-radius: 10px;
        }

        .header {
            margin-bottom: 20px;
        }

        h1 {
            margin: 0 0 5px;
        }

        .header p {
            color: #666;
            margin: 0;
        }

        .success {
            background-color: #d1e7dd;
            color: #0f5132;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #f8d7da;
            color: #842029;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .import-box {
            background-color: #f8f9fa;
            border: 1px solid #ddd;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .import-box h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .import-box p {
            color: #666;
            margin-top: 0;
        }

        .import-form {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .import-form input[type="file"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: white;
        }

        .btn-import {
            background-color: #198754;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-import:hover {
            background-color: #157347;
        }

        .btn-manual {
            background-color: #0d6efd;
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 5px;
        }

        .btn-manual:hover {
            background-color: #0b5ed7;
        }

        .import-error {
            background-color: #fff3cd;
            color: #664d03;
            padding: 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .import-error ul {
            margin-bottom: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f0f0f0;
        }

        .btn-edit {
            color: #0d6efd;
            text-decoration: none;
        }

        .btn-hapus {
            color: red;
            background: none;
            border: none;
            padding: 0;
            cursor: pointer;
            font-size: inherit;
        }

        .pagination {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 5px;
        }

        .pagination a,
        .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 5px;
            text-decoration: none;
            color: #333;
        }

        .pagination .active {
            background-color: #198754;
            color: white;
            border-color: #198754;
        }

        .pagination .disabled {
            color: #aaa;
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>

    @include('layouts.sidebar')

    <div class="container">

        <div class="header">
            <h1>Pembagian Kelas</h1>
            <p>Daftar siswa berdasarkan kelas yang telah ditentukan.</p>
        </div>


        {{-- Pesan berhasil --}}
        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Pesan error --}}
        @if (session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif


        {{-- Hasil data yang gagal diimport --}}
        @if (session('gagal_import'))
            <div class="import-error">

                <strong>Data yang tidak berhasil diimport:</strong>

                <ul>
                    @foreach (session('gagal_import') as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>

            </div>
        @endif


        {{-- Import Excel --}}
        <div class="import-box">

            <h3>Import Pembagian Kelas</h3>

            <p>
                Upload file Excel dengan format:
                <strong>NIS</strong> dan <strong>Kelas</strong>.
            </p>

            <form action="{{ route('pembagian_kelas.import') }}" method="POST" enctype="multipart/form-data"
                class="import-form">

                @csrf

                <input type="file" name="file" accept=".xlsx,.xls,.csv" required>

                <button type="submit" class="btn-import">
                    Import Excel
                </button>

                <a href="{{ route('pembagian_kelas.create') }}" class="btn-manual">
                    + Pembagian Manual
                </a>

            </form>

        </div>


        {{-- Tabel pembagian kelas --}}
        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>NIS</th>
                    <th>Nama Siswa</th>
                    <th>Tingkat</th>
                    <th>Kelas</th>
                    <th>Jurusan</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>

                @forelse ($pembagian as $index => $item)

                    <tr>

                        <td>
                            {{ $pembagian->firstItem() + $index }}
                        </td>

                        <td>
                            {{ $item->siswa?->nisn ?? '-' }}
                        </td>

                        <td>
                            {{ $item->siswa?->nama_lengkap ?? 'Data siswa tidak tersedia' }}
                        </td>

                        <td>
                            {{ $item->kelas->tingkat }}
                        </td>

                        <td>
                            {{ $item->kelas->nama_kelas }}
                        </td>

                        <td>
                            {{ $item->kelas->jurusan?->nama_jurusan ?? 'Jurusan belum dipilih' }}
                        </td>

                        <td>

                            <a href="{{ route('pembagian_kelas.edit', $item->id) }}" class="btn-edit">
                                Edit
                            </a>

                            |

                            <form action="{{ route('pembagian_kelas.destroy', $item->id) }}" method="POST"
                                style="display: inline;"
                                onsubmit="return confirm('Yakin ingin mengeluarkan siswa dari kelas ini?')">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-hapus">
                                    Hapus
                                </button>

                            </form>

                        </td>

                    </tr>

                @empty

                    <tr>
                        <td colspan="6" style="text-align: center;">
                            Belum ada pembagian kelas.
                        </td>
                    </tr>

                @endforelse

            </tbody>

        </table>


        {{-- Pagination --}}
        @if ($pembagian->hasPages())

            <div class="pagination">

                @if ($pembagian->onFirstPage())

                    <span class="disabled">
                        ← Previous
                    </span>

                @else

                    <a href="{{ $pembagian->previousPageUrl() }}">
                        ← Previous
                    </a>

                @endif


                @for ($i = 1; $i <= $pembagian->lastPage(); $i++)

                    <a href="{{ $pembagian->url($i) }}" class="{{ $pembagian->currentPage() == $i ? 'active' : '' }}">
                        {{ $i }}
                    </a>

                @endfor


                @if ($pembagian->hasMorePages())

                    <a href="{{ $pembagian->nextPageUrl() }}">
                        Next →
                    </a>

                @else

                    <span class="disabled">
                        Next →
                    </span>

                @endif

            </div>

        @endif

    </div>

</body>

</html>