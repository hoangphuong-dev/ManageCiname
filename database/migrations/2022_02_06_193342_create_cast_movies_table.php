<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCastMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cast_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("cast_id")->unsigned();
            $table->bigInteger("movie_id")->unsigned();
            // $table->unique('cast_id', 'movie_id');

            $table->foreign('cast_id')->references('id')->on('casts')
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
        Schema::dropIfExists('cast_movies');
    }
}
