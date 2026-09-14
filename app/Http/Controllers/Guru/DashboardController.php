<?php

namespace App\Http\Controllers\Guru;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        $guru = auth()->user()->guru;

        return view('guru.dashboard', compact('guru'));
    }
}
