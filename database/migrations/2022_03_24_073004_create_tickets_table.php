<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTicketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('bill_id')->unsigned();
            $table->bigInteger('show_time_id')->unsigned();
            $table->bigInteger('seat_id')->unsigned();
            $table->integer("price");
            $table->unique(array('show_time_id', 'seat_id'));

            $table->foreign('bill_id')->references('id')->on('bills')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('show_time_id')->references('id')->on('show_times')
                ->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('seat_id')->references('id')->on('seats')
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
        Schema::dropIfExists('tickets');
    }
}
