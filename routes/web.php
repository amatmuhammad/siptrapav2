<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;

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
    return redirect()->route('Beranda');
});

Route::get('/Login', [AdminController::class, 'ViewLogin'])->name('ViewLogin');
Route::get('/Register', [AdminController::class, 'ViewRegister'])->name('ViewRegister');
// admin
Route::get('/Dashboard', [AdminController::class, 'dashboard'])->name('Dashboard');
Route::get('/Peta-Persebaran', [AdminController::class, 'persebaran'])->name('persebaran');
Route::get('/Node', [AdminController::class, 'Node'])->name('Node');
Route::get('/Edge', [AdminController::class, 'Edge'])->name('Edge');
Route::get('/Data-Produsen', [AdminController::class, 'produsen'])->name('produsen');
Route::get('/Data-Pangan-Admin', [AdminController::class, 'panganadmin'])->name('panganadmin');
Route::get('/Data-Kabupaten', [AdminController::class, 'kabupaten'])->name('kabupaten');
Route::post('/Create-Kabupaten', [AdminController::class, 'createKabupaten'])->name('createKabupaten');
Route::post('/Update-Kabupaten/{id}', [AdminController::class, 'updateKabupaten'])->name('updateKabupaten');
Route::delete('/Delete-Kabupaten/{id}', [AdminController::class, 'destroyKabupaten'])->name('destroyKabupaten');
Route::get('/Data-Nama-Pangan', [AdminController::class, 'namaPangan'])->name('namaPangan');
Route::post('/Create-NamaPangan', [AdminController::class, 'createNamaPangan'])->name('createNamaPangan');
Route::post('/Update-NamaPangan/{id}', [AdminController::class, 'updateNamaPangan'])->name('updateNamaPangan');

// user
Route::get('/Beranda', [UserController::class, 'Beranda'])->name('Beranda');
Route::get('/Model-Transportasi', [UserController::class, 'Model'])->name('Model');
Route::get('/Data-Pangan', [UserController::class, 'pangan'])->name('pangan');
Route::get('/Distribusi', [UserController::class, 'Distribusi'])->name('Distribusi');
Route::get('/Prakiraan-Cuaca', [UserController::class, 'Cuaca'])->name('Cuaca');
Route::get('/Prakiraan-Cuaca', [UserController::class, 'Cuaca'])->name('Cuaca');
Route::post('/Model-Transportasi/Cari-rute', [UserController::class, 'cariRute'])->name('cariRute');