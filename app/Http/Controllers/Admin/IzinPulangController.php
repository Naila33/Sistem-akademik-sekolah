<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\IzinPulang;
use Illuminate\Http\Request;

class IzinPulangController extends Controller
{
    public function index(Request $request)
    {
        $query = IzinPulang::with([
            'siswa'
        ]);


        if ($request->filled('search')) {

            $search = $request->search;

            $query->whereHas('siswa', function ($q) use ($search) {

                $q->where(function ($q) use ($search) {

                    $q->where('nama', 'like', "%{$search}%")
                      ->orWhere('nis', 'like', "%{$search}%")
                      ->orWhere('nisn', 'like', "%{$search}%");

                });

            });

        }


        if ($request->filled('status_kesiswaan')) {

            $query->where(
                'status_kesiswaan',
                $request->status_kesiswaan
            );

        }


        $izinPulang = $query
            ->latest('id')
            ->paginate(20)
            ->appends($request->query());


        return view(
            'admin.izin-pulang.index',
            compact('izinPulang')
        );
    }


    public function show($id)
    {
        $izinPulang = IzinPulang::with([
            'siswa'
        ])->findOrFail($id);


        return view(
            'admin.izin-pulang.show',
            compact('izinPulang')
        );
    }
}