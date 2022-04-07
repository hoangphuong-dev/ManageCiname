<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMemberCardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('member_cards', function (Blueprint $table) {
            $table->id();
            $table->integer('number_card')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->tinyInteger('role')->unsigned()->comment('0: Nomal, 1: Vip')->default(0);
            $table->bigInteger('accumulating_point')->unsigned()->default(0);
            $table->bigInteger('used_point')->unsigned()->default(0);
            $table->tinyInteger('status')->comment('0: DeActive, 1: active')->default(1);

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
        Schema::dropIfExists('member_cards');
    }
}
