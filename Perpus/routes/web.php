<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');

// User Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'dashboard'])->name('dashboard');

    Route::get('/books/{book}/read', [BookController::class, 'read'])->name('books.read');
    
    // Borrowing Routes
    Route::post('/books/{book}/borrow', [BorrowingController::class, 'store'])->name('borrowings.store');
    Route::post('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnBook'])->name('borrowings.return');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin Auth Routes
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
});

// Admin Authenticated Routes
Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::resource('books', BookController::class);
    Route::resource('users', UserController::class)->except(['show', 'create', 'store', 'edit', 'update']);
    
    Route::get('/borrowings', [\App\Http\Controllers\Admin\BorrowingController::class, 'index'])->name('borrowings.index');
    Route::post('/borrowings/{borrowing}/return', [\App\Http\Controllers\Admin\BorrowingController::class, 'returnBook'])->name('borrowings.return');
});

require __DIR__.'/auth.php';
