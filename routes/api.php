<?php

use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::get('/application-settings', [ApplicationSettingController::class, 'fetchApplicationSettings']);
Route::post('/receive-report', [ReportController::class, 'receiveReport']);
Route::post('/receive-image/{id}', [ReportController::class, 'receiveImage']);