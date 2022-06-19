<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comment_movies', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('movie_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('parent_id')->unsigned()->comment('0: comment đầu tiên , p : id của comment cha');
            $table->text('content');

            $table->foreign('movie_id')->references('id')->on('movies')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comment_movies');
    }
}