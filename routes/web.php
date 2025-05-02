<?php

use App\Http\Controllers\QuanLyPhimController;
use App\Http\Controllers\SuKienController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/phim', [QuanLyPhimController::class, 'index']);

// Sự kiện routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('sukien', SuKienController::class);
});
