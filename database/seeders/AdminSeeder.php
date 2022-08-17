<?php

namespace Database\Seeders;

use App\Models\Cinema;
use App\Models\Province;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        $province = Province::all()->pluck('id')->toArray();

        for ($i = 0; $i < 50; $i++) {
            $admin = User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->email,
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('abc@12345'),
                'role' => User::ROLE_ADMIN,
                'status' => User::ACCOUNT_ACTIVE
            ]);

            $cinema = Cinema::create([
                'user_id' => $admin->id,
                'province_id' => $province[array_rand($province)],
                'name' => "PHC " . $faker->name,
                'address' => $faker->address,
            ]);

            if ($i < 5) {
                UserSeeder::createRoom($cinema);
            }
        }
    }
}
