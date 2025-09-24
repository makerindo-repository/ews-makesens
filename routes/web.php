<?php

use App\Http\Controllers\IoTNodeController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\ProfileController;
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
});

require __DIR__ . '/auth.php';
