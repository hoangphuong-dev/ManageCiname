<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class CustomerController extends Controller
{
    public function index() {
        return Inertia::render('Customer/Home');
    }
}
