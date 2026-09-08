<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\LeadCaptureController;

// Pintu masuk serbaguna untuk semua sumber leads
Route::post('/webhook/leads', [LeadCaptureController::class, 'handleWebhook']);



Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
