<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\AuthController;

// 🔹 Rute default -> hanya untuk user yang sudah login
Route::get('/', function () {
    return view('welcome');
})->middleware('auth');

// 🔹 Auth routes
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// 🔹 Semua user yang login bisa melihat daftar buku
Route::middleware(['auth'])->group(function () {
    Route::get('/books', [BookController::class, 'index'])->name('books.index');
});

// 🔹 Member-only
Route::middleware(['auth', 'role:member'])->group(function () {
    Route::get('/peminjamans/mine', [PeminjamanController::class, 'myLoans'])->name('peminjamans.mine');
});

// 🔹 Admin & Librarian
Route::middleware(['auth', 'role:admin,librarian'])->group(function () {
    // Books (CRUD, kecuali index karena sudah umum)
    Route::resource('books', BookController::class)->except(['index']);

    // Members (CRUD)
    Route::resource('members', MemberController::class);

    // Peminjamans (CRUD + approve/reject/return)
    Route::resource('peminjamans', PeminjamanController::class);
    Route::post('/peminjamans/{peminjaman}/approve', [PeminjamanController::class, 'approve'])->name('peminjamans.approve');
    Route::post('/peminjamans/{peminjaman}/reject', [PeminjamanController::class, 'reject'])->name('peminjamans.reject');
    Route::post('/peminjamans/{peminjaman}/return', [PeminjamanController::class, 'returnBook'])->name('peminjamans.return');
});
