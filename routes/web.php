<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;

Route::middleware(['auth:web'])->get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth:web'])->name('user.')->prefix('user')->group(
    function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/get/{id}', [UserController::class, 'get'])->name('get');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/store', [UserController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [UserController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [UserController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [UserController::class, 'delete'])->name('delete');
    }
);