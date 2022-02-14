<?php

namespace App\Http\Controllers\Hospital;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function createContact() {
        return Inertia::render('Hospital/Contact');
    }
}
