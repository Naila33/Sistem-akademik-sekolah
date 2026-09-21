<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Dispen;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DispenController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | MENCARI DATA SISWA YANG LOGIN
    |--------------------------------------------------------------------------
    |
    | users.username = datasiswa.nis
    |
    */

    private function siswaLogin()
    {
        $user = Auth::user();

        if (!$user) {
            abort(401);
        }

        $siswa = Siswa::where('nis', $user->username)->first();

        if (!$siswa) {
            abort(403, 'Data siswa tidak ditemukan.');
        }

        return $siswa;
    }


    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $siswa = $this->siswaLogin();

        $query = Dispen::where('siswa_id', $siswa->id);

        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('alasan', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");

            });
        }


        /*
        |--------------------------------------------------------------------------
        | FILTER STATUS
        |--------------------------------------------------------------------------
        */

        if ($request->filled('status')) {

            $query->where('status', $request->status);

        }


        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */

        $dispensasi = $query
            ->latest('created_at')
            ->paginate(10)
            ->appends($request->query());


        return view(
            'siswa.dispen.index',
            compact(
                'dispensasi',
                'siswa'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        $siswa = $this->siswaLogin();

        return view(
            'siswa.dispen.create',
            compact('siswa')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {
        $siswa = $this->siswaLogin();

        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */

        $data = $request->validate([

            'tanggal_mulai' => [
                'required',
                'date',
            ],

            'tanggal_selesai' => [
                'required',
                'date',
                'after_or_equal:tanggal_mulai',
            ],

            'alasan' => [
                'required',
                'string',
                'max:1000',
            ],

            'surat' => [
                'required',
                'file',
                'mimes:pdf,jpg,jpeg,png',
                'max:2048',
            ],

        ]);


        /*
        |--------------------------------------------------------------------------
        | UPLOAD SURAT
        |--------------------------------------------------------------------------
        */

        $namaSurat = null;

        if ($request->hasFile('surat')) {

            $namaSurat = $request->file('surat')
                ->store('dispen', 'public');

        }


        /*
        |--------------------------------------------------------------------------
        | SIMPAN DATA DISPENSASI
        |--------------------------------------------------------------------------
        |
        | siswa_id diambil langsung dari siswa yang sedang login.
        | Jadi siswa tidak bisa mengajukan atas nama siswa lain.
        |
        */

        $dispen = new Dispen();

        $dispen->siswa_id = $siswa->id;

        $dispen->tanggal_mulai =
            $data['tanggal_mulai'];

        $dispen->tanggal_selesai =
            $data['tanggal_selesai'];

        $dispen->alasan =
            $data['alasan'];

        $dispen->surat =
            $namaSurat;

        $dispen->status =
            'disetujui';

        $dispen->save();


        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */

        return redirect()
            ->route('siswa.dispen.index')
            ->with(
                'success',
                'Pengajuan dispensasi berhasil disimpan.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | SHOW
    |--------------------------------------------------------------------------
    */

    public function show($id)
    {
        $siswa = $this->siswaLogin();

        /*
        | Pastikan siswa hanya bisa melihat data dispensasinya sendiri.
        */

        $dispen = Dispen::where(
            'siswa_id',
            $siswa->id
        )->findOrFail($id);


        return view(
            'siswa.dispen.show',
            compact(
                'dispen',
                'siswa'
            )
        );
    }
}