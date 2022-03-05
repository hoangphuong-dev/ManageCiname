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
Route::apiResource('showtimes', ShowTimeController::class);
