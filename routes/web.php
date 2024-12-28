<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\BookController;

Route::apiResource('books', BookController::class);

use App\Http\Controllers\PeminjamanController;

Route::apiResource('peminjamans', PeminjamanController::class);
Route::get('/token', function () {
    return csrf_token(); 
});