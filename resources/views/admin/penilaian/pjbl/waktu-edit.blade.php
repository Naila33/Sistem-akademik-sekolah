@extends('layouts.app')

@section('title', 'Atur Batas Waktu Penilaian')

@section('content')
    <div class="container-fluid py-4">
        <div class="mb-4">
            <h3 class="fw-bold">Atur Batas Waktu Penilaian</h3>
            <p class="text-muted mb-0">Tentukan kapan semua guru dapat memasukkan nilai PJBL.</p>
        </div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="card border-0 shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.penilaian.pjbl.waktu.update') }}" method="POST">
                    @csrf
                    @method('PUT')

                    @include('admin.penilaian.pjbl.waktu-create')

                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.penilaian.pjbl.index') }}" class="btn btn-secondary">
                            Kembali
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Simpan Waktu
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection