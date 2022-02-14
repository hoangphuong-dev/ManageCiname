<?php

namespace App\Http\Controllers\Backs;

use App\Http\Controllers\Controller;
use App\Services\ContactService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ContactController extends Controller
{
    protected $contactService;

    public function __construct(ContactService $contactService)
    {
        $this->contactService = $contactService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Backs/Contact/Index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function detail($id)
    {
        $contact = $this->contactService->show($id);
        return Inertia::render('Backs/Contact/Detail', ['contact' => $contact]);
    }
}
