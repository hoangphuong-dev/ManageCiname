<?php

use App\Http\Controllers\Backs\Admin\AdminController;
use App\Http\Controllers\Backs\Admin\BillController;
use App\Http\Controllers\Backs\Admin\CinemaController;
use App\Http\Controllers\Backs\Admin\RoomController;
use App\Http\Controllers\Backs\Admin\ShowTimeController;
use App\Http\Controllers\Backs\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Backs\AuthenticationController;
use App\Http\Controllers\Backs\Staff\StaffController;
use App\Http\Controllers\Backs\SuperAdmin\AdminInfoController;
use App\Http\Controllers\Backs\SuperAdmin\MovieController;
use App\Http\Controllers\Backs\SuperAdmin\SeatTypeController;
use App\Http\Controllers\Backs\SuperAdmin\SuperAdminController;
use App\Http\Middleware\IgnoreLoginMiddleware;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'back.'], function () {
    Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login.get');
    Route::get('/register-staff', [AuthenticationController::class, 'registerStaff'])->name('register.staff');
    // ->middleware(IgnoreLoginMiddleware::class);
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthenticationController::class, 'register'])->name('staff.register');
});

Route::group(['as' => 'superadmin.', 'prefix' => 'superadmin', 'middleware' => ['superadmin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutSuperAdmin'])->name('logout_super');
    Route::get('/home', [SuperAdminController::class, 'index'])->name('home_super');
    Route::get('/movies', [MovieController::class, 'index'])->name('movie.index');
    Route::get('/admin_infos', [AdminInfoController::class, 'index'])->name('admin_info.index');
    Route::get('/seat_types', [SeatTypeController::class, 'index'])->name('seat_type.index');

    Route::get('/create_admin', [AdminInfoController::class, 'create'])->name('create_admin');
    Route::get('/create_movie', [MovieController::class, 'create'])->name('create_movie');
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutAdmin'])->name('logout_admin');
    Route::get('/home', [AdminController::class, 'index'])->name('home_admin');
    Route::get('/cinemas', [CinemaController::class, 'index'])->name('cinema.index');
    // Route::get('rooms', [RoomController::class, 'index'])->name('room.index');
    Route::get('showtimes', [ShowTimeController::class, 'index'])->name('showtime.index');
    Route::get('bills', [BillController::class, 'index'])->name('bill.index');
    Route::get('staffs', [AdminStaffController::class, 'index'])->name('staff.index');

    Route::post('cinemas', [CinemaController::class, 'store'])->name('cinemas.store');
    Route::post('cinemas/{id}', [CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::get('cinemas/show/{id}', [CinemaController::class, 'show'])->name('cinemas.show');
    Route::delete('cinemas/{id}', [CinemaController::class, 'delete'])->name('cinemas.delete');

    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
});

Route::group(['prefix' => 'staff', 'middleware' => ['staff']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutStaff'])->name('logout_staff');
    Route::get('/home', [StaffController::class, 'index'])->name('home_staff');
});
