@extends('layouts.app')

@section('title', 'Ganti Password')

@push('styles')
   <style>
    </style>
@endpush

@section('content')
    <div class="password-page">
        <div class="password-header">
            <h1><i class="bi bi-shield-lock me-2 text-primary"></i>Ganti Password</h1>
            <p>Perbarui password akunmu secara berkala agar tetap aman.</p>
        </div>

        @if (session('success'))
            <div class="alert alert-success d-flex align-items-center gap-2" role="alert">
                <i class="bi bi-check-circle-fill"></i><span>{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" role="alert">
                <div class="d-flex align-items-center gap-2 mb-2">
                    <i class="bi bi-exclamation-triangle-fill"></i><strong>Password belum dapat diubah.</strong>
                </div>
                <ul class="mb-0 ps-4">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card password-card shadow-sm">
            <div class="card-body p-4 p-md-5">
                <form action="{{ route('password.update') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="current_password" class="form-label">Password Lama</label>
                        <input type="password" id="current_password" name="current_password"
                            class="form-control @error('current_password') is-invalid @enderror"
                            autocomplete="current-password" required>
                        @error('current_password')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password Baru</label>
                        <input type="password" id="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" autocomplete="new-password"
                            minlength="8" required>
                        @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Gunakan minimal 8 karakter.</div>
                    </div>

                    <div class="mb-0">
                        <label for="password_confirmation" class="form-label">Konfirmasi Password Baru</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" class="form-control"
                            autocomplete="new-password" minlength="8" required>
                    </div>

                    <div class="password-actions">
                        <a href="{{ route('siswa.dashboard') }}" class="btn btn-light border"><i
                                class="bi bi-arrow-left me-1"></i>Kembali</a>
                        <button type="submit" class="btn btn-primary"><i class="bi bi-check2-circle me-1"></i>Simpan
                            Password</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection