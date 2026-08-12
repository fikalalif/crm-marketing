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

    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Rute Khusus Export PDF (Harus di atas resource)
    Route::get('/leads/export/pdf', [App\Http\Controllers\LeadController::class, 'exportPdf'])->name('leads.export.pdf');

    // Rute CRUD Leads
    Route::resource('leads', App\Http\Controllers\LeadController::class);

    // Rute CRUD Leads
    Route::resource('leads', App\Http\Controllers\LeadController::class);

    // Rute Laporan (Reports)
    Route::get('/reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports.index');

    // Rute Khusus Admin untuk Kelola User Marketing
    Route::middleware([\App\Http\Middleware\IsAdmin::class])->group(function () {
        Route::resource('users', App\Http\Controllers\UserController::class);
    });

    Route::post('/logout', [App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
});
