<?php

namespace App\Repositories;

use App\Models\Filters\UserFilters;
use App\Models\MemberCard;
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

            MemberCard::create([
                'number_card' => rand(),
                'user_id' => $user->id
            ]);
        }
        return $user;
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


    public function updateStatus($id, $status)
    {
        return $this->user->find($id)->update(['status' => $status]);
    }


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
