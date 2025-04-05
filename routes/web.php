<?php

use App\Http\Controllers\QuanLyPhimController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/admin/phim', [QuanLyPhimController::class, 'index']);
