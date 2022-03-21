<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieGenre extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;


    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'movie_genre_movies', 'movie_genre_id', 'movie_id');
    }
}
