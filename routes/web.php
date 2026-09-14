<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\PembagianKelasController;
use App\Http\Controllers\JurusanController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\Admin\SpmbController;
use App\Http\Controllers\JadwalpelajaranController;
use App\Http\Controllers\Siswa\JadwalPelajaranController as SiswaJadwalPelajaranController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Guru\PenilaianController;
use App\Http\Controllers\WaliKelasController;
use App\Http\Controllers\Admin\PenilaianPjblController;
use App\Http\Controllers\Admin\AbsensiController;
use App\Http\Controllers\Siswa\AbsensiController as SiswaAbsensiController;
use App\Http\Controllers\Admin\SakitController;
use App\Http\Controllers\Admin\IzinKeluarController;
use App\Http\Controllers\Admin\IzinPulangController;
use App\Http\Controllers\Admin\DispenController;
use App\Http\Controllers\Guru\PenilaianPjblController as GuruPenilaianPjblController;
use App\Http\Controllers\Guru\JadwalController;
use App\Http\Controllers\Admin\JamPelajaranController;
use App\Http\Controllers\Guru\SesiAbsensiController;
use App\Http\Controllers\Siswa\PerizinanController;
use App\Http\Controllers\Siswa\DispenController as SiswaDispenController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Guru\DashboardController as GuruDashboardController;
use App\Http\Controllers\Siswa\DashboardController as SiswaDashboardController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

//login
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');

Route::post('/login', [AuthController::class, 'login'])->name('login.proses');

Route::get('/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('dashboard');

Route::get('/guru/dashboard', [GuruDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('guru.dashboard');

Route::get('/siswa/dashboard', [SiswaDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('siswa.dashboard');

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('/ganti-password', [AuthController::class, 'showChangePassword'])->middleware('auth')->name('password.change');

Route::post('/ganti-password', [AuthController::class, 'changePassword'])->middleware('auth')->name('password.update');

// DASHBOARD & HOME
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
    ->middleware('auth')
    ->name('admin.dashboard');

Route::view('/admin/master-data', 'admin.master-data.index')->name('master-data.index');

// ADMIN MASTER DATA ROUTES
Route::get('/admin/ruangan', [RuanganController::class, 'index'])->name('ruangan.index');
Route::get('/admin/ruangan/create', [RuanganController::class, 'create'])->name('ruangan.create');
Route::post('/admin/ruangan', [RuanganController::class, 'store'])->name('ruangan.store');
Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])->name('ruangan.edit');
Route::put('/admin/ruangan/{id}', [RuanganController::class, 'update'])->name('ruangan.update');
Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])->name('ruangan.destroy');

Route::get('/admin/mata_pelajaran', [MataPelajaranController::class, 'index'])->name('mata_pelajaran.index');
Route::get('/admin/mata_pelajaran/create', [MataPelajaranController::class, 'create'])->name('mata_pelajaran.create');
Route::post('/admin/mata_pelajaran', [MataPelajaranController::class, 'store'])->name('mata_pelajaran.store');
Route::get('/admin/mata_pelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])->name('mata_pelajaran.edit');
Route::put('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'update'])->name('mata_pelajaran.update');
Route::delete('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'destroy'])->name('mata_pelajaran.destroy');

// PEMBAGIAN KELAS
Route::get('/admin/pembagian_kelas', [PembagianKelasController::class, 'index'])->name('pembagian_kelas.index');
Route::get('/admin/pembagian_kelas/create', [PembagianKelasController::class, 'create'])->name('pembagian_kelas.create');
Route::post('/admin/pembagian_kelas', [PembagianKelasController::class, 'store'])->name('pembagian_kelas.store');
Route::get('/admin/pembagian_kelas/{id}/edit', [PembagianKelasController::class, 'edit'])->name('pembagian_kelas.edit');
Route::put('/admin/pembagian_kelas/{id}', [PembagianKelasController::class, 'update'])->name('pembagian_kelas.update');
Route::delete('/admin/pembagian_kelas/{id}', [PembagianKelasController::class, 'destroy'])->name('pembagian_kelas.destroy');
Route::post('/admin/pembagian_kelas/import', [PembagianKelasController::class, 'import'])->name('pembagian_kelas.import');

// JADWAL PELAJARAN
Route::get('/admin/jadwal_pelajaran', [JadwalpelajaranController::class, 'index'])->name('admin.jadwal_pelajaran.index');
Route::get('/admin/jadwal_pelajaran/create', [JadwalpelajaranController::class, 'create'])->name('admin.jadwal_pelajaran.create');
Route::post('/admin/jadwal_pelajaran', [JadwalpelajaranController::class, 'store'])->name('admin.jadwal_pelajaran.store');
Route::get('/admin/jadwal_pelajaran/export/excel', [JadwalpelajaranController::class, 'exportExcel'])->name('admin.jadwal_pelajaran.export_excel');
Route::get('/admin/jadwal_pelajaran/export/pdf', [JadwalpelajaranController::class, 'exportPdf'])->name('admin.jadwal_pelajaran.export_pdf');
Route::get('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}/edit', [JadwalpelajaranController::class, 'editHari'])->name('admin.jadwal_pelajaran.edit_hari');
Route::put('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}', [JadwalpelajaranController::class, 'updateHari'])->name('admin.jadwal_pelajaran.update_hari');
Route::delete('/admin/jadwal_pelajaran/kelas/{kelasId}/hari/{hari}', [JadwalpelajaranController::class, 'destroyHari'])->name('admin.jadwal_pelajaran.destroy_hari');
Route::get('/admin/jadwal_pelajaran/{id}/edit', [JadwalpelajaranController::class, 'edit'])->name('admin.jadwal_pelajaran.edit');
Route::put('/admin/jadwal_pelajaran/{id}', [JadwalpelajaranController::class, 'update'])->name('admin.jadwal_pelajaran.update');
Route::delete('/admin/jadwal_pelajaran/{id}', [JadwalpelajaranController::class, 'destroy'])->name('admin.jadwal_pelajaran.destroy');
Route::patch('/admin/jadwal-pelajaran/publish', [JadwalPelajaranController::class, 'publish'])
    ->name('admin.jadwal_pelajaran.publish');

// RESOURCE ROUTES
Route::resource('tahun-ajaran', TahunAjaranController::class)->except(['show']);
Route::resource('jurusan', JurusanController::class)->except(['show']);
Route::resource('siswa', SiswaController::class)->except(['show']);
Route::resource('admin/master-data/guru', GuruController::class)
    ->except(['show'])
    ->names('guru');
Route::resource('kelas', KelasController::class)->except(['show']);

// WALI KELAS
Route::middleware('auth')->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('/dashboard', [WaliKelasController::class, 'dashboard'])->name('dashboard');
    Route::get('/', [WaliKelasController::class, 'index'])->name('index');
    Route::get('/siswa/{kelas}', [WaliKelasController::class, 'siswa'])->name('siswa');
    Route::get('/nilai/{siswa}', [WaliKelasController::class, 'nilai'])->name('nilai');
    Route::get('/rapor/{siswa}', [WaliKelasController::class, 'rapor'])->name('rapor');
});

Route::get('/wali-kelas/kelas-mengajar', [WaliKelasController::class, 'kelasMengajar'])
    ->name('wali-kelas.kelas-mengajar');

Route::get(
    '/wali-kelas/input-nilai/{jadwal}',
    [WaliKelasController::class, 'inputNilai']
)->name('wali-kelas.input-nilai');

Route::post(
    '/wali-kelas/input-nilai/{jadwal}',
    [WaliKelasController::class, 'simpanNilai']
)->name('wali-kelas.simpan-nilai');

Route::middleware('auth')->prefix('wali-kelas')->name('wali-kelas.')->group(function () {
    Route::get('/izin-keluar', [WaliKelasController::class, 'izinKeluar'])->name('izin-keluar.index');
    Route::patch('/izin-keluar/{id}/verifikasi', [WaliKelasController::class, 'verifikasiIzinKeluar'])->name('izin-keluar.verifikasi');
    Route::get('/izin-pulang', [WaliKelasController::class, 'izinPulang'])->name('izin-pulang.index');
    Route::patch('/izin-pulang/{id}/verifikasi', [WaliKelasController::class, 'verifikasiIzinPulang'])->name('izin-pulang.verifikasi');
});

// SPMB - CALON SISWA
Route::prefix('admin')->group(function () {
    Route::get('/spmb/calon-siswa', [SpmbController::class, 'index'])->name('admin.spmb.index');
    Route::get('/spmb/calon-siswa/create', [SpmbController::class, 'create'])->name('admin.spmb.create');
    Route::post('/spmb/calon-siswa', [SpmbController::class, 'store'])->name('admin.spmb.store');
    Route::get('/spmb/calon-siswa/{id}', [SpmbController::class, 'show'])->name('admin.spmb.show');
    Route::get('/spmb/calon-siswa/{id}/edit', [SpmbController::class, 'edit'])->name('admin.spmb.edit');
    Route::put('/spmb/calon-siswa/{id}', [SpmbController::class, 'update'])->name('admin.spmb.update');
    Route::delete('/spmb/calon-siswa/{id}', [SpmbController::class, 'destroy'])->name('admin.spmb.destroy');
    Route::put('/spmb/calon-siswa/{id}/dokumen/{dokumenId}/verifikasi', [SpmbController::class, 'verifikasiDokumen'])->name('admin.spmb.dokumen.verifikasi');
    Route::put('/spmb/calon-siswa/{id}/verifikasi-daftar-ulang', [SpmbController::class, 'verifikasiDaftarUlang'])->name('admin.spmb.daftar-ulang.verifikasi');
});

//guru
Route::middleware('auth')->group(function () {

    Route::get(
        '/guru/penilaian',
        [PenilaianController::class, 'index']
    )->name('guru.penilaian.index');

    Route::get(
        '/guru/penilaian/{jadwal}/input',
        [PenilaianController::class, 'create']
    )->name('guru.penilaian.create');

    Route::post(
        '/guru/penilaian/{jadwal}',
        [PenilaianController::class, 'store']
    )->name('guru.penilaian.store');

    Route::get(
        '/guru/penilaian/{jadwalId}/detail_penilaian',
        [PenilaianController::class, 'detail']
    )->name('guru.penilaian.detail');

    Route::get(
        '/guru/penilaian/{jadwal}/siswa/{siswa}/edit',
        [PenilaianController::class, 'editSiswa']
    )->name('guru.penilaian.editSiswa');

    Route::put(
        '/guru/penilaian/{jadwal}/siswa/{siswa}/update',
        [PenilaianController::class, 'updateSiswa']
    )->name('guru.penilaian.updateSiswa');
});

Route::prefix('admin')->name('admin.')->group(function () {

    // PENILAIAN MATA PELAJARAN

    Route::get('/penilaian/mapel', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'index'
    ])->name('penilaian.mapel.index');

    Route::get('/penilaian/mapel/kelas/{kelasId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'kelas'
    ])->name('penilaian.mapel.kelas');

    Route::get('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'mapel'
    ])->name('penilaian.mapel.mapel');

    Route::get('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/create', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'create'
    ])->name('penilaian.mapel.create');

    Route::post('/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'store'
    ])->name('penilaian.mapel.store');

    Route::get('/penilaian/mapel/{id}/edit', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'edit'
    ])->name('penilaian.mapel.edit');

    Route::put('/penilaian/mapel/{id}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'update'
    ])->name('penilaian.mapel.update');

    Route::delete('/penilaian/mapel/{id}', [
        \App\Http\Controllers\Admin\PenilaianMapelController::class,
        'destroy'
    ])->name('penilaian.mapel.destroy');

    /*
    |--------------------------------------------------------------------------
    | PENILAIAN PJBL
    |--------------------------------------------------------------------------
    */
    // Halaman pilih kelas
    Route::get(
        '/penilaian/pjbl',
        [
            PenilaianPjblController::class,
            'index'
        ]
    )->name('penilaian.pjbl.index');


    // Halaman PJBL berdasarkan kelas
    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}',
        [
            PenilaianPjblController::class,
            'kelas'
        ]
    )->name('penilaian.pjbl.kelas');


    // Halaman tabel penilaian
    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}',
        [
            PenilaianPjblController::class,
            'penilaian'
        ]
    )->name('penilaian.pjbl.penilaian');


    // Tambah
    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/create',
        [
            PenilaianPjblController::class,
            'create'
        ]
    )->name('penilaian.pjbl.create');


    // Simpan
    Route::post(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}',
        [
            PenilaianPjblController::class,
            'store'
        ]
    )->name('penilaian.pjbl.store');


    // Edit
    Route::get(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}/edit',
        [
            PenilaianPjblController::class,
            'edit'
        ]
    )->name('penilaian.pjbl.edit');


    // Update
    Route::put(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}',
        [
            PenilaianPjblController::class,
            'update'
        ]
    )->name('penilaian.pjbl.update');


    // Hapus
    Route::delete(
        '/penilaian/pjbl/kelas/{kelasId}/pjbl/{pjblId}/{id}',
        [
            PenilaianPjblController::class,
            'destroy'
        ]
    )->name('penilaian.pjbl.destroy');

    /*
    |--------------------------------------------------------------------------
    | ABSENSI
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/absensi',
        [AbsensiController::class, 'index']
    )->name('absensi.index');

    Route::get(
        '/absensi/{id}',
        [AbsensiController::class, 'show']
    )->name('absensi.show');


    /*
    |--------------------------------------------------------------------------
    | SAKIT
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/sakit',
        [SakitController::class, 'index']
    )->name('sakit.index');

    Route::get(
        '/sakit/{id}',
        [SakitController::class, 'show']
    )->name('sakit.show');


    /*
    |--------------------------------------------------------------------------
    | IZIN KELUAR
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/izin-keluar',
        [IzinKeluarController::class, 'index']
    )->name('izin-keluar.index');

    Route::get(
        '/izin-keluar/{id}',
        [IzinKeluarController::class, 'show']
    )->name('izin-keluar.show');


    /*
    |--------------------------------------------------------------------------
    | IZIN PULANG
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/izin-pulang',
        [IzinPulangController::class, 'index']
    )->name('izin-pulang.index');

    Route::get(
        '/izin-pulang/{id}',
        [IzinPulangController::class, 'show']
    )->name('izin-pulang.show');


    /*
    |--------------------------------------------------------------------------
    | DISPEN
    |--------------------------------------------------------------------------
    */

    Route::get(
        '/dispen',
        [DispenController::class, 'index']
    )->name('dispen.index');

    Route::get(
        '/dispen/{id}',
        [DispenController::class, 'show']
    )->name('dispen.show');
});

Route::get(
    '/penilaian/mapel',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'index']
)->name('penilaian.mapel.index');


/*
|--------------------------------------------------------------------------
| PILIH MAPEL BERDASARKAN KELAS
|--------------------------------------------------------------------------
*/

Route::get(
    '/penilaian/mapel/kelas/{kelasId}',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'kelas']
)->name('penilaian.mapel.kelas');


/*
|--------------------------------------------------------------------------
| DATA PENILAIAN BERDASARKAN KELAS + MAPEL
|--------------------------------------------------------------------------
*/

Route::get(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'mapel']
)->name('penilaian.mapel.mapel');


/*
|--------------------------------------------------------------------------
| TAMBAH PENILAIAN
|--------------------------------------------------------------------------
*/

Route::get(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/create',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'create']
)->name('penilaian.mapel.create');


Route::post(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'store']
)->name('penilaian.mapel.store');


/*
|--------------------------------------------------------------------------
| EDIT
|--------------------------------------------------------------------------
*/

Route::get(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}/edit',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'edit']
)->name('penilaian.mapel.edit');


Route::put(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'update']
)->name('penilaian.mapel.update');


/*
|--------------------------------------------------------------------------
| DELETE
|--------------------------------------------------------------------------
*/

Route::delete(
    '/penilaian/mapel/kelas/{kelasId}/mapel/{mapelId}/{id}',
    [\App\Http\Controllers\Admin\PenilaianMapelController::class, 'destroy']
)->name('penilaian.mapel.destroy');

Route::get('/penilaian/pjbl', [PenilaianPjblController::class, 'index'])
    ->name('penilaian.pjbl.index');

Route::get('/penilaian/pjbl/create', [PenilaianPjblController::class, 'create'])
    ->name('penilaian.pjbl.create');

Route::post('/penilaian/pjbl', [PenilaianPjblController::class, 'store'])
    ->name('penilaian.pjbl.store');

Route::get('/penilaian/pjbl/{id}/edit', [PenilaianPjblController::class, 'edit'])
    ->name('penilaian.pjbl.edit');

Route::put('/penilaian/pjbl/{id}', [PenilaianPjblController::class, 'update'])
    ->name('penilaian.pjbl.update');

Route::delete('/penilaian/pjbl/{id}', [PenilaianPjblController::class, 'destroy'])
    ->name('penilaian.pjbl.destroy');

Route::get('/guru/jadwal', [JadwalController::class, 'index'])
    ->middleware('auth')
    ->name('guru.jadwal.index');

Route::middleware(['auth'])->group(function () {

    Route::get(
        '/guru/penilaian-pjbl',
        [GuruPenilaianPjblController::class, 'index']
    )->name('guru.penilaian-pjbl.index');

    Route::get(
        '/guru/penilaian-pjbl/{pjbl}/nilai',
        [GuruPenilaianPjblController::class, 'nilai']
    )->name('guru.penilaian-pjbl.nilai');

    Route::post(
        '/guru/penilaian-pjbl/{pjbl}/nilai',
        [GuruPenilaianPjblController::class, 'simpan']
    )->name('guru.penilaian-pjbl.simpan');

    // ABSENSI GURU
    Route::get(
        '/guru/absen',
        [SesiAbsensiController::class, 'index']
    )->name('absensi.index');

    Route::get(
        '/guru/absen/{jadwal}',
        [SesiAbsensiController::class, 'show']
    )->name('absensi.show');

    Route::post(
        '/guru/absen/{jadwal}/buka',
        [SesiAbsensiController::class, 'buka']
    )->name('absensi.buka');
});




// Siswa
Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/jadwal', [SiswaJadwalPelajaranController::class, 'index'])
        ->name('siswa.jadwal.index');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/siswa/absensi', [SiswaAbsensiController::class, 'index'])
        ->name('siswa.absensi.index');
    Route::post('/siswa/absensi', [SiswaAbsensiController::class, 'store'])
        ->name('siswa.absensi.submit');
});

Route::middleware(['auth'])->prefix('siswa')->name('siswa.')->group(function () {

    // Perizinan sakit
    Route::get('/perizinan/sakit', [PerizinanController::class, 'sakit'])
        ->name('perizinan.sakit');

    Route::get('/perizinan/sakit/create', [PerizinanController::class, 'createSakit'])
        ->name('perizinan.sakit.create');

    Route::post('/perizinan/sakit', [PerizinanController::class, 'storeSakit'])
        ->name('perizinan.sakit.store');

    Route::get('/perizinan/sakit/{id}/edit', [PerizinanController::class, 'editSakit'])
        ->name('perizinan.sakit.edit');

    Route::put('/perizinan/sakit/{id}', [PerizinanController::class, 'updateSakit'])
        ->name('perizinan.sakit.update');

    Route::delete('/perizinan/sakit/{id}', [PerizinanController::class, 'destroySakit'])
        ->name('perizinan.sakit.destroy');
});

Route::middleware(['auth'])
    ->prefix('siswa')
    ->name('siswa.')
    ->group(function () {

        Route::get(
            '/dispen',
            [SiswaDispenController::class, 'index']
        )->name('dispen.index');

        Route::get(
            '/dispen/create',
            [SiswaDispenController::class, 'create']
        )->name('dispen.create');

        Route::post(
            '/dispen',
            [SiswaDispenController::class, 'store']
        )->name('dispen.store');

        Route::get(
            '/dispen/{id}',
            [SiswaDispenController::class, 'show']
        )->name('dispen.show');
    });
