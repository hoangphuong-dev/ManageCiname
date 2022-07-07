<?php

use App\Http\Controllers\Customer\CommentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\ProfileController;
use App\Http\Middleware\IgnoreCustomerMiddleware;

// Customer
Route::get('/home', [CustomerController::class, 'index'])->name('home');

Route::get('/movie-detail/{id}', [CustomerController::class, 'detailMovie'])->name('movie.detail');

Route::get('/order-ticke', [CustomerController::class, 'orderTicket'])->name('order.ticket');

Route::get('/show-seats-by-showtime', [CustomerController::class, 'showSeatByShowTime'])->name('show_seat_by_showtime');

Route::get('/order-success-bill-{id}', [CustomerController::class, 'orderSuccess'])->name('order-success');


Route::get('/download-bill-pdf/{id}', [CustomerController::class, 'downloadPDF'])->name('download_bill_pdf');


Route::get('/order-send-mai', [CustomerController::class, 'NoticationSendMail'])->name('notication-send-mail');

Route::get('/movie', [CustomerController::class, 'index'])->name('movies');

Route::get('/membe', [CustomerController::class, 'index'])->name('member');

Route::get('/logi', [CustomerController::class, 'login'])->name('customer.login')->middleware(IgnoreCustomerMiddleware::class);
Route::post('/logi', [CustomerController::class, 'handleLogin']);

Route::get('/forgot-passwor', [CustomerController::class, 'forgotPasword'])->name('customer.forgot_pasword');
Route::post('/forgot-passwor', [CustomerController::class, 'handleForgotPassword']);

Route::get('/confirm-forgot-password', [CustomerController::class, 'confirmForgotPassword'])->name('confirm_forgot_password');
Route::post('/confirm-forgot-password', [CustomerController::class, 'handleConfirmForgotPassword']);

Route::get('/authenticate-email', [ProfileController::class, 'AuthenticateMail'])->name('authenticate-email');

Route::post('/get-cinema-by-province/{id}', [CustomerController::class, 'getCinemaByProvince'])->name('get-cinema-by-province');

Route::group(['as' => 'order.', 'prefix' => 'order'], function () {
    Route::get('/customer-orde', [PaymentController::class, 'getInfoCustomer'])
        ->name('get_info_customer');
    Route::post('/authen-email', [PaymentController::class, 'authenEmail'])->name('authen-email');
    Route::get('/authentication-token/{token}', [PaymentController::class, 'authenOrder'])->name('authen-token');

    Route::get('/vnpay_return', [PaymentController::class, 'vnpayReturn'])->name('vnpayReturn');
});

Route::group(['middleware' => ['customer']], function () {
    Route::get('/logout', [CustomerController::class, 'logout'])->name('customer.logout');
    Route::get('/my-ticke', [CustomerController::class, 'myTicket'])->name('ticket');

    Route::get('/my-profil', [ProfileController::class, 'index'])->name('profile');
    Route::get('/my-vouche', [ProfileController::class, 'myVoucher'])->name('voucher');
    Route::post('/exchange-point', [ProfileController::class, 'exchangePoint'])->name('customer.exchange-point');

    Route::post('/update', [ProfileController::class, 'update'])->name('customer.update-profile');

    Route::resources([
        'comments' => CommentController::class,
    ]);

    Route::put('toggle-favorite', [CommentController::class, 'toggleFavorite'])->name('comment.toggle-favorite');
});
