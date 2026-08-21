<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RuanganController;

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

Route::get('/admin/ruangan', function () {
    return view('admin.ruangan.index');
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