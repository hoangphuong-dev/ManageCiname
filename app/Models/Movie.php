<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const MOVIE_ACTIVE = 1;
    public const MOVIE_DEACTIVE = 0;

    public function cinemas()
    {
        return $this->belongsToMany(Cinema::class, 'cinema_movies', 'cinema_id', 'movie_id');
    }

    public function cinemaMovie()
    {
        return $this->hasMany(CinemaMovie::class);
    }
}
