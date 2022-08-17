<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Room;
use App\Models\Seat;
use App\Models\SeatType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use phpDocumentor\Reflection\Types\Array_;

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
                'phone' => '0968222320',
                'email' => 'superadmin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_SUPERADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            //Admin
            [
                'name' => 'Admin',
                'phone' => '0968385320',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_ADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ],
            [
                'name' => 'Nhân viên',
                'email' => 'staff@gmail.com',
                'phone' => '0968444320',
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_STAFF,
                'status' => User::ACCOUNT_ACTIVE
            ],
        ]);
        $faker = \Faker\Factory::create();

        DB::beginTransaction();

        try {
            User::insert($dataUser);

            $admin = User::where('role', User::ROLE_ADMIN)->firstOrFail();

            $cinema = Cinema::create([
                'user_id' => $admin->id,
                'province_id' => 1,
                'name' => "PHC Thanh Nhàn",
                'address' => $faker->address,
            ]);

            self::createRoom($cinema);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }

    public static function createRoom(Cinema $cinema)
    {
        try {
            DB::beginTransaction();

            $seat_type = SeatType::all()->pluck('id')->toArray();
            for ($i = 1; $i < 4; $i++) {
                Room::create([
                    'cinema_id' => $cinema->id,
                    'name' => "Phòng 10" . $i,
                    'status' => Room::STATUS_OPEN,
                    'format_movie_id' => 1,
                    'row_number' => 10,
                    'column_number' => 10,
                ]);
            }

            foreach (Room::get('id') as $room) {
                for ($i = 1; $i <= 10; $i++) {
                    for ($j = 1; $j <= 10; $j++) {
                        Seat::create([
                            'room_id' => $room->id,
                            'seat_type_id' => $seat_type[array_rand($seat_type)],
                            'row_name' => chr($i + 64),
                            'columns_number' => $j,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
