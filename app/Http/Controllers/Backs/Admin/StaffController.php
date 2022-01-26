<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class StaffController extends Controller
{
    public function index()
    {
        return Inertia::render('Backs/Admin/Staff');
    }
}
