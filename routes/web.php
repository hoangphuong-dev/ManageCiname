<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\ProfileController;

// Customer
Route::get('/', [CustomerController::class, 'index'])->name('home');

Route::get('/movie-detail/{id}', [CustomerController::class, 'detailMovie'])->name('movie.detail');

Route::get('/order-ticket', [CustomerController::class, 'orderTicket'])->name('order.ticket');

Route::get('/show-seats-by-showtimes', [CustomerController::class, 'showSeatByShowTime'])->name('show_seat_by_showtime');

Route::get('/customer-order', [CustomerController::class, 'getInfoCustomer'])->name('get_info_customer');

Route::get('/order-success-bill-{id}', [CustomerController::class, 'orderSuccess'])->name('order-success');

Route::get('/authentication-token/{token}', [CustomerController::class, 'authenOrder'])->name('authen_order');

Route::get('/download-bill-pdf/{id}', [CustomerController::class, 'downloadPDF'])->name('download_bill_pdf');

Route::post('/order', [CustomerController::class, 'order'])->name('order');

Route::get('/movies', [CustomerController::class, 'index'])->name('movies');

Route::get('/member', [CustomerController::class, 'index'])->name('member');

Route::get('/login', [CustomerController::class, 'login'])->name('customer.login');

Route::post('/login', [CustomerController::class, 'handleLogin']);

Route::get('/movie-now-showing', [CustomerController::class, 'getMovieNowShowing'])->name('now_showing');

Route::get('/movie-comming-soon', [CustomerController::class, 'getMovieCommingSoon'])->name('comming_soon');



Route::group(['middleware' => ['customer']], function () {
    Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::get('/my-ticket', [CustomerController::class, 'myTicket'])->name('my_ticket');

    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
});
