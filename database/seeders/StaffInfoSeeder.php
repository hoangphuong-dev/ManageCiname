<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\StaffInfo;
use App\Models\User;
use Illuminate\Database\Seeder;

class StaffInfoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $cinemaId = Cinema::query()->get()->pluck('id')->toArray();

        for ($i = 0; $i < 2000; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'role' => User::ROLE_STAFF,
                'status' => User::ACCOUNT_ACTIVE
            ]);

            StaffInfo::create([
                'user_id' => $user->id,
                'cinema_id' => $cinemaId[array_rand($cinemaId)],
                'type_of_work' => random_int(1, 2),
                'status' => random_int(1, 3),
            ]);
        }
    }
}
