<?php

namespace Database\Seeders;

use App\Models\AdminInfo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataUser = ([
            //SuperAdmin
            [
                'name' => 'SuperAdmin',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_SUPERADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Admin
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_ADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Staff
            [
                'name' => 'Nhân viên',
                'email' => 'staff@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_STAFF,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Customer
            [
                'name' => 'Khách hàng',
                'email' => 'customer@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_CUSTOMER,
                'status' => User::ACCOUNT_ACTIVE
            ],
        ]);
        DB::beginTransaction();
        try {
            User::insert($dataUser);

            $admin = User::where('role', User::ROLE_ADMIN)->firstOrFail();

            $dataAdinInfo = [
                'user_id' => $admin->id,
                'province_id' => 1, // Thành phố Hồ Chí Minh
            ];

            AdminInfo::insert($dataAdinInfo);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }
}
