<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;
<<<<<<< Updated upstream
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\TahunAjaranController;
use App\Http\Controllers\PembagianKelasController;
=======
use App\Http\Controllers\Admin\SpmbController;
>>>>>>> Stashed changes

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ===============================
// DASHBOARD
// ===============================

Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::get('/', function () {
    return view('welcome');
});
Route::view('/admin/master-data', 'admin.master-data.index')
    ->name('master-data.index');

Route::get('/admin/ruangan', function () {
    return view('admin.ruangan.index');
});
Route::get('/admin/mata_pelajaran', function () {
    return view('admin.mata_pelajaran.index');
});

// Admin Routes
Route::get('/admin/ruangan', [RuanganController::class, 'index'])
    ->name('ruangan.index');

Route::get('/admin/ruangan/create', [RuanganController::class, 'create'])
    ->name('ruangan.create');

Route::post('/admin/ruangan', [RuanganController::class, 'store'])
    ->name('ruangan.store');

Route::get('/admin/ruangan/{id}/edit', [RuanganController::class, 'edit'])
    ->name('ruangan.edit');

Route::put('/admin/ruangan/{id}', [RuanganController::class, 'update'])
    ->name('ruangan.update');

Route::delete('/admin/ruangan/{id}', [RuanganController::class, 'destroy'])
    ->name('ruangan.destroy');

<<<<<<< Updated upstream
// Mata Pelajaran Routes
Route::get('/admin/mata_pelajaran', [MataPelajaranController::class, 'index'])
    ->name('mata_pelajaran.index');

Route::get('/admin/mata_pelajaran/create', [MataPelajaranController::class, 'create'])
    ->name('mata_pelajaran.create');

Route::post('/admin/mata_pelajaran', [MataPelajaranController::class, 'store'])
    ->name('mata_pelajaran.store');

Route::get('/admin/mata_pelajaran/{id}/edit', [MataPelajaranController::class, 'edit'])
    ->name('mata_pelajaran.edit');

Route::put('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'update'])
    ->name('mata_pelajaran.update');

Route::delete('/admin/mata_pelajaran/{id}', [MataPelajaranController::class, 'destroy'])
    ->name('mata_pelajaran.destroy');

// Tahun Ajaran Routes
Route::resource('tahun-ajaran', TahunAjaranController::class);

// Pembagian Kelas Routes
Route::get('/admin/pembagian_kelas', [PembagianKelasController::class, 'index'])
    ->name('pembagian-kelas.index');

Route::get('/admin/pembagian_kelas/{id}/edit',[PembagianKelasController::class, 'edit'])
    ->name('pembagian-kelas.edit');

Route::put('/admin/pembagian_kelas/{id}',[PembagianKelasController::class, 'update'])
    ->name('pembagian-kelas.update');

Route::delete('/admin/pembagian_kelas/{id}',[PembagianKelasController::class, 'destroy'])
    ->name('pembagian-kelas.destroy');
=======
// ===============================
// SPMB - CALON SISWA
// ===============================

Route::prefix('admin')->group(function () {

    // Daftar calon siswa
    Route::get(
        '/spmb/calon-siswa',
        [SpmbController::class, 'index']
    )->name('admin.spmb.index');

    // Form tambah calon siswa
    Route::get(
        '/spmb/calon-siswa/create',
        [SpmbController::class, 'create']
    )->name('admin.spmb.create');

    // Simpan calon siswa
    Route::post(
        '/spmb/calon-siswa',
        [SpmbController::class, 'store']
    )->name('admin.spmb.store');

    // Detail calon siswa
    Route::get(
        '/spmb/calon-siswa/{id}',
        [SpmbController::class, 'show']
    )->name('admin.spmb.show');

    // Form edit calon siswa
    Route::get(
        '/spmb/calon-siswa/{id}/edit',
        [SpmbController::class, 'edit']
    )->name('admin.spmb.edit');

    // Update calon siswa
    Route::put(
        '/spmb/calon-siswa/{id}',
        [SpmbController::class, 'update']
    )->name('admin.spmb.update');

    // Hapus calon siswa
    Route::delete(
        '/spmb/calon-siswa/{id}',
        [SpmbController::class, 'destroy']
    )->name('admin.spmb.destroy');

    // Verifikasi dokumen
    Route::put(
        '/spmb/calon-siswa/{id}/dokumen/{dokumenId}/verifikasi',
        [SpmbController::class, 'verifikasiDokumen']
    )->name('admin.spmb.dokumen.verifikasi');

    // Verifikasi daftar ulang
    Route::put(
        '/spmb/calon-siswa/{id}/verifikasi-daftar-ulang',
        [SpmbController::class, 'verifikasiDaftarUlang']
    )->name('admin.spmb.daftar-ulang.verifikasi');

});
>>>>>>> Stashed changes
