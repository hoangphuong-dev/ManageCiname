<?php

use App\Http\Controllers\Backs\Admin\AdminController;
use App\Http\Controllers\Backs\AuthenticationController;
use App\Http\Controllers\Backs\Staff\StaffController;
use App\Http\Controllers\Backs\SuperAdmin\MovieController;
use App\Http\Controllers\Backs\SuperAdmin\MovieGenreController;
use App\Http\Controllers\Backs\SuperAdmin\SuperAdminController;
use App\Http\Controllers\Backs\UserController;
use App\Http\Middleware\IgnoreLoginMiddleware;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'back.'], function () {
    //     // Login
    Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login.get');
    // ->middleware(IgnoreLoginMiddleware::class);
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login.post');
});

Route::group(['prefix' => 'superadmin', 'middleware' => ['superadmin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutSuperAdmin'])->name('logout_super');
    Route::get('/home', [SuperAdminController::class, 'index'])->name('home_super');
    Route::get('/movies', [MovieController::class, 'index'])->name('movies.index');
    Route::get('/movie_genres', [MovieGenreController::class, 'index'])->name('movie_genre.index');
});

Route::group(['middleware' => ['admin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutAdmin'])->name('logout_admin');
    Route::get('/home', [AdminController::class, 'index'])->name('home_admin');
    Route::get('users', [UserController::class, 'index'])->name('user');
});

Route::group(['prefix' => 'staff', 'middleware' => ['staff']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutStaff'])->name('logout_staff');
    Route::get('/home', [StaffController::class, 'index'])->name('home_staff');
});
