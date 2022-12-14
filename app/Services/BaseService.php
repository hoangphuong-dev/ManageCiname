<?php

namespace App\Services;

use App\Models\Cinema;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class BaseService
{
    public const GUARD = ['admin', 'superadmin', 'staff', 'customer'];

    public function getUserId($guard)
    {
        $user = Auth::guard($guard)->user();
        return !is_null($user) ? $user->id : null;
    }

    public function getCurrentUserId()
    {
        foreach (self::GUARD as $guard) {
            if (Auth::guard($guard)->check()) {
                return $this->getUserId($guard);
            }
        }
        return null;
    }

    public function getGuard()
    {
        foreach (self::GUARD as $guard) {
            if (Auth::guard($guard)->check()) {
                return $guard;
            }
        }
        return null;
    }

    public function getUser()
    {
        foreach (self::GUARD as $guard) {
            if (Auth::guard($guard)->check()) {
                return Auth::guard($guard)->user();
            }
        }
        return null;
    }

    public function isCustomerRole()
    {
        return $this->getGuard() === 'customer';
    }

    public function isStaffRole()
    {
        return $this->getGuard() === 'staff';
    }

    public function isAdminRole()
    {
        return $this->getGuard() === 'admin';
    }
    public function isSuperAdminRole()
    {
        return $this->getGuard() === 'superadmin';
    }

    public function getCinemaByStaff()
    {
        $user = User::whereId($this->getUserId('staff'))->with('staffInfo')->first();
        return $user->staffInfo->cinema_id ?? null;
    }

    public function getCinemaId()
    {
        $adminId = $this->getUserId('admin');
        return Cinema::where('user_id', $adminId)->first()->id;
    }
}
