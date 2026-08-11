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

    // Bisa diakses oleh Admin DAN Marketing
    Route::get('/dashboard', function () {
        return 'Selamat datang, ' . auth()->user()->name . '! (Role: ' . auth()->user()->role . ') <br><br> <form action="/logout" method="POST">'.csrf_field().'<button type="submit">Logout</button></form>';
    })->name('dashboard');

    // Khusus Admin Saja
    Route::middleware('role:admin')->group(function () {
        Route::get('/users', function () {
            return '<h1>Halaman Manajemen User</h1><p>Hanya Admin yang bisa melihat halaman ini.</p> <br><a href="/dashboard">Kembali ke Dashboard</a>';
        })->name('users.index');
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
