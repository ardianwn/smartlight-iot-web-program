<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    
    // Settings
    Route::get('/settings', [DashboardController::class, 'settings'])->name('settings');
    Route::post('/settings', [DashboardController::class, 'updateSettings'])->name('settings.update');
    
    // Schedules
    Route::get('/schedules', [DashboardController::class, 'schedules'])->name('schedules');
    Route::post('/schedules', [DashboardController::class, 'storeSchedule'])->name('schedules.store');
    Route::put('/schedules/{schedule}', [DashboardController::class, 'updateSchedule'])->name('schedules.update');
    Route::delete('/schedules/{schedule}', [DashboardController::class, 'deleteSchedule'])->name('schedules.destroy');
    
    // Exports
    Route::get('/export/{period?}', [DashboardController::class, 'exportData'])->name('export');
    Route::get('/reports', [DashboardController::class, 'reports'])->name('reports');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
