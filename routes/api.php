<?php
use App\Http\Controllers\FileUploadController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

use App\Http\Controllers\BookController;

Route::apiResource('books', BookController::class);

use App\Http\Controllers\PeminjamanController;

Route::get('/peminjamans/returned', [PeminjamanController::class, 'getAllReturned']);
Route::get('/peminjamans/unreturned', [PeminjamanController::class, 'getAllUnreturned']);
Route::apiResource('peminjamans', PeminjamanController::class);
Route::get('/token', function () {
    return csrf_token(); 
});
Route::put('/peminjamans/{id}/return', [PeminjamanController::class, 'returnBook']);
// buat routes untuk melihat semua peminjaman yang sudah dikembalikan
// buat routes untuk melihat semua peminjaman yang belum dikembalikan

Route::post('/upload', [FileUploadController::class, 'upload']);
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');

// API untuk semua user
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/users', [UserController::class, 'index']); // Semua user bisa melihat data

    // API untuk Admin
    Route::middleware('role:admin')->group(function () {
        Route::post('/users', [UserController::class, 'store']);   // Tambah user
        Route::put('/users/{id}', [UserController::class, 'update']); // Ubah user
        Route::delete('/users/{id}', [UserController::class, 'destroy']); // Hapus user
    });
});