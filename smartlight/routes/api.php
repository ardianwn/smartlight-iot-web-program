<?php

use App\Http\Controllers\Api\LightStatusController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Light status routes - no auth for ESP32
Route::post('/light/status', [LightStatusController::class, 'update']);
Route::get('/light/status', [LightStatusController::class, 'latest']);
Route::post('/light/toggle', [LightStatusController::class, 'toggle']);
Route::post('/light/mode', [LightStatusController::class, 'setMode']);

// Settings API
Route::get('/settings', function() {
    return response()->json(['data' => \App\Models\Setting::all()]);
});

// Schedules API
Route::get('/schedules', function() {
    return response()->json(['data' => \App\Models\Schedule::where('is_active', true)->get()]);
});
