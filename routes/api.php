<?php

use App\Http\Controllers\Aduan\AduanController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Aspirasi\AspirasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\User\UserController;
use App\Models\Feed;
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

    // Feed
    Route::post('/feed/create', [FeedController::class, 'create'])->name('createFeed');
    Route::post('/feed', [FeedController::class, 'index']);
    Route::get('/feed/latest', [FeedController::class, 'latest']);



    // Users
    Route::post('/user/profile/update', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/profile', [UserController::class, 'getUserProfile'])->name('user.profile.get');
});
