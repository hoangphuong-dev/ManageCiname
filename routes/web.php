<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\CustomerController;
// Customer
Route::get('/', [CustomerController::class, 'index'])->name('home');
