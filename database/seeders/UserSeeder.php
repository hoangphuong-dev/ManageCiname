<?php

namespace Database\Seeders;

use App\Models\AdminInfo;
use App\Models\Cinema;
use App\Models\Room;
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
                    'hotline' => "09993549555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 2",
                    'hotline' => "0953459999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 3",
                    'hotline' => "09953599555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 4",
                    'hotline' => "095435999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 5",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
                [
                    'admin_info_id' => $adminInfo,
                    'name' => "Quận 6",
                    'hotline' => "09999999555",
                    'address' => "Quận 1",
                ],
            ]);

            $dataRoom = ([
                [
                    'cinema_id' => 1, // Quận 1 ( HCM)
                    'name' => "Phòng 201",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,

                ],
                [
                    'cinema_id' => 1,
                    'name' => "Phòng 202",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,
                ],
                [
                    'cinema_id' => 1,
                    'name' => "Phòng 203",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,
                ],
                [
                    'cinema_id' => 1,
                    'name' => "Phòng 204",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,
                ],
                [
                    'cinema_id' => 1,
                    'name' => "Phòng 205",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,
                ],
                [
                    'cinema_id' => 1,
                    'name' => "Phòng 206",
                    'status' => Room::STATUS_OPEN,
                    'row_number' => 0,
                    'column_number' => 0,
                ],
            ]);

            Cinema::insert($dataCinema);
            Room::insert($dataRoom);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }
}
