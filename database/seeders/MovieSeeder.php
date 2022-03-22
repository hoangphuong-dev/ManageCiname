<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\CastMovie;
use App\Models\Cinema;
use App\Models\CinemaMovie;
use App\Models\FormatMovie;
use App\Models\Movie;
use App\Models\MovieFormatMovie;
use App\Models\MovieGenre;
use App\Models\MovieGenreMovie;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dataUrlYoutube = [
            'https://www.youtube.com/watch?v=cD9HfSmiJDA',
            'https://www.youtube.com/watch?v=rdtLBPVJ1PM',
            'https://www.youtube.com/watch?v=ZWJaEF8B03I',
            'https://www.youtube.com/watch?v=apMUfr_uqwg',
            'https://www.youtube.com/watch?v=uax3sR17GQQ',
            'https://www.youtube.com/watch?v=HtnWmdup8KQ',
            'https://www.youtube.com/watch?v=j4qlDEzr73I',
            'https://www.youtube.com/watch?v=wHuFuxsQ_Vw',
            'https://www.youtube.com/watch?v=q3GTCsRLzhA',
            'https://www.youtube.com/watch?v=mBqS1Fj_lNo',
            'https://www.youtube.com/watch?v=Bp9s8WNmP20',
            'https://www.youtube.com/watch?v=uyxiITdUsdY',
            'https://www.youtube.com/watch?v=VAbzuIqX9f8',
            'https://www.youtube.com/watch?v=T8YgfQ5hWBc',
            'https://www.youtube.com/watch?v=8Lc04ry_hB0',
            'https://www.youtube.com/watch?v=dNhojMSgS0Y',
            'https://www.youtube.com/watch?v=Hakd3BKnXuo',
            'https://www.youtube.com/watch?v=Vran9iR20_E',
            'https://www.youtube.com/watch?v=0t8FomXzakE',
        ];

        $data_description = '<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Điện thoại iPhone 13&nbsp;phi&ecirc;n bản Pro Max chắc chắn sẽ l&agrave; chiếc smartphone cao cấp được quan t&acirc;m nhiều nhất trong năm 2021. D&ograve;ng&nbsp;<a style="box-sizing: border-box; margin: 0px; padding: 0px; background-color: transparent; color: #d70018; text-decoration-line: none;" href="https://cellphones.com.vn/mobile/apple/iphone-13.html">iPhone 13 series</a>&nbsp;vừa được ra mắt v&agrave;o th&aacute;ng 9 năm nay với 4 phi&ecirc;n bản: iPhone 13, 13 mini, 13 Pro v&agrave; 13 Pro Max.</p>
<h2 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-family: sans-serif; line-height: 1.2; color: #0a263c; font-size: 21px; background-color: #ffffff; text-align: justify;"><strong style="box-sizing: border-box; margin: 0px; padding: 0px;">Đ&aacute;nh gi&aacute; iPhone 13 Pro Max &ndash; Hiệu năng v&ocirc; đối, camera cực đỉnh</strong></h2>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">iPhone 12 ra mắt cách đ&acirc;y chưa l&acirc;u, thì những tin đ&ocirc;̀n mới nh&acirc;́t v&ecirc;̀&nbsp;<strong style="box-sizing: border-box; margin: 0px; padding: 0px;">iPhone 13 Pro Max</strong>&nbsp;đã khi&ecirc;́n bao tín đ&ocirc;̀ c&ocirc;ng ngh&ecirc;̣ ngóng chờ. Cụm camera được n&acirc;ng c&acirc;́p, m&agrave;u sắc mới, đặc biệt l&agrave; m&agrave;n h&igrave;nh 120Hz với phần notch được l&agrave;m nhỏ gọn hơn chính là những đi&ecirc;̉m làm cho&nbsp;thu hút mọi sự chú ý trong năm nay.</p>
<h3 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-family: sans-serif; font-weight: 500; line-height: 1.2; color: #0a263c; font-size: 1.75rem; background-color: #ffffff; text-align: justify;"><strong style="box-sizing: border-box; margin: 0px; padding: 0px;">Thi&ecirc;́t k&ecirc;́ cạnh phẳng sang trọng, nhiều màu sắc n&ocirc;̉i b&acirc;̣t</strong></h3>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Dòng iPhone 12 được Apple áp dụng ng&ocirc;n ngữ thi&ecirc;́t k&ecirc;́ tương tự iPhone 12 năm ngo&aacute;i với ph&acirc;̀n cạnh vi&ecirc;̀n máy được dát phẳng sang trọng c&ugrave;ng bốn g&oacute;c được l&agrave;m bo cong nhẹ, đ&acirc;y c&oacute; thể được xem l&agrave; một thiết kế ho&agrave;i cổ từ d&ograve;ng iPhone 5 trước đ&oacute;. Vì th&ecirc;́ mà iPhone 13 Pro Max nói ri&ecirc;ng, cũng như dòng&nbsp;<a style="box-sizing: border-box; margin: 0px; padding: 0px; background-color: transparent; color: #d70018; text-decoration-line: none;" href="https://cellphones.com.vn/iphone-13.html">điện thoại iPhone 13</a>&nbsp;nói chung, cũng sẽ đi theo ng&ocirc;n ngữ thi&ecirc;́t k&ecirc;́ này.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Đi&ecirc;̉m thay đ&ocirc;̉i lớn tr&ecirc;n 13 Pro Max có th&ecirc;̉ là ph&acirc;̀n nh&ocirc; của cụm camera. Trong khi đ&oacute; mặt trước của thiết bị được phủ một lớp Ceramic Shield, loại vật liệu cứng hơn bất kỳ loại k&iacute;nh điện thoại th&ocirc;ng minh n&agrave;o hiện c&oacute; tr&ecirc;n thị trường, gi&uacute;p bảo vệ m&agrave;n h&igrave;nh iPhone hiệu quả.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;"><img class="cpslazy loaded" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; vertical-align: top; opacity: 1; transition: opacity 0.3s ease 0s;" src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-1.jpg" alt="Thi&ecirc;́t k&ecirc;́ cạnh phẳng sang trọng, nhiều màu sắc n&ocirc;̉i b&acirc;̣t" data-src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-1.jpg" data-ll-status="loaded" /></p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Xét v&ecirc;̀ ch&acirc;́t li&ecirc;̣u, iPhone 13 Pro Max v&acirc;̃n áp dụng ch&acirc;́t li&ecirc;̣u thép kh&ocirc;ng gỉ như thế hệ trước đ&oacute;. Mặt n&agrave;y cũng được phủ một lớp k&iacute;nh mờ gi&uacute;p hạn chế b&aacute;m bụi bẩn v&agrave; v&acirc;n tay. Ngoài ra, điện thoại cũng sẽ đảm bảo được khả năng ch&ocirc;́ng bụi / nước chu&acirc;̉n IP68.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Về m&agrave;u sắc, iPhone 13 phi&ecirc;n bản Pro Max sẽ được ra mắt với nhi&ecirc;̀u t&ugrave;y chọn màu sắc khác nhau. Trong đ&oacute; gồm một số m&agrave;u nổi bật như: v&agrave;ng, bạc, xanh, đen,...</p>
<h3 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-family: sans-serif; font-weight: 500; line-height: 1.2; color: #0a263c; font-size: 1.75rem; background-color: #ffffff; text-align: justify;"><strong style="box-sizing: border-box; margin: 0px; padding: 0px;">M&agrave;n h&igrave;nh với tai nhỏ nhỏ hơn, t&ocirc;́c đ&ocirc;̣ làm tươi 120 Hz</strong></h3>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">M&ocirc;̣t trong những y&ecirc;́u t&ocirc;́ khi&ecirc;́n iPhone 13 Pro Max đáng mong chờ đó là thi&ecirc;́t k&ecirc;́ notch "tai thỏ" được thu gọn lại. Ngoài kích cỡ màn hình 6.7 inch với t&acirc;́m n&ecirc;̀n Super Retina XDR OLED, m&aacute;y sẽ có thi&ecirc;́t k&ecirc;́ notch được thu hẹp lại, giúp tăng tỷ l&ecirc;̣ hi&ecirc;̉n thị tr&ecirc;n màn hình đi&ecirc;̣n thoại. T&acirc;́t nhi&ecirc;n, những cảm bi&ecirc;́n quan trọng như TrueDepth, Face ID hoặc camera selfie đ&ecirc;̀u sẽ giữ nguy&ecirc;n vị trí.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;"><img class="cpslazy loaded" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; vertical-align: top; opacity: 1; transition: opacity 0.3s ease 0s;" src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-2.jpg" alt="Màn hình notch thu nhỏ với t&ocirc;́c đ&ocirc;̣ làm tươi 120 Hz" data-src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-2.jpg" data-ll-status="loaded" /></p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">R&acirc;́t nhi&ecirc;̀u ngu&ocirc;̀n tin cho bi&ecirc;́t iPhone 13 Pro Max sẽ tăng cường trải nghi&ecirc;̣m hình ảnh l&ecirc;n r&acirc;́t nhi&ecirc;̀u th&ocirc;ng qua ProMotion - tích năng giúp đ&acirc;̉y t&ocirc;́c đ&ocirc;̣ làm tươi màn ảnh l&ecirc;n 120 Hz. Đ&acirc;y cũng là chi&ecirc;́c iPhone đ&acirc;̀u ti&ecirc;n có t&ocirc;́c đ&ocirc;̣ làm tươi cao l&ecirc;n đến 120Hz, giúp hình ảnh chuy&ecirc;̉n đ&ocirc;̣ng mượt mà hơn.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Ngoài ra, những tính năng b&ocirc;̉ trợ khác như Dolby Vision, True-tone hoặc gam màu r&ocirc;̣ng chu&acirc;̉n HDR10 v&acirc;̃n sẽ được tích hợp vào iPhone 13 Pro Max.&nbsp;&nbsp;</p>
<h3 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-family: sans-serif; font-weight: 500; line-height: 1.2; color: #0a263c; font-size: 1.75rem; background-color: #ffffff; text-align: justify;"><strong style="box-sizing: border-box; margin: 0px; padding: 0px;">Camera n&acirc;ng c&acirc;́p, chụp ảnh chất lượng, quay phim chuy&ecirc;n nghiệp</strong></h3>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Như mọi chi&ecirc;́c iPhone mới khác, camera lu&ocirc;n là y&ecirc;́u t&ocirc;́ được người dùng quan t&acirc;m nh&acirc;́t, và iPhone 13 Pro Max sẽ kh&ocirc;ng làm người dùng th&acirc;́t vọng.&nbsp;Gi&ocirc;́ng với ng&ocirc;n ngữ thi&ecirc;́t k&ecirc;́ cho th&acirc;n máy, ng&ocirc;n ngữ thi&ecirc;́t k&ecirc;́ cho camera thường kh&ocirc;ng xảy ra trong thời gian ngắn. Đó là lý do chiếc điện thoại n&agrave;y v&acirc;̃n sẽ có b&ocirc;̣ camera 3 &ocirc;́ng kính x&ecirc;́p xen kẽ thành m&ocirc;̣t cụm vu&ocirc;ng, đặt ở góc tr&ecirc;n b&ecirc;n trái của lưng máy.&nbsp;&nbsp;</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Thay đ&ocirc;̉i lớn v&ecirc;̀ camera đ&acirc;̀u ti&ecirc;n nằm ở cảm bi&ecirc;́n. M&aacute;y được trang bị camera góc si&ecirc;u r&ocirc;̣ng cải ti&ecirc;́n lớn với &ocirc;́ng kính kh&acirc;̉u đ&ocirc;̣ f/1.8 và len 6P. Camera si&ecirc;u r&ocirc;̣ng hi&ecirc;̣n tại tr&ecirc;n iPhone 12 Pro Max đang ở kh&acirc;̉u đ&ocirc;̣ f/2.4 và len 5P, n&ecirc;n n&acirc;ng c&acirc;́p tr&ecirc;n sẽ cải thi&ecirc;̣n ảnh chụp thi&ecirc;́u sáng r&acirc;́t nhi&ecirc;̀u.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Cảm bi&ecirc;́n LiDAR v&acirc;̃n sẽ hi&ecirc;̣n di&ecirc;̣n tr&ecirc;n iPhone 13 Pro Max. Tuy nhi&ecirc;n Apple dự ki&ecirc;́n mang cảm bi&ecirc;́n này l&ecirc;n cả gia đình iPhone 13 và kh&ocirc;ng dành ri&ecirc;ng chỉ cho các máy Pro. Đi&ecirc;̀u này được cho là nhằm mang đ&ecirc;́n trải nghi&ecirc;̣m thực t&ecirc;́ tăng cường (AR) t&ocirc;́t nh&acirc;́t cho t&acirc;́t cả người dùng.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;"><img class="cpslazy loaded" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; vertical-align: top; opacity: 1; transition: opacity 0.3s ease 0s;" src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-3.jpg" alt="Camera n&acirc;ng c&acirc;́p đáng k&ecirc;̉ v&ecirc;̀ cảm bi&ecirc;́n l&acirc;̃n tính năng chụp ảnh" data-src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-3.jpg" data-ll-status="loaded" /></p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Camera selfie kh&ocirc;ng thay đ&ocirc;̉i so với model ti&ecirc;̀n nhi&ecirc;̣m. Có th&ecirc;̉ iPhone 13 Pro Max sẽ chụp ảnh selfie góc r&ocirc;̣ng hơn m&ocirc;̣t chút, nhưng còn lại ph&acirc;̀n lớn ở camera selfie đ&ecirc;̀u giữ nguy&ecirc;n như trước. Và những tính năng như selfie slow-mo, memoji và animoji cũng sẽ hi&ecirc;̣n di&ecirc;̣n như nhi&ecirc;̀u tin đ&ocirc;̀n cho bi&ecirc;́t.</p>
<h3 style="box-sizing: border-box; margin: 0px 0px 0.5rem; padding: 0px; font-family: sans-serif; font-weight: 500; line-height: 1.2; color: #0a263c; font-size: 1.75rem; background-color: #ffffff; text-align: justify;"><strong style="box-sizing: border-box; margin: 0px; padding: 0px;">Vi xử lý n&acirc;ng c&acirc;́p, dung lượng pin cải thiện</strong></h3>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Gi&ocirc;́ng với nhi&ecirc;̀u th&ecirc;́ h&ecirc;̣ iPhone mới, vi xử lý dự đoán sẽ được n&acirc;ng c&acirc;́p l&ecirc;n m&ocirc;̣t b&acirc;̣c với hi&ecirc;̣u năng cải thi&ecirc;̣n đáng k&ecirc;̉ cùng khả năng h&ocirc;̃ trợ mạng 5G. Trong trường hợp này, iPhone 13 Pro Max sẽ mang trong mình chip Apple A15 Bionic với nhi&ecirc;̀u n&acirc;ng c&acirc;́p khác nhau, cả v&ecirc;̀ hi&ecirc;̣u năng xử lý l&acirc;̃n k&ecirc;́t n&ocirc;́i internet t&ocirc;́c đ&ocirc;̣ cao.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">Theo nh&agrave; sản xuất c&ocirc;ng bố, chip A15 thế hệ mới n&agrave;y cho hiệu năng đồ họa nhanh hơn tới 50% so với c&aacute;c thiết bị smartphone kh&aacute;c. Ngo&agrave;i ra, khả năng kết nối 5G cũng được cải thiện đ&aacute;ng kể, c&ugrave;ng với đ&oacute; l&agrave; chế độ dữ liệu th&ocirc;ng minh, giảm tốc độ khi kh&ocirc;ng cần thiết để tiết kiệm điện năng.</p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;"><img class="cpslazy loaded" style="box-sizing: border-box; margin: 0px; padding: 0px; border: 0px; vertical-align: top; opacity: 1; transition: opacity 0.3s ease 0s;" src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-4.jpg" alt="Vi xử lý n&acirc;ng c&acirc;́p hi&ecirc;̣u năng, loại bỏ hoàn toàn c&ocirc;̉ng k&ecirc;́t n&ocirc;́i" data-src="https://cdn.cellphones.com.vn/media/wysiwyg/mobile/apple/IPHONE-13-PRO-MAX-4.jpg" data-ll-status="loaded" /></p>
<p style="box-sizing: border-box; margin: 0px 0px 10px; padding: 0px; font-size: 15px; line-height: 1.5; color: #444444; font-family: sans-serif; background-color: #ffffff; text-align: justify;">iPhone 13 Pro Max cũng được trang bị vi&ecirc;n pin dung lượng lớn hơn, cho thời gian sử dụng tăng l&ecirc;n khoảng 2,5 giờ so với thế hệ trước đ&oacute;. M&aacute;y cũng sẽ được trang bị c&ocirc;ng nghệ sạc nhanh v&agrave; sạc nhanh kh&ocirc;ng d&acirc;y.</p>';

        $faker = \Faker\Factory::create();
        $casts_id = Cast::all()->pluck('id')->toArray();
        $movie_genre = MovieGenre::all()->pluck('id')->toArray();
        $format = FormatMovie::all()->pluck('id')->toArray();

        try {
            DB::beginTransaction();
            for ($i = 0; $i < 200; $i++) {
                $movie = Movie::create([
                    'name' => $faker->name,
                    'director' => $faker->name,
                    'description' => $data_description,
                    'trailler' =>  $dataUrlYoutube[array_rand($dataUrlYoutube)],
                    'movie_length' => 120,
                    'rated' => array_rand([3, 21]),
                    'status' => array_rand([0, 1]),
                ]);
                $movie_id = $movie->id;

                for ($j = 0; $j < 2; $j++) {
                    CastMovie::create([
                        'cast_id' => $casts_id[array_rand($casts_id)],
                        'movie_id' => $movie_id,
                    ]);

                    MovieGenreMovie::create([
                        'movie_genre_id' => $movie_genre[array_rand($movie_genre)],
                        'movie_id' => $movie_id,
                    ]);

                    MovieFormatMovie::create([
                        'format_movie_id' => $format[array_rand($format)],
                        'movie_id' => $movie_id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return dd($e);
        }

        $arr_movie_id = Movie::where('status', Movie::MOVIE_ACTIVE)
            ->limit(10)->get()
            ->pluck('id')->toArray();

        $arr_cinema_id = Cinema::all()->pluck('id')->toArray();

        foreach ($arr_movie_id as $key) {
            foreach ($arr_cinema_id as $item) {
                CinemaMovie::create([
                    'cinema_id' => $item,
                    'movie_id' => $key,
                ]);
            }
        }
    }
}
