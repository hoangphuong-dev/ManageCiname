<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\FormatMovie;
use Illuminate\Http\Request;

class FormatController extends Controller
{
    public function index()
    {
        $formats =  FormatMovie::get()->toArray();
        return $formats;
    }

    public function store(Request $request)
    {
        FormatMovie::create([
            'name' => $request->name,
        ]);
    }

    public function destroy($id)
    {
        //
    }
}
