<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Tambah Ruangan</title>

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
            max-width: 600px;
            margin: auto;
        }

        h1 {
            margin-top: 0;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 6px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 15px;
            border-radius: 6px;
            text-decoration: none;
            border: none;
            cursor: pointer;
        }

        .btn-simpan {
            background-color: #198754;
            color: white;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            margin-left: 5px;
        }

        .error {
            color: red;
            margin-bottom: 15px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Tambah Ruangan</h1>

    @if ($errors->any())
        <div class="error">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('ruangan.store') }}" method="POST">

        @csrf

        <div class="form-group">
            <label>Kode Ruang</label>

            <input
                type="text"
                name="kode_ruang"
                value="{{ old('kode_ruang') }}"
                placeholder="Contoh: R001"
                required
            >
        </div>

        <div class="form-group">
            <label>Nama Ruang</label>

            <input
                type="text"
                name="nama_ruang"
                value="{{ old('nama_ruang') }}"
                placeholder="Contoh: Lab RPL 1"
                required
            >
        </div>

        <div class="form-group">
            <label>Kapasitas</label>

            <input
                type="number"
                name="kapasitas"
                value="{{ old('kapasitas') }}"
                placeholder="Contoh: 36"
                min="1"
                required
            >
        </div>

        <div class="form-group">
            <label>Status</label>

            <select name="status" required>
                <option value="">-- Pilih Status --</option>
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

        <button type="submit" class="btn btn-simpan">
            Simpan
        </button>

        <a href="{{ route('ruangan.index') }}" class="btn btn-kembali">
            Kembali
        </a>

    </form>

</div>

</body>
</html>