<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

// Redirect root URL ke halaman login
Route::get('/', function () {
    return redirect('/login');
});

// Rute yang bisa diakses tanpa login (Guest)
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

// Rute yang WAJIB login (Protected Routes)
Route::middleware('auth')->group(function () {

    // Rute Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard'); // Kita akan buat view ini nanti
    })->name('dashboard');

    // Rute CRUD Leads
    Route::resource('leads', App\Http\Controllers\LeadController::class);

    // Khusus Admin Saja
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function () {
            return 'Halaman Manajemen User';
        })->name('users.index');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
