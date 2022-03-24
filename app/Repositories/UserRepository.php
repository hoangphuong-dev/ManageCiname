<?php

namespace App\Repositories;

use App\Models\Filters\UserFilters;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class UserRepository
{
    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function createCustomer($data)
    {
        $user = $this->findByEmail($data['email']);
        if ($user == null) {
            $user = User::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'role' => User::ROLE_CUSTOMER,
            ]);
        }
        return $user->id;
    }

    public function updateUserById($fill, $user_id)
    {
        return $this->user
            ->where('id', $user_id)
            ->update($fill);
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
            ->paginate($request->query('limit', 12));
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

    public function createAdmin($data)
    {
        return $this->createUser([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => $data['password'],
            'role' => User::ROLE_ADMIN,
            'status' => User::ACCOUNT_DEACTIVE,
        ]);
    }

    public function confirmAdmin($admin_id)
    {
        return $this->user->newQuery()
            ->where('email_verified_at', NULL)
            ->where('id', $admin_id)
            ->update([
                'email_verified_at' => now(),
                'status' => User::ACCOUNT_ACTIVE,
            ]);
    }
}
