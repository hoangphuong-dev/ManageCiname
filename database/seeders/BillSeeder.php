<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\Province;
use App\Models\Room;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cinema = Cinema::all()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();

        for ($i = 1; $i < 50; $i++) {
            $user = User::create([
                'name' => $faker->name,
                'email' => $faker->email,
                'phone' => $faker->phoneNumber,
                'role' => User::ROLE_CUSTOMER,
                'status' => User::ACCOUNT_ACTIVE
            ]);

            $bill = Bill::create([
                'user_id' => $user->id,
                'cinema_id' => $cinema[array_rand($cinema)],
                'total_money' => $faker->randomDigitNotZero() * 10000,
            ]);

            $showtime = ShowTime::all()->pluck('id')->toArray();

            $showtime_current = $showtime[array_rand($showtime)];

            $room_of_current = ShowTime::where('id', $showtime_current)->first()->room_id;

            $ticket = Ticket::where('showtime_id', $showtime_current)->pluck('seat_id');

            // for ($j = 0; $j < 2; $j++) {
            $seat = Seat::all()
                ->where('room_id', $room_of_current)
                ->whereNotIn('seat_id', $ticket)
                ->pluck('id')->toArray();
            Ticket::create([
                'bill_id' => $bill->id,
                'showtime_id' => $showtime_current,
                'seat_id' => $seat[array_rand($seat)],
            ]);
            // }
        }
    }
}
