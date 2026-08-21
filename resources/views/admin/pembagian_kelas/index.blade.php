<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Pembagian Kelas</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 30px;
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

    <table>

        <thead>
            <tr>
                <th>No</th>
                <th>NIS</th>
                <th>Nama Siswa</th>
                <th>Tingkat</th>
                <th>Kelas</th>
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
                        {{ $item->siswa->nis }}
                    </td>

                    <td>
                        {{ $item->siswa->nama }}
                    </td>

                    <td>
                        {{ $item->kelas->tingkat }}
                    </td>

                    <td>
                        {{ $item->kelas->nama_kelas }}
                    </td>

                    <td>

                        <a href="{{ route('pembagian-kelas.edit', $item->id) }}"
                           class="btn-edit">
                            Edit
                        </a>

                        |

                        <form
                            action="{{ route('pembagian-kelas.destroy', $item->id) }}"
                            method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Yakin ingin mengeluarkan siswa dari kelas ini?')"
                        >

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
                <span class="disabled">← Previous</span>
            @else
                <a href="{{ $pembagian->previousPageUrl() }}">
                    ← Previous
                </a>
            @endif


            @for ($i = 1; $i <= $pembagian->lastPage(); $i++)

                <a href="{{ $pembagian->url($i) }}"
                   class="{{ $pembagian->currentPage() == $i ? 'active' : '' }}">
                    {{ $i }}
                </a>

            @endfor


            @if ($pembagian->hasMorePages())
                <a href="{{ $pembagian->nextPageUrl() }}">
                    Next →
                </a>
            @else
                <span class="disabled">Next →</span>
            @endif

        </div>

    @endif

</div>

</body>
</html>