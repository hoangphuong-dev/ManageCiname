<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;

class ProvinceSedeer extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
