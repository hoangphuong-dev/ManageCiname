<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
// Customer
Route::get('/', [CustomerController::class, 'index'])->name('home');

Route::get('/movie-detail/{id}', [CustomerController::class, 'detailMovie'])->name('movie.detail');

Route::get('/order-ticket', [CustomerController::class, 'orderTicket'])->name('order.ticket');

Route::get('/show-seats-by-showtimes', [CustomerController::class, 'showSeatByShowTime'])->name('show_seat_by_showtime');

Route::get('/confirm-order', [CustomerController::class, 'confirmOrder'])->name('confirm_order');

Route::get('/order-success-bill-{id}', [CustomerController::class, 'orderSuccess'])->name('order-success');

Route::post('/order', [CustomerController::class, 'order'])->name('order');

Route::get('/movies', [CustomerController::class, 'index'])->name('movies');

Route::get('/your-ticket', [CustomerController::class, 'index'])->name('your_ticket');

Route::get('/member', [CustomerController::class, 'index'])->name('member');
