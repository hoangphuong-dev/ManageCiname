<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function handleMessage(Request $request)
    {
        \Log::debug($request->all());
    }
}
