<!DOCTYPE html>
<html>
<head>
    <title>Login Sistem Sekolah</title>
</head>
<body>

    <h2>Login Sistem Sekolah</h2>

    @if ($errors->any())
        <div>
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('login.proses') }}" method="POST">
        @csrf

        <div>
            <label>Username</label>
            <input
                type="text"
                name="username"
                value="{{ old('username') }}"
                required
            >
        </div>

        <br>

        <div>
            <label>Password</label>
            <input
                type="password"
                name="password"
                required
            >
        </div>

        <br>

        <button type="submit">
            Login
        </button>
    </form>

</body>
</html>