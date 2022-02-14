<?php

namespace App\Http\Controllers\Caretaker;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Inertia::render('Caretaker/Messenger/Index');
    }

    /**
     * Handle the message from user in realtime chat
     *
     * @return \Illuminate\Http\Response
     */
    public function handleMessage()
    {
        return Inertia::render('Caretaker/Messenger/Index');
    }


}
