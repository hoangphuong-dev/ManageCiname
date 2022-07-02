<?php

namespace App\Models\Filters;

use App\Helper\FormatDate;
use App\Models\Movie;
use App\Models\MovieGenreMovie;
use App\Models\ShowTime;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class MovieFilters implements Filters
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getQuery(Builder $query): Builder
    {
        $this->filterByName($query);
        $this->filterByStatus($query);
        $this->filterByDisplay($query);
        $this->filterByMovieGenre($query);

        return $query;
    }

    /**
     * Apply filter by name
     *
     * @param  Builder $query
     * @return void
     */

    public function filterByName(Builder $query): void
    {
        $query->when($this->request->query('name'), function (Builder $q, $name) {
            $q->where('name', 'LIKE', "%{$name}%");
        });
    }


    /**
     * Apply filter by status
     *
     * @param  Builder $query
     * @return void
     */

    public function filterByStatus(Builder $query): void
    {
        $query->when($this->request->query('status'), function (Builder $q, $status) {
            $q->where('status', $status);
        });
    }
    /**
     * Apply filter by page display
     *
     * @param  Builder $query
     * @return void
     */
    public function filterByMovieGenre(Builder $query): void
    {
        $query->when($this->request->query('movie_genre'), function (Builder $q, $movieGenre) {
            $movieId = MovieGenreMovie::query()->where('movie_genre_id', $movieGenre)
                ->get('movie_id')->pluck('movie_id')->toArray();

            $q->whereIn('id', $movieId);
        });
    }

    /**
     * Apply filter by page display
     *
     * @param  Builder $query
     * @return void
     */

    public function filterByDisplay(Builder $query): void
    {

        $query->when($this->request->query('display'), function (Builder $q, $display) {
            if ($display == 1) {
                $q->whereIn('id', self::getMovieIdNowShowing())
                    ->where('status', Movie::MOVIE_ACTIVE);
            } elseif ($display == 2) {
                $q->whereNotIn('id', self::getMovieIdNowShowing());
            }
        });
    }

    // get movie_id in now showing
    public static function getMovieIdNowShowing()
    {
        $timeNowShowing = [Carbon::now()->format('Y-m-d'), FormatDate::getFourteenDay()];

        $movieId = ShowTime::query()
            ->whereBetween('time_start', $timeNowShowing)
            ->get('movie_id')->pluck('movie_id')->toArray();

        return $movieId;
    }
}