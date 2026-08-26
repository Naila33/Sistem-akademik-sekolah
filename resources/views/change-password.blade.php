<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Ganti Password</title>
</head>
<body>

    <h1>Ganti Password</h1>

    @if(session('success'))
        <p>{{ session('success') }}</p>
    @endif

    @if($errors->any())
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('password.update') }}" method="POST">
        @csrf

        <p>
            <label>Password Lama</label><br>
            <input type="password" name="current_password" required>
        </p>

        <p>
            <label>Password Baru</label><br>
            <input type="password" name="password" required>
        </p>

        <p>
            <label>Konfirmasi Password Baru</label><br>
            <input type="password" name="password_confirmation" required>
        </p>

        <button type="submit">
            Simpan Password Baru
        </button>
    </form>

</body>
</html>