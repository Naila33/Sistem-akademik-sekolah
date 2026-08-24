<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Tahun Ajaran</title>
</head>

<body>
    <h1>Tambah Tahun Ajaran</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('tahun-ajaran.store') }}" method="POST">@csrf
        <p><label>Tahun Ajaran<br><input name="tahun_ajaran" value="{{ old('tahun_ajaran') }}" maxlength="9" placeholder="2026/2027" required></label></p>
        <p><label>Semester<br><select name="semester" required>
                    <option value="">Pilih semester</option>
                    <option>Ganjil</option>
                    <option>Genap</option>
                </select></label></p>
        <p><label><input type="checkbox" name="status" value="1"> Aktif</label></p>
        <button type="submit">Simpan</button> <a href="{{ route('tahun-ajaran.index') }}">Kembali</a>
    </form>
</body>

</html>