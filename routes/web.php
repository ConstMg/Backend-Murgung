<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CloudinaryController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/karyawan', [KaryawanController::class, 'index']);


Route::get('/profile', [ProfileController::class, 'index']);

//buat ambil data dari cloudinary dan menyimpan ke database
// Route::get('/cloudinary-images', [CloudinaryController::class, 'fetchCloudinaryImages']);

Route::post('/presensi', [PresensiController::class, 'index']);
Route::get('/presensi', [PresensiController::class, 'index']);
