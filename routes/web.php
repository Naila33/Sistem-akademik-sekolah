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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// DASHBOARD & HOME
Route::get('/', function () {
    return redirect()->route('admin.dashboard');
})->name('home');

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::view('/admin/master-data', 'admin.master-data.index')
    ->name('master-data.index');

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
Route::get('/admin/pembagian_kelas', [PembagianKelasController::class, 'index'])->name('pembagian-kelas.index');
Route::get('/admin/pembagian_kelas/{id}/edit',[PembagianKelasController::class, 'edit'])->name('pembagian-kelas.edit');
Route::put('/admin/pembagian_kelas/{id}',[PembagianKelasController::class, 'update'])->name('pembagian-kelas.update');
Route::delete('/admin/pembagian_kelas/{id}',[PembagianKelasController::class, 'destroy'])->name('pembagian-kelas.destroy');

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

// RESOURCE ROUTES
Route::resource('tahun-ajaran', TahunAjaranController::class)->except(['show']);
Route::resource('jurusan', JurusanController::class)->except(['show']);
Route::resource('siswa', SiswaController::class)->except(['show']);
Route::resource('guru', GuruController::class)->except(['show']);
Route::resource('kelas', KelasController::class)->except(['show']);

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