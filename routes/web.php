<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CitizenController;
use App\Http\Controllers\MarketController;
use App\Http\Controllers\CommunityGroupController;
use App\Http\Controllers\CommunityMemberController;
use App\Http\Controllers\CashLoanController;
use App\Http\Controllers\MonthlyInstallmentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\DashboardController;


Route::middleware(['auth:web'])->get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/authenticate', [AuthController::class, 'authenticate'])->name('authenticate');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->get('/profile', [ProfileController::class, 'index'])->name('profile');
Route::middleware(['auth'])->post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

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

Route::middleware(['auth:web'])->name('market.')->prefix('market')->group(
    function () {
        Route::get('/', [MarketController::class, 'index'])->name('index');
        Route::get('/datatables', [MarketController::class, 'dataTablesMarket'])->name('datatables');
        Route::get('/json', [MarketController::class, 'getJson'])->name('json');
        Route::get('/create', [MarketController::class, 'create'])->name('create');
        Route::post('/store', [MarketController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [MarketController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [MarketController::class, 'update'])->name('update');
        Route::get('/delete/{id}', [MarketController::class, 'delete'])->name('delete');
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
        Route::get('/paid-off/{id}', [CashLoanController::class, 'paidOff'])->name('paid-off');
        Route::post('/checkmember', [CashLoanController::class, 'checkMember'])->name('checkmember');
    }
);

Route::get('/export-excel', [ReportController::class, 'exportExcel'])->middleware(['auth:web'])->name('export-excel');

Route::get('/test-report', [ReportController::class, 'testReport'])->middleware(['auth:web']);