<?php

namespace App\Http\Controllers\Backs\SuperAdmin;

use App\Http\Controllers\Controller;
use App\Models\Province;
use Inertia\Inertia;

class AdminInfoController extends Controller
{
    public function create()
    {
        $provinces = Province::all();
        return Inertia::render("Backs/SuperAdmin/FormAdminInfo", [
            'provinces' => $provinces,
        ]);
    }
}
