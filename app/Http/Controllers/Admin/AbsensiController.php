<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absen;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    public function index(Request $request)
    {
        $query = Absen::with([
            'siswa',
            'sesi.jadwal'
        ]);

        // Live search nama siswa
        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {
                $q->where('nama', 'like', '%' . $search . '%');
            });
        }

        // Filter status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $absensi = $query
            ->latest('jam_masuk')
            ->paginate(20)
            ->appends($request->query());

        return view('admin.absensi.index', compact('absensi'));
    }
}