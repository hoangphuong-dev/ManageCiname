<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const MOVIE_ACTIVE = 1;
    public const MOVIE_DEACTIVE = 2;


    public function showtimes()
    {
        return $this->hasMany(ShowTime::class);
    }

    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class, 'cinema_movies', 'cinema_id', 'movie_id');
    }

    public function cinemaMovie()
    {
        return $this->hasMany(CinemaMovie::class);
    }

    public function casts()
    {
        return $this->belongsToMany(Cast::class, 'cast_movies', 'cast_id', 'movie_id');
    }

    public function movie_genres()
    {
        return $this->belongsToMany(MovieGenre::class, 'movie_genre_movies', 'movie_genre_id', 'movie_id');
    }

    public function comments()
    {
        return $this->hasMany(CommentMovie::class);
    }
}