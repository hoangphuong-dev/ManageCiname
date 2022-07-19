<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\MemberCard;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        try {
            DB::beginTransaction();

            for ($i = 1; $i < 1000; $i++) {
                $user = User::create([
                    'name' => $faker->name,
                    'email' => $faker->unique()->safeEmail,
                    'phone' => $faker->phoneNumber,
                    'role' => User::ROLE_CUSTOMER,
                    'status' => User::ACCOUNT_ACTIVE
                ]);

                MemberCard::create([
                    'number_card' => rand(),
                    'user_id' => $user->id,
                    'role' => MemberCard::ROLE_NOMAL,
                ]);


                $bill = Bill::create([
                    'user_id' => $user->id,
                    'cinema_id' => $cinema[array_rand($cinema)],
                    'total_money' => $faker->randomDigitNotZero() * 10000,
                ]);

                $showtime = ShowTime::all()->pluck('id')->toArray();

                $showtime_current = $showtime[array_rand($showtime)];

                $room_of_current = ShowTime::where('id', $showtime_current)->first()->room_id;

                $ticket = Ticket::where('show_time_id', $showtime_current)->pluck('seat_id');

                $seat = Seat::where('room_id', $room_of_current)
                    ->whereNotIn('id', $ticket)
                    ->pluck('id')->toArray();

                Ticket::create([
                    'bill_id' => $bill->id,
                    'show_time_id' => $showtime_current,
                    'seat_id' => $seat[array_rand($seat)],
                ]);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }
    }
}
