<?php

namespace App\Imports;

use App\Models\Cast;
use App\Models\CastMovie;
use App\Models\Cinema;
use App\Models\CinemaMovie;
use App\Models\FormatMovie;
use App\Models\Movie;
use App\Models\MovieFormatMovie;
use App\Models\MovieGenre;
use App\Models\MovieGenreMovie;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MovieImport implements WithHeadingRow, ToCollection
{
    public function collection(Collection $rows)
    {
        try {
            DB::beginTransaction();
            foreach ($rows as $row) {
                $movie = Movie::create([
                    'name' => $row['name'],
                    'director' => $row['director'],
                    'description' => $row['description'],
                    'trailer' => $row['trailer'],
                    'movie_length' => $row['movie_length'],
                    'rated' => $row['rated'],
                    'status' => Movie::MOVIE_DEACTIVE,
                ]);

                $this->addDataCast(explode(",", $row['casts']), $movie->id);
                $this->addDataMovieGenre(explode(",", $row['movie_genres']), $movie->id);
                $this->addDataFormatMovie(explode(",", $row['format_movies']), $movie->id);
                $this->addDataCinemaMovie($movie->id);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    public function addDataCinemaMovie($movie_id)
    {
        $cinemas = Cinema::select('id')->get();
        foreach ($cinemas as $item) {
            CinemaMovie::create(['cinema_id' => $item->id, 'movie_id' => $movie_id]);
        }
    }


    public function checkCast($name)
    {
        return Cast::where('name', $name)->first();
    }

    public function checkMovieGenre($name)
    {
        return MovieGenre::where('name', $name)->first();
    }

    public function checkFormat($name)
    {
        return FormatMovie::where('name', $name)->first();
    }

    public function addDataCast($data, $movie_id)
    {
        foreach ($data as $item) {
            $check = $this->checkCast($item);
            if ($check == null) {
                $cast = Cast::create(['name' => $item]);
                CastMovie::create(['cast_id' => $cast->id, 'movie_id' => $movie_id]);
            } else {
                CastMovie::create(['cast_id' => $check->id, 'movie_id' => $movie_id]);
            }
        }
    }

    public function addDataMovieGenre($data, $movie_id)
    {
        foreach ($data as $item) {
            $check = $this->checkMovieGenre($item);
            if ($check == null) {
                $movie_genre = MovieGenre::create(['name' => $item]);
                MovieGenreMovie::create(['movie_genre_id' => $movie_genre->id, 'movie_id' => $movie_id]);
            } else {
                MovieGenreMovie::create(['movie_genre_id' => $check->id, 'movie_id' => $movie_id]);
            }
        }
    }

    public function addDataFormatMovie($data, $movie_id)
    {
        foreach ($data as $item) {
            $check = $this->checkFormat($item);
            if ($check == null) {
                $format_movie = FormatMovie::create(['name' => $item]);
                MovieFormatMovie::create(['format_movie_id' => $format_movie->id, 'movie_id' => $movie_id]);
            } else {
                MovieFormatMovie::create(['format_movie_id' => $check->id, 'movie_id' => $movie_id]);
            }
        }
    }
}
