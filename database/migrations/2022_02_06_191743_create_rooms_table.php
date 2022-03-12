<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('cinema_id')->unsigned();
            $table->bigInteger('format_movie_id')->unsigned();
            $table->string('name');
            $table->tinyInteger('row_number');
            $table->tinyInteger('column_number');
            $table->string('status');
            $table->timestamps();

            $table->foreign('cinema_id')->references('id')->on('cinemas')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('format_movie_id')->references('id')->on('format_movies')
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
        Schema::dropIfExists('rooms');
    }
}
