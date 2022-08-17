<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Cinema;
use App\Models\MemberCard;
use App\Models\Room;
use App\Models\Seat;
use App\Models\ShowTime;
use App\Models\Ticket;
use App\Models\User;
use Carbon\Carbon;
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
        $cinemas = Room::distinct('cinema_id')->pluck('cinema_id')->toArray();

        $faker = \Faker\Factory::create();
        try {
            DB::beginTransaction();

            for ($i = 1; $i < 250; $i++) { // 250 => tương ứng 250 xuất chiếu
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
                    'cinema_id' => $cinemas[array_rand($cinemas)],
                    'total_money' => $faker->randomDigitNotZero() * 10000,
                    'status' => Bill::PAYMENTED,
                    'created_at' => $faker->dateTimeBetween(Carbon::now()->startOfYear(), Carbon::now()),
                ]);

                $roomCurrent = ShowTime::where('id', $i)->first()->room_id;

                for ($j = 0; $j < 15; $j++) { // 1 bill sẽ order 15 ticket
                    $seats = Seat::where('room_id', $roomCurrent)
                        ->whereNotIn('id', Ticket::where('show_time_id', $i)->pluck('seat_id'))
                        ->pluck('id')->toArray();

                    $seatCurrent =  $seats[array_rand($seats)];
                    $priceSeat = Seat::whereId($seatCurrent)->with('seat_type')->first()->seat_type->price;

                    Ticket::create([
                        'bill_id' => $bill->id,
                        'show_time_id' =>  $i,
                        'seat_id' => $seatCurrent,
                        'price' => $priceSeat,
                    ]);
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
        }
    }
}
