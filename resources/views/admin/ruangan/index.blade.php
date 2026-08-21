<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Ruangan</title>

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
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        h1 {
            margin: 0;
        }

        .btn-tambah {
            background-color: #198754;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 6px;
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

        .aktif {
            color: green;
            font-weight: bold;
        }

        .tidak-aktif {
            color: red;
            font-weight: bold;
        }

        .btn-edit {
            color: #0d6efd;
            text-decoration: none;
        }

        .btn-hapus {
            color: red;
            text-decoration: none;
        }
    </style>
</head>

<body>

    <div class="container">

        <div class="header">
            <h1>Data Ruangan</h1>

            <a href="{{ route('ruangan.create') }}" class="btn-tambah">
                + Tambah Ruangan
            </a>
        </div>

        <table>
            <tbody>

    @forelse ($ruangan as $index => $r)
        <tr>
            <td>{{ $index + 1 }}</td>

            <td>{{ $r->kode_ruang }}</td>

            <td>{{ $r->nama_ruang }}</td>

            <td>{{ $r->kapasitas }}</td>

            <td>
                @if ($r->status == 'Aktif')
                    <span class="Aktif">Aktif</span>
                @else
                    <span class="Tidak-aktif">Tidak Aktif</span>
                @endif
            </td>

            <td>
                <a href="{{ route('ruangan.edit', $r->id) }}" class="btn-edit">Edit</a>
                |
                <form action="{{ route('ruangan.destroy', $r->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus ruangan ini?')">
    @csrf @method('DELETE')

    <button type="submit" class="btn-hapus" style="background: none; border: none; padding: 0; cursor: pointer;">
        Hapus
    </button>

</form>
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="6">Belum ada data ruangan.</td>
        </tr>
    @endforelse

</tbody>
        </table>

    </div>

</body>
</html>