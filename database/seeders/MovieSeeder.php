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
            'https://www.youtube.com/watch?v=HGh9TLkUG9k',
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
                    'description' => $faker->text,
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
