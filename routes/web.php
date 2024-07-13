<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/users', [UserController::class, 'index'])->name('users.index');
Route::delete('/users/{uuid}', [UserController::class, 'destroy'])->name('users.destroy');
Route::get('/daily-records', [UserController::class, 'dailyRecords'])->name('users.daily_records');