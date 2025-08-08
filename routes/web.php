<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
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

Route::get('/Login', [AdminController::class, 'login'])->name('login');
Route::post('/Login-Proses', [AuthController::class, 'loginproses'])->name('loginproses');
Route::post('/Logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/Register', [AdminController::class, 'ViewRegister'])->name('ViewRegister');

Route::middleware('auth')->group(function(){
    Route::middleware('can:admin')->group(function(){
        // admin
        Route::get('/Dashboard', [AdminController::class, 'dashboard'])->name('Dashboard');
        Route::get('/Peta-Persebaran', [AdminController::class, 'persebaran'])->name('persebaran');
        Route::get('/Node', [AdminController::class, 'Node'])->name('Node');
        Route::post('/refresh-cache', [UserController::class, 'RefreshGraph'])->name('RefreshGraph');
        Route::post('/Node-Create', [AdminController::class, 'storeNode'])->name('storeNode');
        Route::put('/Update-Node/{id}', [AdminController::class, 'updateNode'])->name('updateNode');
        Route::get('/Edge', [AdminController::class, 'Edge'])->name('Edge');
        Route::put('/Update-Edge/{id}', [AdminController::class, 'updateEdge'])->name('updateEdge');
        Route::get('/Data-Produsen', [AdminController::class, 'produsen'])->name('produsen');
        Route::get('/Data-Pangan-Admin', [AdminController::class, 'panganadmin'])->name('panganadmin');
        Route::post('/Create-Pangan', [AdminController::class, 'storepangan'])->name('storepangan');
        Route::put('/Update-Pangan/{id}', [AdminController::class, 'updatepangan'])->name('updatepangan');
        Route::delete('/Delete-Pangan/{id}', [AdminController::class, 'destroypangan'])->name('destroypangan');
        Route::get('/Data-Kabupaten', [AdminController::class, 'kabupaten'])->name('kabupaten');
        Route::get('/images/{filename}', function ($filename) {
            $path = base_path('images/' . $filename);
            if (!file_exists($path)) {
                abort(404);
            }
            $mimeType = mime_content_type($path);
            return response()->file($path, ['Content-Type' => $mimeType]);
        })->name('image.kabupaten');//menampilkan gambar kabupaten
        Route::post('/Create-Kabupaten', [AdminController::class, 'createKabupaten'])->name('createKabupaten');
        Route::put('/Update-Kabupaten/{id}', [AdminController::class, 'updateKabupaten'])->name('updateKabupaten');
        Route::delete('/Delete-Kabupaten/{id}', [AdminController::class, 'destroyKabupaten'])->name('destroyKabupaten');
        Route::get('/Data-Nama-Pangan', [AdminController::class, 'namaPangan'])->name('namaPangan');
        Route::post('/Create-NamaPangan', [AdminController::class, 'createNamaPangan'])->name('createNamaPangan');
        Route::post('/Update-NamaPangan/{id}', [AdminController::class, 'updateNamaPangan'])->name('updateNamaPangan');
        Route::delete('/Delete-Namapangan/{id}', [AdminController::class, 'destroyNamaPangan'])->name('destroyNamaPangan');
        Route::post('/Create-Produsen', [AdminController::class, 'storeprodusen'])->name('storeprodusen');
        Route::put('/Update-Produsen/{id}', [AdminController::class, 'updateprodusen'])->name('updateprodusen');
        Route::delete('/Delete-Prdusen/{id}', [AdminController::class, 'destroyprodusen'])->name('destroyprodusen');

    });
});


// user
Route::get('/Beranda', [UserController::class, 'Beranda'])->name('Beranda');
Route::get('/Data-Pangan', [UserController::class, 'pangan'])->name('pangan');
Route::get('/Distribusi', [UserController::class, 'Distribusi'])->name('Distribusi');
Route::get('/Prakiraan-Cuaca', [UserController::class, 'Cuaca'])->name('Cuaca');
// Route::get('/Prakiraan-Cuaca', [UserController::class, 'Cuaca'])->name('Cuaca');
Route::get('/Model-Transportasi', [UserController::class, 'Model'])->name('Model');
Route::post('/Model-Transportasi/CariRute', [UserController::class, 'cariRute'])->name('cariRute');
Route::post('/Model-Transportasi/Clear', [UserController::class, 'clearRute'])->name('clearRute');

// Route::get('/jalur-alternatif', [UserController::class, 'jalurAlternatif'])->name('jalurAlternatif');