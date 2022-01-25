<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminInfoController extends Controller
{
    public function index()
    {
        return Inertia::render("Backs/SuperAdmin/AdminInfo");
    }
}
