<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\CastController;
use App\Http\Controllers\Api\FormatController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MovieController;
use App\Http\Controllers\Api\MovieGenreController;
use App\Http\Controllers\Api\RoomController;
use App\Http\Controllers\Api\SeatTypeController;
use App\Http\Controllers\Api\ShowTimeController;
use App\Http\Controllers\Backs\Admin\BillController;
use App\Http\Controllers\Customer\CustomerController;

Route::apiResource('moviegenres', MovieGenreController::class);
Route::apiResource('movies', MovieController::class);
Route::put('/movies/{id}/update-status', [MovieController::class, 'changeStatus'])
    ->name('movies.change_status');


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
Route::get('provinces', [CustomerController::class, 'getProvince']);

Route::get('get-cinema-by-province/{id}', [CustomerController::class, 'getCinemaByProvince']);
