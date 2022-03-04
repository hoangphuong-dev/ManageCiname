<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\FormatMovie;
use App\Models\MovieGenre;
use App\Models\Province;
use App\Models\SeatType;
use Illuminate\Database\Seeder;

class BaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataFormat = ([
            ['name' => 'Nomal'],
            ['name' => '2D'],
            ['name' => '3D'],
        ]);
        // FormatMovie::insert($dataFormat);

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

        // Cast::insert($dataCast);

        $movieGenre = ([
            ['name' => 'Hoạt hình',],
            ['name' => 'Bom tấn'],
            ['name' => 'Hành động'],
            ['name' => 'Ca nhạc'],
            ['name' => 'Cổ trang'],
            ['name' => 'Gia đình'],
            ['name' => 'Hài hước'],
        ]);
        // MovieGenre::insert($movieGenre);

        $dataProvince = [
            "Hồ Chí Minh",
            "Hà Nội",
            "Đà Nẵng",
            "Bình Dương",
            "Đồng Nai",
            "Khánh Hòa",
            "Hải Phòng",
            "Long An",
            "Quảng Nam",
            "Bà Rịa Vũng Tàu",
            "Đắk Lắk",
            "Cần Thơ",
            "Bình Thuận  ",
            "Lâm Đồng",
            "Thừa Thiên Huế",
            "Kiên Giang",
            "Bắc Ninh",
            "Quảng Ninh",
            "Thanh Hóa",
            "Nghệ An",
            "Hải Dương",
            "Gia Lai",
            "Bình Phước",
            "Hưng Yên",
            "Bình Định",
            "Tiền Giang",
            "Thái Bình",
            "Bắc Giang",
            "Hòa Bình",
            "An Giang",
            "Vĩnh Phúc",
            "Tây Ninh",
            "Thái Nguyên",
            "Lào Cai",
            "Nam Định",
            "Quảng Ngãi",
            "Bến Tre",
            "Đắk Nông",
            "Cà Mau",
            "Vĩnh Long",
            "Ninh Bình",
            "Phú Thọ",
            "Ninh Thuận",
            "Phú Yên",
            "Hà Nam",
            "Hà Tĩnh",
            "Đồng Tháp",
            "Sóc Trăng",
            "Kon Tum",
            "Quảng Bình",
            "Quảng Trị",
            "Trà Vinh",
            "Hậu Giang",
            "Sơn La",
            "Bạc Liêu",
            "Yên Bái",
            "Tuyên Quang",
            "Điện Biên",
            "Lai Châu",
            "Lạng Sơn",
            "Hà Giang",
            "Bắc Kạn",
            "Cao Bằng"
        ];
        foreach ($dataProvince as $data) {
            Province::insert([
                'name' => $data
            ]);
        }

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
