<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeviceStatusController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\RfidRegistrationController;
use App\Http\Controllers\ScanHistoryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // If logged in, go to dashboard. If not, go to login.
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // RFID Registration – full CRUD
    Route::resource('rfid', RfidRegistrationController::class)
        ->except(['show'])
        ->parameters(['rfid' => 'rfidCard']);

    // Scan History
    Route::get('/scans', [ScanHistoryController::class, 'index'])->name('scans.index');
    Route::get('/scans/{scan}', [ScanHistoryController::class, 'show'])->name('scans.show');

    // Device Status
    Route::get('/devices', [DeviceStatusController::class, 'index'])->name('devices.index');
    Route::get('/devices/{device}/ping', [DeviceStatusController::class, 'ping'])->name('devices.ping');

    // Reports
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
