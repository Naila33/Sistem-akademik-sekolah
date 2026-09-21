<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sakit;
use Illuminate\Http\Request;

class SakitController extends Controller
{
    public function index(Request $request)
    {
        $query = Sakit::with([
            'siswa',
            'guru.guru',
            'guru.jadwal'
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



        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }

        $sakit = $query
            ->latest('id')
            ->paginate(20)
            ->appends($request->query());



        return view(
            'admin.sakit.index',
            compact('sakit')
        );
    }


    public function show($id)
    {
        $sakit = Sakit::with([
            'siswa',
            'guru.guru',
            'guru.jadwal'
        ])->findOrFail($id);

        return view(
            'admin.sakit.show',
            compact('sakit')
        );
    }
}