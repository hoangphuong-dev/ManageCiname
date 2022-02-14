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

    public function createHospital($fill)
    {
        return $this->createUser([
            'email' => $fill['email'],
            'role' => User::ROLE_HOSPITAL,
            'name' => $fill['name'],
            'status' => User::HOSPITAL_STATUS_PENDING
        ]);
    }

    public function makePasswordById($hospitalId)
    {
        $user = $this->user->query()->findOrFail($hospitalId);

        if (!$user->isHospital()) {
            throw new \Exception('Not allow change password');
        }

        $password = Str::random(10);
        $user->password = Hash::make($password);
        $user->status = User::HOSPITAL_STATUS_DONE;
        $user->save();
        return [
            $user,
            $password
        ];
    }

    public function createCaretaker($fill)
    {
        return $this->createUser([
            'role' => User::ROLE_USER,
            'email' => $fill['email'],
            'password' => Hash::make($fill['password']),
        ]);
    }

    public function listCareTaker($request)
    {
        $builder = $this->user->query()
            ->filters(new UserFilters($request))
            ->where('role', User::ROLE_USER);

        return $builder->paginate($request->query('limit', 10));
    }

    public function getCaretaker($userId)
    {
        $user = $this->user->query()->findOrFail($userId);
        $user->load(['userInfo', 'tags']);
        return $user;
    }

    public function getNotificationReceiver($request)
    {
        return $this->user->query()
            ->where('role', '<>', User::ROLE_ADMIN)
            ->select(['id', 'name', 'role'])
            ->when($request->query('name'), function ($query, $name) {
                return $query->where("name", "like", "%{$name}%");
            })->get();
    }
}
