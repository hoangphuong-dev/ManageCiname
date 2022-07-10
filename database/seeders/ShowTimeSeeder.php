<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Room;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ShowTimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movie = Movie::query()->where('status', Movie::MOVIE_ACTIVE)->orderBy('id', 'DESC')->limit(4)->pluck('id')->toArray();
        $room = Room::all()->where('status', Room::STATUS_OPEN)->pluck('id')->toArray();

        for ($i = 1; $i <= 500; $i += 2) {
            ShowTime::create([
                'movie_id' =>  $movie[array_rand($movie)],
                'room_id' => $room[array_rand($room)],
                'time_start' => Carbon::now()->addHour($i),
                'time_end' => Carbon::now()->addHour($i + 2)
            ]);
        }
    }
}
