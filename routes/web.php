<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\SettingController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

/*
|--------------------------------------------------------------------------
| Home
|--------------------------------------------------------------------------
*/

Route::get('/home', [AdminController::class, 'dashboard'])
    ->name('home');

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::prefix('admin')->group(function () {

    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])
        ->name('admin.dashboard');

    // Users
    Route::get('/users', [AdminController::class, 'users'])
        ->name('admin.users');

    // Bets
    Route::get('/bets', [AdminController::class, 'bets'])
        ->name('admin.bets');

    // Deposits
    Route::get('/deposits', [AdminController::class, 'deposits'])
        ->name('admin.deposits');
    Route::post('/deposits/{id}/approve',
        [AdminController::class, 'approveDeposit']);

    Route::post('/deposits/{id}/reject',
        [AdminController::class, 'rejectDeposit']);

    // Withdrawals
    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])
        ->name('admin.withdrawals');
    Route::post('/withdrawals/{id}/approve',
        [AdminController::class, 'approveWithdrawal']);

    Route::post('/withdrawals/{id}/reject',
        [AdminController::class, 'rejectWithdrawal']);

    // Rounds
    Route::get('/rounds', [AdminController::class, 'rounds'])
        ->name('admin.rounds');

    /*
    |--------------------------------------------------------------------------
    | SETTINGS
    |--------------------------------------------------------------------------
    */

    Route::get('/settings', [SettingController::class, 'index'])
        ->name('admin.settings');

    Route::post('/settings/update', [SettingController::class, 'update'])
        ->name('admin.settings.update');

    Route::post('/user/update/{id}', [SettingController::class, 'updateUser'])
        ->name('admin.user.update');

});