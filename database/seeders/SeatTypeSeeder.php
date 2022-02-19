<?php

namespace Database\Seeders;

use App\Models\SeatType;
use Illuminate\Database\Seeder;

class SeatTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataSeatType = ([
            [
                'name' => ' Ghế Thường',
                'image' => 'http://127.0.0.1/dashboard/admin/cinemas/show/1',
                'price' => '100000',
            ],
            [
                'name' => 'Ghế Vip',
                'image' => 'http://127.0.0.1/dashboard/admin/cinemas/show/1',
                'price' => '100000',
            ],
            [
                'name' => 'Ghế Đôi',
                'image' => 'http://127.0.0.1/dashboard/admin/cinemas/show/1',
                'price' => '100000',
            ],
        ]);

        SeatType::insert($dataSeatType);
    }
}
