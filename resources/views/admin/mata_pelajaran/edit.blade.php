<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Edit Mata Pelajaran</title>

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
            background-color: #0d6efd;
            color: white;
        }

        .btn-kembali {
            background-color: #6c757d;
            color: white;
            margin-left: 5px;
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Edit Mata Pelajaran</h1>

    <form action="{{ route('mata_pelajaran.update', $mata_pelajaran->id) }}" method="POST">

        @csrf
        @method('PUT')

        <div class="form-group">
            <label>Kode Mata Pelajaran</label>

            <input
                type="text"
                name="kode_mapel"
                value="{{ $mata_pelajaran->kode_mapel }}"
                required
            >
        </div>

        <div class="form-group">
            <label>Nama Mata Pelajaran</label>

            <input
                type="text"
                name="nama_mapel"
                value="{{ $mata_pelajaran->nama_mapel }}"
                required
            >
        </div>

        <button type="submit" class="btn btn-simpan">
            Simpan Perubahan
        </button>

        <a href="{{ route('mata_pelajaran.index') }}" class="btn btn-kembali">
            Kembali
        </a>

    </form>

</div>

</body>
</html>