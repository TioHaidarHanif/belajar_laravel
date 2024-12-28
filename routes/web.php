<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
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
