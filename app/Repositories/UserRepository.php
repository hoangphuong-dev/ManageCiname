<?php

namespace App\Repositories;

use App\Models\Filters\UserFilters;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function all()
    {
        return $this->user->all();
    }

    public function findByEmail($email)
    {
        return $this->user->query()->where('email', $email)->first();
    }

    public function findByToken($token)
    {
        return $this->user->query()->where('token_life_time', $token)->first();
    }

    public function hospitalList($request)
    {
        return $this->user->query()
            ->roleHospital()
            ->filters(new UserFilters($request))
            ->paginate($request->query('limit', 10));
    }

    public function updateStatus($id, $status)
    {
        return $this->user->find($id)->update(['status' => $status]);
    }

    /**
     * create user hospital
     * @param
     * array fill constant email and name
     * @return boolean
     *  Return the User model
     */

    public function createUser($fillable)
    {
        return $this->user->query()->create($fillable);
    }

    public function createAdminInfo($fill)
    {
        return $this->createUser([
            'name' => $fill['name'],
            'phone' => $fill['phone'],
            'email' => $fill['email'],
            'role' => User::ROLE_ADMIN,
            'status' => User::ACCOUNT_ACTIVE,
        ]);
    }
}
