<?php

use App\Http\Controllers\Aduan\AduanController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Aspirasi\AspirasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Feed\FeedController;
use Illuminate\Support\Facades\Route;


Route::get('/test', function () {
    return response([
        'message' => 'Api is working'
    ], 200);
});

Route::controller('/', 'TestController');


//api mobile
Route::post('/loginApi', [AuthController::class, 'loginApi'])->name('loginApi');
Route::post('/register', [AuthController::class, 'register']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Rute untuk proses logout user mobile


    // pengaduan
    Route::post('/pengaduan', [AduanController::class, 'createPengaduan'])->name('createPengaduan');
    Route::get('/listaduan', [AduanController::class, 'riwayatPengaduan']);

    //aspirasi
    Route::post('/aspirasi', [AspirasiController::class, 'createAspirasi'])->name('createAspirasi');
    Route::get('/listaspirasi', [AduanController::class, 'riwayatAspirasi']);
});
