<?php

namespace App\Http\Controllers\Api\Back;

use App\Helper\ImageHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminImageUploadRequest;

class AdminController extends Controller
{
    public function uploadImage(AdminImageUploadRequest $request)
    {
        $file = ImageHelper::upload($request->image, null, 'notifications');

        return response()->json([
            'status' => 200,
            'url' => ImageHelper::get($file)
        ]);
    }
}
