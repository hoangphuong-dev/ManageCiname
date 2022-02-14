<?php

namespace App\Http\Controllers\Api;

use App\Helper\JwtHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
    public function refreshToken(Request $request)
    {
        try {
            $refresh_token = $request->input('refresh_token');

            $payload = JwtHelper::parse($refresh_token);

            $newPayload = JwtHelper::make($payload);
            return response()->json($newPayload);

        } catch (\Exception $e) {
            abort(401);
        }
    }
}
