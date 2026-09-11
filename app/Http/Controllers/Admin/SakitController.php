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

        /*
        |--------------------------------------------------------------------------
        | LIVE SEARCH
        |--------------------------------------------------------------------------
        */

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


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where(
                'status',
                $request->status
            );

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $sakit = $query
            ->latest('id')
            ->paginate(20)
            ->withQueryString();


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