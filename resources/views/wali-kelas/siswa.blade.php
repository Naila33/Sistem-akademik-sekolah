@extends('layouts.app')

@section('title', 'Data Siswa')

@section('content')

<div class="page-header">
    <h1>Data Siswa</h1>

    <p>
        Kelas {{ $kelas->tingkat }} {{ $kelas->nama_kelas }}
    </p>
</div>

<div class="card">

    <div style="margin-bottom: 20px;">
        <a href="{{ route('wali-kelas.index') }}" class="btn btn-secondary">
            ← Kembali
        </a>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>No</th>
                    <th>NISN</th>
                    <th>Nama Siswa</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse($siswa as $item)

                    <tr>
                        <td>{{ $loop->iteration }}</td>

                        <td>
                            {{ optional($item->siswa)->nisn ?? '-' }}
                        </td>

                        <td>
                            {{ optional($item->siswa)->nama ?? '-' }}
                        </td>

                        <td>
                            @if($item->siswa)

                                <a
                                    href="{{ route('wali-kelas.nilai', $item->siswa->id) }}"
                                    class="btn btn-primary"
                                >
                                    Nilai
                                </a>

                                <a
                                    href="{{ route('wali-kelas.rapor', $item->siswa->id) }}"
                                    class="btn btn-secondary"
                                >
                                    Rapor
                                </a>

                            @endif
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="4">
                            Belum ada siswa di kelas ini.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>
    </div>

</div>

@endsection