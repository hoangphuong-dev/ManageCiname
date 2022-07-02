<?php

namespace App\Repositories;

use App\Models\Filters\UserFilters;
use App\Models\Filters\UserInfoFilters;
use App\Models\MemberCard;
use App\Models\StaffInfo;
use App\Models\User;
use JasonGuru\LaravelMakeRepository\Repository\BaseRepository;

class UserRepository extends BaseRepository
{
    /**
     * @return string
     *  Return the model
     */
    public function model()
    {
        return User::class;
    }

    public function getStaffOfAdmin($request, $cinemaId)
    {
        $staff = StaffInfo::query()
            ->with(['user'])
            ->where('cinema_id', $cinemaId)
            ->filters(new UserInfoFilters($request))
            ->orderBy('id', "DESC")
            ->paginate($request->query('limit', 12));

        return $staff;
    }

    public function createStaff($data)
    {
        return $this->createUser($data, User::ROLE_STAFF);
    }

    public function createCustomer($data)
    {
        $user = $this->findByEmail($data['email']);
        if (is_null($user)) {
            $user = $this->createUser($data, User::ROLE_CUSTOMER);
            MemberCard::create([
                'number_card' => rand(),
                'user_id' => $user->id
            ]);
        }
        return $user;
    }

    public function createUser($data, $role)
    {
        return $this->model->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'role' => $role,
        ]);
    }

    public function createStaffInfo($data, $staff_id)
    {
        return StaffInfo::create([
            'user_id' =>  $staff_id,
            'cinema_id' => $data['cinema_id'],
        ]);
    }

    public function updateUserById($fill, $user_id)
    {
        return $this->model
            ->where('id', $user_id)
            ->update($fill);
    }

    public function findByEmail($email)
    {
        return $this->model->query()->where('email', $email)->first();
    }

    public function findByToken($token)
    {
        return $this->model->query()->where('token_life_time', $token)->first();
    }


    public function updateStatus($id, $status)
    {
        return $this->model->find($id)->update(['status' => $status]);
    }

    public function createAdmin($data)
    {
        return $this->model->query()->create([
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
        return $this->model->newQuery()
            ->where('email_verified_at', NULL)
            ->where('id', $admin_id)
            ->update([
                'email_verified_at' => now(),
                'status' => User::ACCOUNT_ACTIVE,
            ]);
    }
}
