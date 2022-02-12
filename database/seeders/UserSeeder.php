<?php

namespace Database\Seeders;

use App\Models\AdminInfo;
use App\Models\Cinema;
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

            $adminInfo = AdminInfo::insert($dataAdinInfo);

            $dataCinema = ([
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 1",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 1",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 2",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 3",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 4",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 5",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
            ]);

            Cinema::insert($dataCinema);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }
}
