<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BookController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\PeminjamanController;

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Books (CRUD)
Route::resource('books', BookController::class);

// Members (CRUD)
Route::resource('members', MemberController::class);

// Peminjamans (CRUD + tambahan approve/return)
Route::resource('peminjamans', PeminjamanController::class);

// Custom route untuk Approve & Return
Route::post('/peminjamans/{id}/approve', [PeminjamanController::class, 'approve'])->name('peminjamans.approve');
Route::post('/peminjamans/{id}/return', [PeminjamanController::class, 'returnBook'])->name('peminjamans.return');