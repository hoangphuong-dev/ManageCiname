<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use AuthorizesRequests;

    protected function sendErrorResponse($message, $errors = null, $code = 400)
    {
        return response()->json([
            'status_code' => $code,
            'message' => $message,
            'errors' => $errors,
        ]);
    }

    protected function sendSuccessResponse($data, $message = '', $code = 200)
    {
        return response()->json([
            'status_code' => $code,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
