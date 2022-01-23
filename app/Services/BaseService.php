<?php
namespace App\Services;

use App\Exceptions\CouldNotFindUserIdException;
use Illuminate\Support\Facades\Auth;

class BaseService {

    public function getUserId($guard)
    {
        $user = Auth::guard($guard)->user();
        return !is_null($user) ? $user->id : null;
    }
}
