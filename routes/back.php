<?php

use App\Http\Controllers\Back\CinemaController;
use Illuminate\Support\Facades\Route;

// Admins
// Route::group(['as' => 'back.'], function () {
//     Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login.get')->middleware(IgnoreAdminLoginMiddleware::class);
//     Route::post('/login', [AuthenticationController::class, 'login'])->name('login.post');
// });


Route::group(['as' => 'back.'], function () {
    // Route::get('/logout', [AuthenticationController::class, 'logout'])->name('logout');
    Route::get('/cinemas', [CinemaController::class, 'index'])->name('cinemas');
    Route::get('/rooms', [CinemaController::class, 'abc'])->name('rooms');
    Route::get('/showtimes', [CinemaController::class, 'afasfas'])->name('showtimes');
    Route::get('/bills', [CinemaController::class, 'fwefew'])->name('bills');
    Route::get('/staffs', [CinemaController::class, 'gewgewg'])->name('staffs');

});
