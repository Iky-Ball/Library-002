<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

// Rute default mengarah ke login untuk pengguna yang belum login
Route::get('/', function () {
    return view('welcome');
})->middleware('auth'); // Hanya untuk pengguna yang sudah login

// Rute autentikasi
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute yang dilindungi autentikasi
Route::middleware(['auth'])->group(function () {
    // Books (CRUD)
    Route::resource('books', BookController::class);

    // Members (CRUD)
    Route::resource('members', MemberController::class);

    // Peminjamans (CRUD + tambahan approve/return)
    Route::resource('peminjamans', PeminjamanController::class);

    // Custom route untuk Approve & Return
    Route::post('/peminjamans/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('/peminjamans/{id}/return', [PeminjamanController::class, 'returnBook'])->name('peminjamans.return');
});