@extends('layouts.app')

@section('content')

<div class="container py-4">

    <div class="card shadow-sm border-0">
        <div class="card-body">

            <h4 class="fw-bold mb-2">Absensi</h4>
            <p class="text-muted">
                Masukkan kode absensi yang diberikan oleh guru.
            </p>

            <form action="{{ route('siswa.absensi.submit') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label for="token" class="form-label">
                        Kode Absensi
                    </label>

                    <input
                        type="text"
                        name="token"
                        id="token"
                        class="form-control"
                        placeholder="Masukkan kode absensi"
                        autocomplete="off"
                        required
                    >
                </div>

                <button type="submit" class="btn btn-primary">
                    Absen
                </button>
            </form>

        </div>
    </div>

</div>

@endsection