<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Services\GoogleService;

class GoogleController extends Controller
{
    private $googleService;

    public function __construct(GoogleService $googleService)
    {
        $this->googleService = $googleService;
    }

    public function loginWithGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callbackFromGoogle()
    {
        try {
            $this->googleService->login();

            return redirect(route('home'));
        } catch (\Exception $e) {
            return redirect()->route('login')->with(['error' => $e->getMessage()]);
        }
    }
}
