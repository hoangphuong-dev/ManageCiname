<?php

namespace Database\Seeders;

use App\Models\CommentMovie;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Seeder;

class CommentMovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movie_id = Movie::get()->pluck('id')->toArray();
        $user_id = User::where('role', User::ROLE_CUSTOMER)->get()->pluck('id')->toArray();

        $faker = \Faker\Factory::create();

        // each movie each comment  
        foreach ($movie_id as $key) {
            CommentMovie::create([
                'movie_id' => $key,
                'user_id' => $user_id[array_rand($user_id)],
                'parent_id' => CommentMovie::MASTER_COMMENT,
                'content' => $faker->paragraph,
            ]);
        }
        //comment level 2 
        $parent_id = CommentMovie::get()->pluck('id')->toArray();

        foreach ($parent_id as $key) {
            $movie_id = CommentMovie::select('movie_id')->where('id', $key)->first()->toArray();
            CommentMovie::create([
                'movie_id' => $movie_id['movie_id'],
                'user_id' => $user_id[array_rand($user_id)],
                'parent_id' => $key,
                'content' => $faker->paragraph,
            ]);
        }
    }
}
