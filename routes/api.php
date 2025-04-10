<?php

use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\DanhGiaController;
use App\Http\Controllers\QuanLyPhimController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/chuc-vu/data', [ChucVuController::class, 'getData']);
Route::get('/chuc-vu/data/open', [ChucVuController::class, 'getDataOP']);
Route::post('/chuc-vu/create', [ChucVuController::class, 'createData']);
Route::put('/chuc-vu/update', [ChucVuController::class, 'updateData']);
Route::delete('/chuc-vu/delete/{id}', [ChucVuController::class, 'deleteData']);
Route::put('/chuc-vu/doi-trang-thai', [ChucVuController::class, 'doiTrangThai']);

Route::group(['prefix' => '/admin'], function () {
    Route::group(['prefix' => '/quan-ly-phim'], function () {
        Route::get('/lay-du-lieu', [QuanLyPhimController::class, 'getData']);
        Route::post('/tim-quan-ly-phim', [QuanLyPhimController::class, 'searchQuanLyPhim']);
        Route::post('/them-moi-quan-ly-phim', [QuanLyPhimController::class, 'themMoiQuanLyPhim']);
        Route::delete('/xoa-quan-ly-phim/{id}', [QuanLyPhimController::class, 'xoaQuanLyPhim']);
        Route::put('/doi-trang-thai', [QuanLyPhimController::class, 'doiTrangThaiQuanLyPhim']);
        Route::put('/update', [QuanLyPhimController::class, 'createQuanLyPhim']);
    });
});

Route::get('/danh-gia/data', [DanhGiaController::class, 'getData']);
Route::post('/danh-gia/create', [DanhGiaController::class, 'createData']);
Route::put('/danh-gia/update', [DanhGiaController::class, 'updateData']);
Route::delete('/danh-gia/delete/{id}', [DanhGiaController::class, 'deleteData']);
Route::put('/danh-gia/doi-trang-thai', [DanhGiaController::class, 'doiTrangThai']);
