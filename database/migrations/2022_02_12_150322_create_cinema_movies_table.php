<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCinemaMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cinema_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cinema_id')->unsigned();
            $table->bigInteger('movie_id')->unsigned();

            $table->foreign('cinema_id')->references('id')->on('cinemas')
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
        Schema::dropIfExists('cinema_movies');
    }
}
