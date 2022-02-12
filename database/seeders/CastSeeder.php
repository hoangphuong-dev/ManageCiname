<?php

namespace Database\Seeders;

use App\Models\Cast;
use Illuminate\Database\Seeder;

class CastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataCast = ([
            ['name' => 'Trấn Thành'],
            ['name' => 'Công Lý'],
            ['name' => 'Trường Giang'],
            ['name' => 'Hoài Linh'],
            ['name' => 'Thanh Mai'],
            ['name' => 'Trúc Mã'],
            ['name' => 'Hồng Vân'],
            ['name' => 'Hồng Đăng'],
            ['name' => 'Ngọc Thảo'],
            ['name' => 'Thúy Kiều'],
            ['name' => 'Thúy Vân'],
            ['name' => 'Hồng Đam'],
            ['name' => 'Ngọc Hiền'],
            ['name' => 'Đàm Vĩnh Hưng'],
        ]);

        Cast::insert($dataCast);
    }
}
