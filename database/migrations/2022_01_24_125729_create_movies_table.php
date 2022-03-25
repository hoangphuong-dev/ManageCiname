<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('director');
            $table->text('description');
            $table->string('trailler');
            $table->smallInteger('movie_length');
            $table->smallInteger('rated')->comment('Giới hạn tuổi');
            $table->tinyInteger('status')->comment('0: deactive , 1 : active');
            $table->timestamps();
        });

        Schema::create('movie_genre_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('movie_genre_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();
            $table->unique(array('movie_genre_id', 'movie_id'));


            $table->foreign('movie_genre_id')->references('id')->on('movie_genres')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('movie_id')->references('id')->on('movies')
                ->onUpdate('cascade')->onDelete('cascade');
        });

        Schema::create('movie_format_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('format_movie_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();
            $table->unique(array('format_movie_id', 'movie_id'));

            $table->foreign('format_movie_id')->references('id')->on('format_movies')
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
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('movie_format_movies');
        Schema::dropIfExists('movie_genre_movies');
        Schema::dropIfExists('movies');
    }
}
