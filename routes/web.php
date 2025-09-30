<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ApplicationSettingController;
use App\Http\Controllers\IoTNodeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicNodeController;
use App\Http\Controllers\RawDataController;
use App\Http\Controllers\ThresholdController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('iot-node', IoTNodeController::class)->except('show')->names([
        'index' => 'iot-node.index',
        'create' => 'iot-node.create',
        'store' => 'iot-node.store',
        'edit' => 'iot-node.edit',
        'update' => 'iot-node.update',
        'destroy' => 'iot-node.destroy',
    ]);

    Route::resource('location', LocationController::class)->except('show')->names([
        'index' => 'location.index',
        'create' => 'location.create',
        'store' => 'location.store',
        'edit' => 'location.edit',
        'update' => 'location.update',
        'destroy' => 'location.destroy',
    ]);

    Route::resource('user', UserController::class)->except('show')->names([
        'index' => 'user.index',
        'create' => 'user.create',
        'store' => 'user.store',
        'edit' => 'user.edit',
        'update' => 'user.update',
        'destroy' => 'user.destroy',
    ]);

    Route::resource('volunteer', VolunteerController::class)->except('show')->names([
        'index' => 'volunteer.index',
        'create' => 'volunteer.create',
        'store' => 'volunteer.store',
        'edit' => 'volunteer.edit',
        'update' => 'volunteer.update',
        'destroy' => 'volunteer.destroy',
    ]);

    Route::get('/application-setting', [ApplicationSettingController::class, 'index'])->name('app-setting.index');
    Route::post('/application-setting', [ApplicationSettingController::class, 'store'])->name('app-setting.store');

    Route::resource('threshold', ThresholdController::class)->except('show')->names([
        'index' => 'threshold.index',
        'create' => 'threshold.create',
        'store' => 'threshold.store',
        'edit' => 'threshold.edit',
        'update' => 'threshold.update',
        'destroy' => 'threshold.destroy',
    ]);

    Route::resource('public-node', PublicNodeController::class)->except('show')->names([
        'index' => 'public-node.index',
        'create' => 'public-node.create',
        'store' => 'public-node.store',
        'edit' => 'public-node.edit',
        'update' => 'public-node.update',
        'destroy' => 'public-node.destroy',
    ]);

    Route::get('/raw-data', [RawDataController::class, 'index'])->name('raw-data.index');
    Route::get('/activity-log', [ActivityLogController::class, 'index'])->name('activity-log.index');
    Route::get('/weather', [WeatherController::class, 'index'])->name('weather.index');
    Route::post('/weather', [WeatherController::class, 'store'])->name('weather.store');
    Route::post('/weather/cities', [WeatherController::class, 'getCities']);
    Route::post('/weather/districts', [WeatherController::class, 'getDistricts']);
    Route::post('/weather/villages', [WeatherController::class, 'getVillages']);
});

require __DIR__ . '/auth.php';
