<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
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

Route::get('/your-ticket', [CustomerController::class, 'index'])->name('your_ticket');

Route::get('/member', [CustomerController::class, 'index'])->name('member');
