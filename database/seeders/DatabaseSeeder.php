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
            ShowTimeSeeder::class,
            BillSeeder::class
        ]);
    }
}
