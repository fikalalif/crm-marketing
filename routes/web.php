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
    // Rute sementara untuk testing Dashboard
    Route::get('/dashboard', function () {
        return 'Selamat datang, ' . auth()->user()->name . '! <br><br> <form action="/logout" method="POST">'.csrf_field().'<button type="submit">Logout</button></form>';
    })->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
