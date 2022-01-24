<?php

namespace Database\Seeders;

use App\Models\MovieGenre;
use Illuminate\Database\Seeder;

class MovieGenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $movieGenre = ([
            [
                'name' => 'Hoạt hình',
                'price' => '100000',
            ],
            [
                'name' => 'Bom tấn',
                'price' => '120000',
            ],
            [
                'name' => 'Hành động',
                'price' => '160000',
            ],
            [
                'name' => 'Ca nhạc',
                'price' => '150000',
            ],
            [
                'name' => 'Cổ trang',
                'price' => '150000',
            ],
            [
                'name' => 'Gia đình',
                'price' => '150000',
            ],
            [
                'name' => 'Hài hước',
                'price' => '150000',
            ],
        ]);

        MovieGenre::insert($movieGenre);

    }
}
