<?php

use App\Http\Controllers\QuanLyPhimController;
use App\Http\Controllers\SuKienController;
use App\Http\Controllers\LoginGoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin/phim', [QuanLyPhimController::class, 'index']);

Route::get('/auth/google', [LoginGoogleController::class, 'redirectToGoogle']);
Route::get('/auth/google/callback', [LoginGoogleController::class, 'handleGoogleCallback']);