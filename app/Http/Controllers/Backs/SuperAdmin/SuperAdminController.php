<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class SuperAdminController extends Controller
{
    public function index()
    {
        return Inertia::render('Backs/SuperAdmin/Index');
    }

}
