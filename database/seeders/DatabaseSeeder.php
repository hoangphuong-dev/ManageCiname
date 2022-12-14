<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            BaseSeeder::class,
            UserSeeder::class,
            MovieSeeder::class,
            AdminSeeder::class,
            StaffInfoSeeder::class,
            ShowTimeSeeder::class,
            BillSeeder::class,
            CommentMovieSeeder::class
        ]);
    }
}
