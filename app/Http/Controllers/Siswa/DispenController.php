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

        $siswa = Siswa::where(
            'nis',
            $user->username
        )->first();

        if (!$siswa) {
            abort(
                403,
                'Data siswa tidak ditemukan.'
            );
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

        $query = Dispen::where(
            'siswa_id',
            $siswa->id
        );


        /*
        |--------------------------------------------------------------------------
        | SEARCH
        |--------------------------------------------------------------------------
        */

        if ($request->filled('search')) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where(
                    'alasan',
                    'like',
                    "%{$search}%"
                )
                ->orWhere(
                    'status',
                    'like',
                    "%{$search}%"
                );

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

    $data = $request->validate([
        'nama_siswa' => [
            'required',
            'string',
        ],

        'nis' => [
            'required',
            'string',
        ],

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
    | UPLOAD SURAT DISPENSASI DARI KESISWAAN
    |--------------------------------------------------------------------------
    */

    $namaSurat = null;

    if ($request->hasFile('surat')) {

        $namaSurat = $request->file('surat')
            ->store('dispen', 'public');
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN PENGAJUAN
    |--------------------------------------------------------------------------
    |
    | Karena surat sudah berasal dari kesiswaan,
    | pengajuan otomatis dianggap disetujui.
    |
    */

    Dispen::create([

        'siswa_id' =>
            $siswa->id,

        'tanggal_mulai' =>
            $data['tanggal_mulai'],

        'tanggal_selesai' =>
            $data['tanggal_selesai'],

        'alasan' =>
            $data['alasan'],

        'surat' =>
            $namaSurat,

        'status' =>
            'disetujui',

    ]);

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