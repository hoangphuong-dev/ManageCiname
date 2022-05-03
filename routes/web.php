<?php

use App\Http\Controllers\Customer\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Middleware\IgnoreCustomerMiddleware;

// Customer
Route::get('/', [CustomerController::class, 'index'])->name('home');

Route::get('/movie-detail/{id}', [CustomerController::class, 'detailMovie'])->name('movie.detail');

Route::get('/order-ticket.html', [CustomerController::class, 'orderTicket'])->name('order.ticket');

Route::get('/show-seats-by-showtimes.html', [CustomerController::class, 'showSeatByShowTime'])->name('show_seat_by_showtime');

Route::get('/customer-order.html', [CustomerController::class, 'getInfoCustomer'])->name('get_info_customer');

Route::get('/order-success-bill-{id}', [CustomerController::class, 'orderSuccess'])->name('order-success');

Route::get('/authentication-token/{token}', [CustomerController::class, 'authenOrder'])->name('authen_order');

Route::get('/download-bill-pdf/{id}', [CustomerController::class, 'downloadPDF'])->name('download_bill_pdf');

Route::post('/order.html', [CustomerController::class, 'order'])->name('order');

Route::get('/order-send-mail.html', [CustomerController::class, 'NoticationSendMail'])->name('notication-send-mail');

Route::get('/movies.html', [CustomerController::class, 'index'])->name('movies');

Route::get('/member.html', [CustomerController::class, 'index'])->name('member');

Route::get('/login.html', [CustomerController::class, 'login'])->name('customer.login')->middleware(IgnoreCustomerMiddleware::class);
Route::post('/login.html', [CustomerController::class, 'handleLogin']);

Route::get('/forgot-password.html', [CustomerController::class, 'forgotPasword'])->name('customer.forgot_pasword');
Route::post('/forgot-password.html', [CustomerController::class, 'handleForgotPassword']);

Route::get('/confirm-forgot-password', [CustomerController::class, 'confirmForgotPassword'])->name('confirm_forgot_password');
Route::post('/confirm-forgot-password', [CustomerController::class, 'handleConfirmForgotPassword']);

Route::get('/movie-now-showing.html', [CustomerController::class, 'getMovieNowShowing'])->name('now_showing');

Route::get('/movie-comming-soon.html', [CustomerController::class, 'getMovieCommingSoon'])->name('comming_soon');


Route::get('/authenticate-email', [ProfileController::class, 'AuthenticateMail'])->name('authenticate-email');


Route::group(['middleware' => ['customer']], function () {
    Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::get('/my-ticket.html', [CustomerController::class, 'myTicket'])->name('ticket');

    Route::get('/my-profile.html', [ProfileController::class, 'index'])->name('profile');
    Route::get('/my-voucher.html', [ProfileController::class, 'myVoucher'])->name('voucher');
    Route::post('/exchange-point', [ProfileController::class, 'exchangePoint'])->name('customer.exchange-point');

    Route::post('/update', [ProfileController::class, 'update'])->name('customer.update-profile');

    Route::resources([
        'comments' => CommentController::class,
    ]);
});


Route::get('abc', function () {
    return response('Hello World', 200)
        ->header('Content-Type', 'text/plain');
});
