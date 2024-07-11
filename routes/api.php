<?php

use App\Http\Controllers\Aduan\AduanController;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Aspirasi\AspirasiController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\Feed\FeedController;
use App\Http\Controllers\Komentar\KomentarController as KomentarController;
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
Route::post('/forgot-password', [AuthController::class, 'forgotPass']);



Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']); // Rute untuk proses logout user mobile

    // pengaduan
    Route::post('/pengaduan', [AduanController::class, 'createPengaduan'])->name('createPengaduan');
    Route::get('/listaduan', [AduanController::class, 'riwayatPengaduan']);
    Route::get('/pengaduan/{id}/forward', [AduanController::class, 'getHistoryForward'])->name('pengaduan.forward');

    //comment
    // Route::get('/komentar', [KomentarController::class, 'index']);
    Route::post('/komentar/{aduan_id}/kirim', [KomentarController::class, 'kirimKomentar'])->name('komentar.kirim');
    // Route::put('/komentar/{id}/update', [KomentarController::class, 'updateKomentar'])->name('komentar.update');
    Route::post('/komentar/{id}/update', [KomentarController::class, 'updateKomentar'])->name('komentar.update');
    Route::delete('/komentar/{id}/delete', [KomentarController::class, 'destroy'])->name('komentar.destroy');
    Route::get('/komentar/{id}', [KomentarController::class, 'getKomentar'])->name('getKomentar');
    //aspirasi
    Route::post('/aspirasi', [AspirasiController::class, 'createAspirasi'])->name('createAspirasi');
    Route::get('/listaspirasi', [AspirasiController::class, 'riwayatAspirasi']);

    // Feed
    Route::get('/feeds', [FeedController::class, 'getAllFeeds']);
    Route::get('/feed/view/{id}', [FeedController::class, 'getFeedById']);


    // Users
    Route::get('/user/profile', [UserController::class, 'getUserProfile'])->name('user.profile.get');
    Route::post('/user/profile/update', [AuthController::class, 'updateProfile'])->name('user.profile.update');
    Route::post('/user/password/update', [AuthController::class, 'updatePassword'])->name('user.update.password');
});
