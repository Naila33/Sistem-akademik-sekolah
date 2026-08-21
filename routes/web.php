<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;
use App\Http\Controllers\MataPelajaranController;
use App\Http\Controllers\TahunAjaranController;

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

Route::resource('tahun-ajaran', TahunAjaranController::class);
