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
                'phone' => '0968 222 320',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_SUPERADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Admin
            [
                'name' => 'Admin',
                'phone' => '0968 385 320',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_ADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Staff
            [
                'name' => 'Nhân viên',
                'email' => 'staff@gmail.com',
                'phone' => '0968 444 320',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_STAFF,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Customer
            [
                'name' => 'Khách hàng',
                'email' => 'customer@gmail.com',
                'phone' => '0968 385 323',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_CUSTOMER,
                'status' => User::ACCOUNT_ACTIVE
            ],
        ]);



        DB::beginTransaction();
        try {
            User::insert($dataUser);
            $admin = User::where('role', User::ROLE_ADMIN)->firstOrFail();

            $faker = \Faker\Factory::create();
            for ($i = 1; $i < 11; $i++) {
                Cinema::create([
                    'user_id' => $admin->id,
                    'province_id' => 1, // Thành phố Hồ Chí Minh
                    'name' => "Quận " . $i,
                    'address' => $faker->address,
                ]);
                Room::create([
                    'cinema_id' => 1, // Quận 1 ( HCM)
                    'name' => "Phòng 2" . $i,
                    'status' => Room::STATUS_OPEN,
                    'format_movie_id' => 1,
                    'row_number' => 0,
                    'column_number' => 0,
                ]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }
}
