<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class ErrorPageController extends Controller
{
    public function renderView($error)
    {
        return Inertia::render("Errors/{$error}");
    }

    public function Error404()
    {

        return $this->renderView(404);
    }
}
