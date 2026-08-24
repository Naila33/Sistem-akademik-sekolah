<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Tahun Ajaran</title>
</head>

<body>
    <h1>Edit Tahun Ajaran</h1>@if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <form action="{{ route('tahun-ajaran.update', $tahunAjaran->id) }}" method="POST">@csrf @method('PUT')
        <p><label>Tahun Ajaran<br><input name="tahun_ajaran" value="{{ old('tahun_ajaran', $tahunAjaran->tahun_ajaran) }}" maxlength="9" required></label></p>
        <p><label>Semester<br><select name="semester" required>
                    <option value="Ganjil" @selected(old('semester', $tahunAjaran->semester) === 'Ganjil')>Ganjil</option>
                    <option value="Genap" @selected(old('semester', $tahunAjaran->semester) === 'Genap')>Genap</option>
                </select></label></p>
        <p><label><input type="checkbox" name="status" value="1" @checked(old('status', $tahunAjaran->status))> Aktif</label></p>
        <button type="submit">Simpan Perubahan</button> <a href="{{ route('tahun-ajaran.index') }}">Kembali</a>
    </form>
</body>

</html>