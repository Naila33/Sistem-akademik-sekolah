<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">

    <title>Pembagian Kelas</title>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            margin-left: 250px;
            padding: 60px;
            color: #212529;
            background-color: #f5f6fa;
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
            color: #64748b;
            margin: 0;
        }

        .success {
            background-color: #ecfdf5;
            color: #047857;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #fef2f2;
            color: #b91c1c;
            padding: 10px 15px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .import-box {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
        }

        .import-box h3 {
            margin-top: 0;
            margin-bottom: 8px;
        }

        .import-box p {
            color: #64748b;
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
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            background-color: white;
        }

        .btn-import {
            background-color: #2449a4;
            color: white;
            border: none;
            padding: 9px 15px;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-import:hover {
            background-color: #1e3a8a;
        }

        .btn-manual {
            background-color: #475569;
            color: white;
            text-decoration: none;
            padding: 9px 15px;
            border-radius: 5px;
        }

        .btn-manual:hover {
            background-color: #334155;
        }

        .import-error {
            background-color: #fff7ed;
            color: #c2410c;
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
            border: 1px solid #e5e7eb;
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f1f5fb;
        }

        .btn-edit {
            color: #1d4ed8;
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
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            text-decoration: none;
            color: #475569;
        }

        .pagination .active {
            background-color: #2449a4;
            color: white;
            border-color: #2449a4;
        }

        .pagination .disabled {
            color: #94a3b8;
            background-color: #f8fafc;
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



        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif



        @if (session('error'))
            <div class="error">
                {{ session('error') }}
            </div>
        @endif



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



        <div class="import-box">

            <h3>Import Pembagian Kelas</h3>

            <p>
                Upload file Excel dengan format:
                <strong>NISN</strong> dan <strong>Kelas</strong>.
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



        <table>

            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
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
                            {{ $item->siswa?->nama ?? 'Data siswa tidak tersedia' }}
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