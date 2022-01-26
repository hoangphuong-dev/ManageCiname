<?php

namespace App\Http\Controllers\Backs\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class RoomController extends Controller
{
    public function index()
    {
        return Inertia::render('Backs/Admin/Room');
    }
}
