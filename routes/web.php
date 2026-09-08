<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\NewsController;
use Illuminate\Support\Facades\Route;

// Route Guest
Route::middleware('api.guest')->group(function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/login', [LoginController::class, 'authenticate'])->name('login.authenticate');
});

// Route Auth
Route::middleware('api.auth')->group(function () {
    // Route Dashboard
    Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

    // Route Logout
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Route Index News
    Route::get('/dashboard/news', [NewsController::class, 'index'])->name('news.index');
    // Route Create News
    Route::get('/dashboard/news/create', [NewsController::class, 'create'])->name('news.create');
    Route::post('/dashboard/news', [NewsController::class, 'store'])->name('news.store');
    // Route Update News
    Route::get('/dashboard/news/{news}/edit', [NewsController::class, 'edit'])->name('news.edit');
    Route::patch('/dashboard/news/{news}', [NewsController::class, 'update'])->name('news.update');
    // Route Delete News
    Route::delete('/dashboard/news/{news}', [NewsController::class, 'destroy'])->name('news.delete');
    // Route Show News
    Route::get('/dashboard/news/{news}', [NewsController::class, 'show'])->name('news.show');
    
});