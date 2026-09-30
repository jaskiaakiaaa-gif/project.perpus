<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\SessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::resource('kategori', KategoriController::class);
Route::resource('buku', BukuController::class);
Route::resource('member', MemberController::class);
Route::put('/member/{id}/kembalikan', [MemberController::class, 'kembalikan'])->name('member.kembalikan');
Route::get('/login',[SessionController::class,'index']);
Route::get('/sesi',[SessionController::class,'index']);
Route::post('/sesi/login',[SessionController::class,'login']);
Route::get('/sesi/login',[SessionController::class,'logout']);
Route::get('/sesi/logout', [SessionController::class, 'logout']);




