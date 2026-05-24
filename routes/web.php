<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\AdminController;

// Auth
Route::get('/', fn() => redirect('/login'));
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Mahasiswa
Route::middleware('role:Mahasiswa,Organisasi')->prefix('mahasiswa')->group(function () {
    Route::get('/dashboard', [BookingController::class, 'dashboard']);

    // Lapangan (Dipindahkan ke middleware Organisasi)

    // Barang
    Route::get('/barang', [BookingController::class, 'indexBarang']);
    Route::get('/barang/create', [BookingController::class, 'createBarang']);
    Route::post('/barang', [BookingController::class, 'storeBarang']);
    Route::delete('/barang/{id}/cancel', [BookingController::class, 'cancelBarang']);

});

// Organisasi (Khusus Lapangan)
Route::middleware('role:Organisasi')->prefix('mahasiswa')->group(function () {
    Route::get('/lapangan', [BookingController::class, 'indexLapangan']);
    Route::get('/lapangan/create', [BookingController::class, 'createLapangan']);
    Route::post('/lapangan', [BookingController::class, 'storeLapangan']);
    Route::delete('/lapangan/{id}/cancel', [BookingController::class, 'cancelLapangan']);
    // Kelola Barang Saya
    Route::get('/barang-saya', [BookingController::class, 'barangSayaIndex']);
    Route::get('/barang-saya/create', [BookingController::class, 'barangSayaCreate']);
    Route::post('/barang-saya', [BookingController::class, 'barangSayaStore']);
    Route::get('/barang-saya/{id}/edit', [BookingController::class, 'barangSayaEdit']);
    Route::put('/barang-saya/{id}', [BookingController::class, 'barangSayaUpdate']);
    Route::delete('/barang-saya/{id}', [BookingController::class, 'barangSayaDelete']);

    // Permintaan Masuk
    Route::get('/permintaan-masuk', [BookingController::class, 'permintaanMasukIndex']);
    Route::patch('/permintaan-masuk/{id}/approve', [BookingController::class, 'permintaanMasukApprove']);
    Route::patch('/permintaan-masuk/{id}/reject', [BookingController::class, 'permintaanMasukReject']);
    Route::patch('/permintaan-masuk/{id}/return', [BookingController::class, 'permintaanMasukReturn']);
});

// Admin
Route::middleware('role:Admin')->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard']);

    // Peminjaman management
    Route::get('/peminjaman', [AdminController::class, 'peminjamanIndex']);
    Route::patch('/peminjaman/{id}/approve', [AdminController::class, 'approve']);
    Route::patch('/peminjaman/{id}/reject', [AdminController::class, 'reject']);
    Route::patch('/peminjaman/{id}/return', [AdminController::class, 'returnPeminjaman']);

    // Objek CRUD
    Route::get('/objek', [AdminController::class, 'objekIndex']);
    Route::get('/objek/{id}/edit', [AdminController::class, 'objekEdit']);
    Route::put('/objek/{id}', [AdminController::class, 'objekUpdate']);
});
