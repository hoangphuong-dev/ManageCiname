<?php

namespace Database\Seeders;

use App\Models\Cast;
use App\Models\CastMovie;
use App\Models\Cinema;
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
            '<p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;"><span style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-weight: 600;">K???ch b???n B??? Gi&agrave;</span>&nbsp;???????c ch???p b&uacute;t b???i ch&iacute;nh&nbsp;<span style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-weight: 600;">Tr???n Th&agrave;nh, ?????o di???n b???i V?? Ng???c ??&atilde;ng</span>. Phim mang ti&ecirc;u ch&iacute; ho&agrave;n to&agrave;n kh&aacute;c kh&ocirc;ng ?????t n???ng v???n ????? c??m &aacute;o g???o ti???n nh?? webdrama tr?????c ??&oacute; m&agrave; t???p trung v&agrave;o nh???ng c&acirc;u chuy???n gia ??&igrave;nh c???a Ba Sang - Qu???n - B&ugrave; T???t.</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150001-637511580015634364.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Poster ch&iacute;nh th???c c???a B??? Gi&agrave;</em></p>
            <h2 id="mau-sac-hinh-anh" class="ckemm_title_spy" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-size: 1.75rem; margin: 3rem 0px 1rem; scroll-margin-top: 90px; overflow-wrap: break-word; line-height: 2rem; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; letter-spacing: -0.45px; background-color: #ffffff;">M&agrave;u s???c v&agrave; h&igrave;nh ???nh</h2>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Nh??? nh&agrave;ng v&agrave; ???m &aacute;p ??&oacute; l&agrave; nh???ng c???m quan m&agrave; B??? Gi&agrave; ??em l???i cho ng?????i xem xuy&ecirc;n su???t b??? phim. B&ecirc;n c???nh ??&oacute; x&oacute;m ngh&egrave;o quanh n??m ng???p n?????c c&ugrave;ng m&oacute;n c??m s?????n c??ng l&agrave; ?????c tr??ng c???a S&agrave;i G&ograve;n thu nh???, nh???ng c&aacute;nh c???a c?? m&egrave;m c&ugrave;ng h&agrave;ng x&oacute;m lu&ocirc;n lu&ocirc;n ng???i tr?????c c???a l&agrave; ??i???m nh???n kh&oacute; phai m???i khi b?????c v&agrave;o con h???m n&agrave;o ??&oacute;.&nbsp;&nbsp;</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150036-637511580365322410.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Ba Sang trong B??? Gi&agrave; v???i t&ocirc;ng m&agrave;u ???m n&oacute;ng.</em></p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">Vi???c kh???c ho??? m???t gia ??&igrave;nh ?????m ch???t S&agrave;i G&ograve;n c&ograve;n ??? c&aacute;ch x??ng h&ocirc; v&agrave; n&oacute;i chuy???n v???i nhau, &ldquo;ba&rdquo; - &ldquo;tui&rdquo; c&oacute; l??? l&agrave; hai t??? th&acirc;n th????ng nh???t m&agrave; m???i ng?????i con mi???n Nam khi nghe th???y ?????u nh??? v??? gia ??&igrave;nh m&igrave;nh. Ngo&agrave;i ra do c&oacute; b&agrave;n tay c???a ?????o di???n V?? Ng???c ??&atilde;ng n&ecirc;n nh???ng c&uacute; m&aacute;y c???a phim d?????ng nh?? ch&iacute;nh ??&ocirc;i m???t c???a ch&uacute;ng ta ??ang quan s&aacute;t gia ??&igrave;nh nh??? c???a Ba Sang. ???n t?????ng nh???t c&oacute; l??? l&agrave; nh???ng c&uacute; m&aacute;y oneshot d&agrave;i 5-7 ph&uacute;t m&agrave; &iacute;t ai nh???n ra, qu??? th???c nh???ng c&uacute; m&aacute;y n&agrave;y n???u ????? &yacute; r&otilde; b???n s??? th???y ???????c s??? ??n &yacute; c??ng nh?? kh&eacute;o l&eacute;o c???a to&agrave;n b??? di???n vi&ecirc;n v&agrave; cameraman.</p>
            <p class="embed-responsive embed-responsive-16by9" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; position: relative; width: 744px; padding: 0px; overflow: hidden; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;"><iframe id="912589160" style="box-sizing: border-box; border-width: 0px; border-style: initial; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; position: absolute; top: 0px; bottom: 0px; left: 0px; width: 744px; height: 418.5px;" src="https://www.youtube.com/embed/jluSu8Rw6YE?autoplay=0&amp;rel=0&amp;enablejsapi=1&amp;origin=https%3A%2F%2Fmomo.vn" allowfullscreen="" data-gtm-yt-inspected-10104547_111="true" data-gtm-yt-inspected-1_19="true"></iframe></p>
            <h2 id="kich-ban-bo-gia" class="ckemm_title_spy" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; font-size: 1.75rem; margin: 3rem 0px 1rem; scroll-margin-top: 90px; overflow-wrap: break-word; line-height: 2rem; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; letter-spacing: -0.45px; background-color: #ffffff;">K???ch b???n</h2>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">V???n d?? xu???t ph&aacute;t ??i???m t??? webdrama, nh??ng Tr???n Th&agrave;nh v???n kh&eacute;o l&eacute;o ????? b??? phim c&oacute; nhi???u t&iacute;nh ch???t ??i???n ???nh nh???t c&oacute; th???. Nh??ng vi???c t???o t&igrave;nh ti???t ????? ph&aacute;t tri???n b??? phim l???i v&ocirc; t&igrave;nh mang ?????n m???t m???ch phim c&oacute; qu&aacute; nhi???u n&uacute;t th???t m&agrave; k???ch b???n kh&ocirc;ng th??? gi???i quy???t th???a m&atilde;n cho ng?????i xem.&nbsp;</p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff; text-align: center;"><span class="block cursor-pointer " style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; cursor: pointer;"><img class="mx-auto mt-8 mb-2" style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; display: block; vertical-align: middle; max-width: 100%; height: auto !important; margin: 0px auto;" src="https://static.mservice.io/blogscontents/momo-upload-api-210312150112-637511580722344624.jpg" loading="lazy" /></span><em style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px;">Nh&igrave;n v???y ch??? kh&oacute; ch???u l???m &agrave;</em></p>
            <p style="box-sizing: border-box; border: 0px solid #e5e5e5; --tw-translate-x: 0; --tw-translate-y: 0; --tw-rotate: 0; --tw-skew-x: 0; --tw-skew-y: 0; --tw-scale-x: 1; --tw-scale-y: 1; --tw-scroll-snap-strictness: proximity; --tw-ring-offset-width: 0px; --tw-ring-offset-color: #fff; --tw-ring-color: rgba(59,130,246,0.5); --tw-ring-offset-shadow: 0 0 #0000; --tw-ring-shadow: 0 0 #0000; --tw-shadow: 0 0 #0000; --tw-shadow-colored: 0 0 #0000; --header-height: 52px; --header-sticky-mb: 52px; margin: 0px 0px 1em; color: rgba(0, 0, 0, 0.85); font-family: -apple-system, BlinkMacSystemFont, Inter, sans-serif; font-size: 18px; letter-spacing: -0.45px; background-color: #ffffff;">M??? ?????u phim r???t nh??? nh&agrave;ng, c&aacute;c nh&acirc;n v???t ch&iacute;nh l&agrave;m c&ocirc;ng vi???c c???a m&igrave;nh c???m gi&aacute;c y&ecirc;n b&igrave;nh ng??? tr??? trong khu x&oacute;m ngh&egrave;o ng???p n?????c. D???n d???n c&aacute;c nh&acirc;n v???t c&oacute; ??&oacute;ng g&oacute;p th&ecirc;m v&agrave;o c&acirc;u chuy???n d???n ???????c gi???i thi???u. ??&acirc;y l&agrave; m???t c???u tr&uacute;c c?? b???n c???a m???i b??? phim v&agrave; B??? Gi&agrave; l&agrave;m t???t ??i???u n&agrave;y, nh??ng khi ??&atilde; ??i ???????c ?????n gi???a phim th&igrave; c&acirc;u chuy???n b??? l&aacute;i sang h?????ng kh&aacute;c. Nh???ng drama ???????c n???i ti???p th&ecirc;m v&agrave;o, ?????y nh???p phim l&ecirc;n cao khi nh???ng m&acirc;u thu???n gi???a Ba Sang v&agrave; Qu???n ng&agrave;y c&agrave;ng l???n, phim qu&aacute; t???p trung v&agrave;o vi???c th??? hi???n c&aacute; t&iacute;nh c???a hai ng?????i m&agrave; qu&ecirc;n m???t b???i ?????p nh???ng nh&acirc;n v???t ph???, ??? ??&acirc;y c&oacute; th??? nh???c ?????n ??&oacute; l&agrave; B&ugrave; T???t - nh&acirc;n v???t s??? n???i hai cha con nh&agrave; Ba Sang l???i.&nbsp;</p>
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
    }
}
