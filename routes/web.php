<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\CommunityGroupController;
use App\Http\Controllers\CommunityMemberController;
use App\Http\Controllers\CashLoanController;
use App\Http\Controllers\MonthlyInstallmentController;

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

Route::middleware(['auth:web'])->name('citizen.')->prefix('citizen')->group(
    function () {
        Route::get('/', [CitizenController::class, 'index'])->name('index');
        Route::get('/datatables', [CitizenController::class, 'dataTablesCitizen'])->name('datatables');
        Route::get('/datachoices', [CitizenController::class, 'dataChoicesCitizen'])->name('datachoices');
        Route::get('/create', [CitizenController::class, 'create'])->name('create');
        Route::post('/store', [CitizenController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CitizenController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [CitizenController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CitizenController::class, 'delete'])->name('delete');
    }
);

Route::middleware(['auth:web'])->name('community-group.')->prefix('community-group')->group(
    function () {
        Route::get('/', [CommunityGroupController::class, 'index'])->name('index');
        Route::get('/datatables', [CommunityGroupController::class, 'dataTablesCommunityGroup'])->name('datatables');
        Route::get('/create', [CommunityGroupController::class, 'create'])->name('create');
        Route::post('/store', [CommunityGroupController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CommunityGroupController::class, 'edit'])->name('edit');
        Route::get('/detail/{id}', [CommunityGroupController::class, 'detail'])->name('detail');
        Route::post('/update/{id}', [CommunityGroupController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CommunityGroupController::class, 'delete'])->name('delete');
        Route::name('member.')->prefix('member/{community_id}')->group(
            function () {
                    Route::get('/datatables', [CommunityMemberController::class, 'dataTablesCommunityMember'])->name('datatables');
                    Route::get('/create', [CommunityMemberController::class, 'create'])->name('create');
                    Route::post('/store', [CommunityMemberController::class, 'store'])->name('store');
                    Route::get('/edit/{id}', [CommunityMemberController::class, 'edit'])->name('edit');
                    Route::post('/update/{id}', [CommunityMemberController::class, 'update'])->name('update');
                    Route::get('/delete/{id}', [CommunityMemberController::class, 'delete'])->name('delete');
                }
        );
    }
);

Route::middleware(['auth:web'])->name('cash-loan.')->prefix('cash-loan')->group(
    function () { 
        Route::get('/', [CashLoanController::class, 'index'])->name('index');
        Route::get('/datatables', [CashLoanController::class, 'dataTablesCashLoan'])->name('datatables');
        Route::get('/datatables-monthly/{id}', [MonthlyInstallmentController::class, 'dataTablesMonthly'])->name('datatables.monthly');
        Route::get('/create', [CashLoanController::class, 'create'])->name('create');
        Route::post('/store', [CashLoanController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [CashLoanController::class, 'edit'])->name('edit');
        Route::get('/detail/{id}', [CashLoanController::class, 'detail'])->name('detail');
        Route::get('/monthly', [MonthlyInstallmentController::class, 'find'])->name('monthly');
        Route::post('/monthly/{id}', [MonthlyInstallmentController::class, 'updateAPI'])->name('monthly.update');
        Route::post('/update/{id}', [CashLoanController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [CashLoanController::class, 'delete'])->name('delete');
    }
);