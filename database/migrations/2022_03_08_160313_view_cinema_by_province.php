<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ViewCinemaByProvince extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        \DB::statement($this->createView());
    }

    private function createView(): string
    {
        return <<<SQL
            CREATE VIEW view_cinema_by_province AS
                SELECT 
                provinces.*,
                COUNT(*) as count_cinema
                FROM `cinemas`
                JOIN provinces on provinces.id = cinemas.province_id
                GROUP by id, name;
            SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('view_cinema_by_province');
    }
}
