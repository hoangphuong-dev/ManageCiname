<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory;
    use Notifiable;

    public const ROLE_SUPERADMIN = 0;
    public const ROLE_ADMIN = 4;
    public const ROLE_STAFF = 2;
    public const ROLE_CUSTOMER = 3;

    public const ACCOUNT_ACTIVE = 10;
    public const ACCOUNT_DEACTIVE = 11;

    protected $guarded = [];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'status' => 'integer',
        'role' => 'integer',
        'created_at'  => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
    ];

    public function scopeIsAdmin()
    {
        return $this->role === self::ROLE_ADMIN;
    }

    public function scopeIsSuperAdmin()
    {
        return $this->role === self::ROLE_SUPERADMIN;
    }

    public function scopeIsStaff()
    {
        return $this->role === self::ROLE_STAFF;
    }

    public function scopeIsCustomer()
    {
        return $this->role === self::ROLE_CUSTOMER;
    }

    public function scopeGuardName()
    {
        switch ($this->role) {
            case self::ROLE_ADMIN:
                return 'admin';
            case self::ROLE_SUPERADMIN:
                return 'superadmin';
            case self::ROLE_STAFF:
                return 'staff';
            case self::ROLE_CUSTOMER:
                return 'customer';
        }
        return null;
    }

    public function scopeIsAccountDeActive()
    {
        return $this->status === self::ACCOUNT_DEACTIVE;
    }

    public function routeRedirect()
    {
        if($this->IsAdmin()) {
            return route('home_admin');
        }
        if ($this->IsSuperAdmin()) {
            return route('home_super');
        }
        if ($this->IsStaff()) {
            return route('home_staff');

        }
    }



}
