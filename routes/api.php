<?php

use App\Http\Controllers\TheLoaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::group(['prefix' => '/admin'], function () {

    Route::group(['prefix' => '/the-loai-phim'], function () {
        Route::get('/lay-du-lieu', [TheLoaiController::class, 'getData']);
        Route::post('/search', [TheLoaiController::class, 'searchTheLoai']);
        Route::post('/create', [TheLoaiController::class, 'createTheLoai']);
        Route::delete('/delete/{id}', [TheLoaiController::class, 'deleteTheLoai']);
        Route::put('/update', [TheLoaiController::class, 'updateTheLoai']);
    });
});

