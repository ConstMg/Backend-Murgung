<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\PresensiController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CloudinaryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\EmailController;

// Public routes
Route::post('/login', [AuthenticationController::class, 'login']);
Route::get('/cloudinary/images', [CloudinaryController::class, 'fetchImageFromDb']);
Route::get('/profile', [ProfileController::class, 'show']);
Route::get('/projects', [CloudinaryController::class, 'fetchProjects']);
Route::get('/profile/images', [ProfileController::class, 'getAboutImages']);
Route::post('/send-email-home', [EmailController::class, 'sendMainPage']);

// Routes for authenticated users (karyawan and others)
Route::middleware(['auth:sanctum'])->group(function () {
    Route::post('/logout', [AuthenticationController::class, 'logout']);
// User biasa (karyawan) routes
    Route::get('/me', [KaryawanController::class, 'me']);
    Route::put('/me/update', [KaryawanController::class, 'update']);
     Route::put('/me/password', [KaryawanController::class, 'updatePassword']);
    Route::prefix('karyawan')->group(function () {
        Route::post('/presensi', [PresensiController::class, 'presensi']);
        Route::get('/presensi/riwayat', [PresensiController::class, 'apiList']);
    });

    // Admin routes: harus login + role admin, dengan prefix /admin
    Route::middleware(['check.admin'])->prefix('admin')->group(function () {
        // Karyawan management
        Route::get('/karyawan', [AdminController::class, 'getAllKaryawan']);
        Route::post('/karyawan', [AdminController::class, 'tambahKaryawan']);
        Route::put('/karyawan/{id}', [AdminController::class, 'updateKaryawan']);
        Route::patch('/karyawan/status/{id}', [AdminController::class, 'updateKaryawan']);
        Route::delete('/karyawan/{id}', [AdminController::class, 'hapusKaryawan']);

        // Presensi
        Route::get('/presensi', [AdminController::class, 'listPresensiSemuaKaryawan']);

        // Projects
        Route::post('/addProject', [AdminController::class, 'addProject']);
        Route::get('/projects', [AdminController::class, 'fetchProjects']);
        Route::put('/projects/{id}', [AdminController::class, 'updateProject']);
        Route::delete('/projects/{id}', [AdminController::class, 'deleteProject']);

        // Profile management
        Route::patch('/profile', [ProfileController::class, 'update']);
        Route::post('/profile/images', [ProfileController::class, 'assignAboutImages']);
        Route::delete('/profile/images', [ProfileController::class, 'unassignAboutImage']);


        // Update role by nama (patch)
        Route::patch('/update-role', [AdminController::class, 'updateRoleByNama']);
        // Cloudinary image management (bisa untuk admin)
        Route::post('/cloudinary/images', [CloudinaryController::class, 'addImageToProject']);
        Route::delete('/cloudinary/images', [CloudinaryController::class, 'deleteImage']);
    });
});




