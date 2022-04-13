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
        $current = Carbon::now();
        $movie = Movie::all()->where('status', Movie::MOVIE_ACTIVE)->pluck('id')->toArray();
        $room = Room::all()->where('status', Room::STATUS_OPEN)->pluck('id')->toArray();

        for ($i = 1; $i < 15; $i++) {
            ShowTime::create([
                'movie_id' =>  $movie[array_rand($movie)],
                'room_id' => $room[array_rand($room)],
                'time_start' => $current->addMinute(60 * $i),
                'time_end' => $current->addMinute((60 * $i) + 120),
            ]);
        }
    }
}
