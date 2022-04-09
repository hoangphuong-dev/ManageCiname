<?php

namespace App\Http\Controllers\Backs\Staff;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShowTimeController extends Controller
{
    public function __construct()
    {
    }

    public function index(Request $request)
    {
        return Inertia::render('Backs/Staff/ShowTime');
    }
}
