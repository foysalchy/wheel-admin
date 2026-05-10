<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
 


 

Route::prefix('admin')->group(function () {

    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

    Route::get('/users', [AdminController::class, 'users'])->name('admin.users');

    Route::get('/bets', [AdminController::class, 'bets'])->name('admin.bets');

    Route::get('/deposits', [AdminController::class, 'deposits'])->name('admin.deposits');

    Route::get('/withdrawals', [AdminController::class, 'withdrawals'])->name('admin.withdrawals');

    Route::get('/rounds', [AdminController::class, 'rounds'])->name('admin.rounds');

});