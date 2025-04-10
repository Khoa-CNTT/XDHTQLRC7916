<?php

use App\Http\Controllers\GheController;
use App\Http\Controllers\KhachHangController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\PhongController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::get('/khach-hang/data', [KhachHangController::class, 'getData']);
    Route::post('/khach-hang/create', [KhachHangController::class, 'createData']);
    Route::put('/khach-hang/update', [KhachHangController::class, 'updateData']);
    Route::delete('/khach-hang/delete/{id}', [KhachHangController::class, 'deleteData']);
    Route::put('/khach-hang/doi-trang-thai', [KhachHangController::class, 'doiTrangThai']);


    Route::get('/nhan-vien/data', [NhanVienController::class, 'getData']);
    Route::post('/nhan-vien/create', [NhanVienController::class, 'createData']);
    Route::put('/nhan-vien/update', [NhanVienController::class, 'updateData']);
    Route::delete('/nhan-vien/delete/{id}', [NhanVienController::class, 'deleteData']);
    Route::put('/nhan-vien/doi-trang-thai', [NhanVienController::class, 'doiTrangThai']);    


    Route::get('/phong/data', [PhongController::class, 'getData']);
    Route::post('/phong/create', [PhongController::class, 'store']);
    Route::delete('/phong/delete/{id}', [PhongController::class, 'destroy']);
    Route::put('/phong/update', [PhongController::class, 'update']);
    Route::put('/phong/doi-trang-thai', [PhongController::class, 'doiTrangThai']);    


    Route::get('/ghe/data', [GheController::class, 'getData']);
    Route::post('/ghe/create', [GheController::class, 'createData']);
    Route::put('/ghe/update', [GheController::class, 'updateData']);
    Route::delete('/ghe/delete/{id}', [GheController::class, 'deleteData']);
    Route::post('/ghe/create-multiple', [GheController::class, 'createMultipleGhe']);    