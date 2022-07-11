<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CastController;
use App\Http\Controllers\Api\FormatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieGenreController;
use App\Http\Controllers\Api\ProvinceController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SeatTypeController;
use App\Http\Controllers\Api\ShowTimeController;
use App\Http\Controllers\Backs\Admin\BillController;
use App\Http\Controllers\Backs\Admin\StaffController;
use App\Http\Controllers\Customer\CommentController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\NotificationController;

Route::apiResource('moviegenres', MovieGenreController::class);

Route::get('get-all-staff', [StaffController::class, 'getAll'])->name('staff.getAll');
Route::put('update-status-staff/{id}', [StaffController::class, 'updateStatus'])->name('staff.update-status');
Route::apiResource('admins', AdminController::class);


Route::apiResource('casts', CastController::class);
Route::apiResource('seat_types', SeatTypeController::class);
Route::apiResource('rooms', RoomController::class);
Route::apiResource('formats', FormatController::class);
Route::put('/rooms/{id}/update-status', [RoomController::class, 'changeStatus'])
    ->name('rooms.change_status');
Route::get('/showtimes/room/{id}', [ShowTimeController::class, 'listShowTimeByRoom'])
    ->name('showtimes.rooms');

Route::get('/bill/{id}', [BillController::class, 'getBillById']);

Route::apiResource('showtimes', ShowTimeController::class);
Route::get('province-has-cinemas', [ProvinceController::class, 'getProvinceHasCinema']);

Route::get('get-cinema-by-province/{id}', [CustomerController::class, 'getCinemaByProvince']);

Route::get('/get-comments', [CommentController::class, 'getComment'])
    ->name('movies.comment');


Route::prefix('/notification')->group(function () {
    Route::get('/', [NotificationController::class, 'getAllNotification'])->name('notification.getAll');
    Route::get('/mark-read/{id}', [NotificationController::class, 'markRead'])->name('notification.mark-read');
});
