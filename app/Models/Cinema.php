<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cinema extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function movies()
    {
        return $this->belongsToMany(Movie::class, 'cinema_movies', 'cinema_id', 'movie_id');
    }

    public function cinemaMovie()
    {
        return $this->hasMany(CinemaMovie::class);
    }
}
