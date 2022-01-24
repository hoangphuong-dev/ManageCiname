<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovieGenreMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movie_genre_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('movie_genre_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();

            $table->timestamps();

            $table->foreign('movie_genre_id')->references('id')->on('movie_genres')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')
                ->onUpdate('cascade')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movie_genre_movies');
    }
}
