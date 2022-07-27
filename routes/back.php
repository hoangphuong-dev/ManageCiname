<?php

use App\Http\Controllers\Backs\Admin\AdminController;
use App\Http\Controllers\Backs\Admin\BillController;
use App\Http\Controllers\Backs\Admin\CinemaController;
use App\Http\Controllers\Backs\Admin\RoomController;
use App\Http\Controllers\Backs\Admin\ShowTimeController;
use App\Http\Controllers\Backs\Admin\StaffController as AdminStaffController;
use App\Http\Controllers\Backs\AuthenticationController;
use App\Http\Controllers\Backs\Staff\StaffController;
use App\Http\Controllers\Backs\SuperAdmin\MovieController;
use App\Http\Controllers\Backs\SuperAdmin\SeatTypeController;
use App\Http\Controllers\Backs\SuperAdmin\SuperAdminController;
use App\Http\Middleware\IgnoreAdminLoginMiddleware;
use App\Http\Middleware\IgnoreLoginMiddleware;
use Illuminate\Support\Facades\Route;


Route::group(['as' => 'back.'], function () {
    Route::get('/login', [AuthenticationController::class, 'showLogin'])->name('login.get')->middleware(IgnoreAdminLoginMiddleware::class);
    Route::get('/register-staff', [AuthenticationController::class, 'registerStaff'])->name('register.staff');
    // ->middleware(IgnoreLoginMiddleware::class);
    Route::post('/login', [AuthenticationController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthenticationController::class, 'registerSubmit'])->name('staff.register');
    Route::get('/confirm-acount/{admin_id}', [AuthenticationController::class, 'confirmAdmin'])->name('confirm.acount');
});

Route::group(['as' => 'superadmin.', 'prefix' => 'superadmin', 'middleware' => ['superadmin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutSuperAdmin'])->name('logout_super');
    Route::get('/', [SuperAdminController::class, 'index'])->name('home');

    Route::prefix('/seat_type')->as('seat_type.')->group(function () {
        Route::get('', [SeatTypeController::class, 'index'])->name('index');
        Route::post('edit/{id}', [SeatTypeController::class, 'edit'])->name('update');
        Route::delete('delete/{id}', [SeatTypeController::class, 'delete'])->name('delete');
        Route::post('store', [SeatTypeController::class, 'store'])->name('store');
    });

    Route::prefix('/movie')->as('movie.')->group(function () {
        Route::get('/', [MovieController::class, 'index'])->name('index');
        Route::delete('delete/{id}', [MovieController::class, 'delete'])->name('delete');
        Route::post('store', [MovieController::class, 'store'])->name('store');
        Route::get('/create-movie', [MovieController::class, 'create'])->name('create_movie');
        Route::get('/edit/{id}', [MovieController::class, 'edit'])->name('edit');

        Route::post('import', [MovieController::class, 'importCsv'])->name('import');
        Route::get('export', [MovieController::class, 'exportCsv'])->name('export');
    });

    // Route::get('/create_admin', [AdminInfoController::class, 'create'])->name('create_admin');

    // Quản lý hệ thống rạp
    Route::prefix('/cinema')->as('cinema.')->group(function () {
        Route::get('/master', [CinemaController::class, 'getMasterCinema'])->name('master');
        Route::get('/province/{id}', [CinemaController::class, 'getCinemaByProvince'])->name('province');
    });


    Route::post('cinemas/{id}', [CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::post('cinemas', [CinemaController::class, 'store'])->name('cinemas.store');
    Route::post('cinemas/{id}', [CinemaController::class, 'edit'])->name('cinemas.edit');
    Route::get('cinemas/show/{id}', [CinemaController::class, 'show'])->name('cinemas.show');
    Route::delete('cinemas/{id}', [CinemaController::class, 'delete'])->name('cinemas.delete');
});

Route::group(['as' => 'admin.', 'prefix' => 'admin', 'middleware' => ['admin']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutAdmin'])->name('logout_admin');
    Route::get('/', [AdminController::class, 'index'])->name('home');

    // start manage cinema
    Route::get('showtimes', [ShowTimeController::class, 'index'])->name('showtime.index');

    Route::get('cinemas/show', [CinemaController::class, 'showCinemaByAdmin'])->name('cinemas.show');

    Route::post('rooms', [RoomController::class, 'store'])->name('rooms.store');
    Route::delete('rooms/{id}', [RoomController::class, 'delete'])->name('rooms.delete');

    Route::post('showtimes', [ShowTimeController::class, 'store'])->name('showtimes.store');

    Route::get('cinemas/{cinema_id}/movie/{movie_id}/day/{day}', [ShowTimeController::class, 'viewDetailShowTimes'])
        ->name('view_detail_showtimes');

    Route::get('cinemas/{cinema_id}/showtime/{show_time_id}', [ShowTimeController::class, 'viewDetailShowTimeById'])
        ->name('view-showtime-by-id');
    // end manage cinema

    Route::prefix('/bill')->as('bill.')->group(function () {
        Route::get('/', [BillController::class, 'getBillByAdmin'])->name('index');
    });

    Route::prefix('/staff')->as('staff.')->group(function () {
        Route::get('/', [AdminStaffController::class, 'index'])->name('index');
        Route::delete('delete/{id}', [AdminStaffController::class, 'delete'])->name('delete');
        Route::put('update-status-staff/{id}', [AdminStaffController::class, 'updateStatus'])->name('update-status');
    });
});

Route::group(['as' => 'staff.', 'prefix' => 'staff', 'middleware' => ['staff']], function () {
    Route::get('/logout', [AuthenticationController::class, 'logoutStaff'])->name('logout');
    Route::get('/', [StaffController::class, 'index'])->name('home');

    Route::get('/movie-now-showing', [StaffController::class, 'getMovieNowShowing'])
        ->name('movie-now-showing');
    Route::get('/movie-comming-soon', [StaffController::class, 'getMovieCommingSoon'])
        ->name('movie-comming-soon');
});
