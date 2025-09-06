<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Master\RoleController;
use App\Http\Controllers\Master\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


// Dashboard
Route::name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::name('master.')->prefix('master')->middleware('auth')->group(function () {
    // user
    Route::name('user.')->controller(UserController::class)->prefix('user')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/show/{user:id}', 'show')->name('show');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{user:id}', 'update')->name('update');
        Route::post('/delete/{user:id}', 'delete')->name('delete');
    });

    // role
    Route::name('role.')->controller(RoleController::class)->prefix('role')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/data', 'data')->name('data');
        Route::get('/detail/{role:id}', 'detail')->name('detail');
        Route::post('/store', 'store')->name('store');
        Route::post('/update/{role:id}', 'update')->name('update');
    });
});

require __DIR__.'/auth.php';
