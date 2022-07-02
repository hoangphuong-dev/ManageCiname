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
            'https://www.youtube.com/watch?v=J4naIvc1ubo',
            'https://www.youtube.com/watch?v=xBqGW45b8Sc',
            'https://www.youtube.com/watch?v=pCnp8GBUyl8',
            'https://www.youtube.com/watch?v=wf03ZAGelrA',
            'https://www.youtube.com/watch?v=KvsgzbR78eI',
            'https://www.youtube.com/watch?v=X5_76r3RvFM',
            'https://www.youtube.com/watch?v=hpR6Lxwx5Po',
            'https://www.youtube.com/watch?v=0P0j9viHHl4',
            'https://www.youtube.com/watch?v=ZrCuQFN5ITc',
            'https://www.youtube.com/watch?v=i_bsMOp9C84',
            'https://www.youtube.com/watch?v=xMjq8KvYZ00',
            'https://www.youtube.com/watch?v=R5aLRIu3Sxs',
            'https://www.youtube.com/watch?v=RSwgdGr_sAw',
            'https://www.youtube.com/watch?v=dbz3hIK4SnQ',
            'https://www.youtube.com/watch?v=83QfZfNwiiw',
            'https://www.youtube.com/watch?v=RO4T1jsnWDg',
            'https://www.youtube.com/watch?v=pGp3NQmyW9g',
            'https://www.youtube.com/watch?v=aZ_ujjtnstw',
            'https://www.youtube.com/watch?v=gnJKhjMr5cY',
            'https://www.youtube.com/watch?v=iBAO2cfZebk',
            'https://www.youtube.com/watch?v=5IafY9dMiFQ',
            'https://www.youtube.com/watch?v=1nl5YuXuV0c',
            'https://www.youtube.com/watch?v=yE2wDnmO8D4',
            'https://www.youtube.com/watch?v=nqHHAacbUDY',
            'https://www.youtube.com/watch?v=nqHHAacbUDY',
            'https://www.youtube.com/watch?v=N4QdGNHcp5s',
            'https://www.youtube.com/watch?v=7SAeAAiNCE8',
            'https://www.youtube.com/watch?v=py7rym1w3AU',
            'https://www.youtube.com/watch?v=TZC8UXr70ec',
            'https://www.youtube.com/watch?v=MmRGSpEsLyM',
            'https://www.youtube.com/watch?v=6QqQZnlL4UM',
            'https://www.youtube.com/watch?v=5IafY9dMiFQ',
            'https://www.youtube.com/watch?v=1nl5YuXuV0c',
            'https://www.youtube.com/watch?v=5DM87pwmxHU',
            'https://www.youtube.com/watch?v=sJy0OBnJ0Ac',
            'https://www.youtube.com/watch?v=5cUeHy8sPm8',
            'https://www.youtube.com/watch?v=3nkw2UeemcI',
        ];

        $data_description =
            '<p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;"><span style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-weight: 600;">Kịch bản Bố Gi&agrave;</span>&nbsp;được chắp b&uacute;t bởi ch&iacute;nh&nbsp;<span style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-weight: 600;">Trấn Th&agrave;nh, đạo diễn bởi Vũ Ngọc Đ&atilde;ng</span>. Phim mang ti&ecirc;u ch&iacute; ho&agrave;n to&agrave;n kh&aacute;c kh&ocirc;ng đặt nặng vấn đề cơm &aacute;o gạo tiền như webdrama trước đ&oacute; m&agrave; tập trung v&agrave;o những c&acirc;u chuyện gia đ&igrave;nh của Ba Sang - Quắn - B&ugrave; Tọt.</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150001-637511580015634364.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Poster ch&iacute;nh thức của Bố Gi&agrave;</em></p>
            <h2 id="mau-sac-hinh-anh" class="ckemm_title_spy" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-size: 1.75rem; margin: 3rem 0px 1rem; scroll-margin-top: 90px; overflow-wrap: break-word; line-height: 2rem; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; letter-spacing: -0.45px; background-color: #ffffff;">M&agrave;u sắc v&agrave; h&igrave;nh ảnh</h2>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Nhẹ nh&agrave;ng v&agrave; ấm &aacute;p đ&oacute; l&agrave; những cảm quan m&agrave; Bố Gi&agrave; đem lại cho người xem xuy&ecirc;n suốt bộ phim. B&ecirc;n cạnh đ&oacute; x&oacute;m ngh&egrave;o quanh năm ngập nước c&ugrave;ng m&oacute;n cơm sườn cũng l&agrave; đặc trưng của S&agrave;i G&ograve;n thu nhỏ, những c&aacute;nh cửa cũ m&egrave;m c&ugrave;ng h&agrave;ng x&oacute;m lu&ocirc;n lu&ocirc;n ngồi trước cửa l&agrave; điểm nhấn kh&oacute; phai mỗi khi bước v&agrave;o con hẻm n&agrave;o đ&oacute;.&nbsp;&nbsp;</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150036-637511580365322410.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Ba Sang trong Bố Gi&agrave; với t&ocirc;ng m&agrave;u ấm n&oacute;ng.</em></p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Việc khắc hoạ một gia đ&igrave;nh đậm chất S&agrave;i G&ograve;n c&ograve;n ở c&aacute;ch xưng h&ocirc; v&agrave; n&oacute;i chuyện với nhau, &ldquo;ba&rdquo; - &ldquo;tui&rdquo; c&oacute; lẽ l&agrave; hai từ th&acirc;n thương nhất m&agrave; mỗi người con miền Nam khi nghe thấy đều nhớ về gia đ&igrave;nh m&igrave;nh. Ngo&agrave;i ra do c&oacute; b&agrave;n tay của đạo diễn Vũ Ngọc Đ&atilde;ng n&ecirc;n những c&uacute; m&aacute;y của phim dường như ch&iacute;nh đ&ocirc;i mắt của ch&uacute;ng ta đang quan s&aacute;t gia đ&igrave;nh nhỏ của Ba Sang. Ấn tượng nhất c&oacute; lẽ l&agrave; những c&uacute; m&aacute;y oneshot d&agrave;i 5-7 ph&uacute;t m&agrave; &iacute;t ai nhận ra, quả thực những c&uacute; m&aacute;y n&agrave;y nếu để &yacute; r&otilde; bạn sẽ thấy được sự ăn &yacute; cũng như kh&eacute;o l&eacute;o của to&agrave;n bộ diễn vi&ecirc;n v&agrave; cameraman.</p>
            <p class="embed-responsive embed-responsive-16by9" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; position: relative; width: 744px; padding: 0px; overflow: hidden; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;"><iframe id="912589160" style="box-sizing: border-box; border-width: 0px; border-style: initial; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; position: absolute; top: 0px; bottom: 0px; left: 0px; width: 744px; height: 418.5px;" src="https://www.youtube.com/embed/jluSu8Rw6YE?autoplay=0&amp;rel=0&amp;enablejsapi=1&amp;origin=https%3A%2F%2Fmomo.vn" allowfullscreen="" data-gtm-yt-inspected-10104547_111="true" data-gtm-yt-inspected-1_19="true"></iframe></p>
            <h2 id="kich-ban-bo-gia" class="ckemm_title_spy" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-size: 1.75rem; margin: 3rem 0px 1rem; scroll-margin-top: 90px; overflow-wrap: break-word; line-height: 2rem; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; letter-spacing: -0.45px; background-color: #ffffff;">Kịch bản</h2>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Vốn dĩ xuất ph&aacute;t điểm từ webdrama, nhưng Trấn Th&agrave;nh vẫn kh&eacute;o l&eacute;o để bộ phim c&oacute; nhiều t&iacute;nh chất điện ảnh nhất c&oacute; thể. Nhưng việc tạo t&igrave;nh tiết để ph&aacute;t triển bộ phim lại v&ocirc; t&igrave;nh mang đến một mạch phim c&oacute; qu&aacute; nhiều n&uacute;t thắt m&agrave; kịch bản kh&ocirc;ng thể giải quyết thỏa m&atilde;n cho người xem.&nbsp;</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150112-637511580722344624.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Nh&igrave;n vậy chứ kh&oacute; chịu lắm &agrave;</em></p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Mở đầu phim rất nhẹ nh&agrave;ng, c&aacute;c nh&acirc;n vật ch&iacute;nh l&agrave;m c&ocirc;ng việc của m&igrave;nh cảm gi&aacute;c y&ecirc;n b&igrave;nh ngự trị trong khu x&oacute;m ngh&egrave;o ngập nước. Dần dần c&aacute;c nh&acirc;n vật c&oacute; đ&oacute;ng g&oacute;p th&ecirc;m v&agrave;o c&acirc;u chuyện dần được giới thiệu. Đ&acirc;y l&agrave; một cấu tr&uacute;c cơ bản của mọi bộ phim v&agrave; Bố Gi&agrave; l&agrave;m tốt điều n&agrave;y, nhưng khi đ&atilde; đi được đến giữa phim th&igrave; c&acirc;u chuyện bẻ l&aacute;i sang hướng kh&aacute;c. Những drama được nối tiếp th&ecirc;m v&agrave;o, đẩy nhịp phim l&ecirc;n cao khi những m&acirc;u thuẫn giữa Ba Sang v&agrave; Quắn ng&agrave;y c&agrave;ng lớn, phim qu&aacute; tập trung v&agrave;o việc thể hiện c&aacute; t&iacute;nh của hai người m&agrave; qu&ecirc;n mất bồi đắp những nh&acirc;n vật phụ, ở đ&acirc;y c&oacute; thể nhắc đến đ&oacute; l&agrave; B&ugrave; Tọt - nh&acirc;n vật sẽ nối hai cha con nh&agrave; Ba Sang lại.&nbsp;</p>
            <div class="text-center" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; text-align: center; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">
            </div>';

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
                    'trailer' =>  $dataUrlYoutube[array_rand($dataUrlYoutube)],
                    'movie_length' => 120,
                    'rated' => 16,
                    'status' => random_int(1, 2),
                ]);
                $movie_id = $movie->id;

                for ($j = 1; $j < 2; $j++) {
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