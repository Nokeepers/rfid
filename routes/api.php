<?php

use App\Http\Controllers\Api\RfidScanController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware('device.token')->group(function () {
    Route::post('/rfid/scan', [RfidScanController::class, 'store']);
    Route::post('/device/heartbeat', [RfidScanController::class, 'heartbeat']);
});
