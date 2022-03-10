<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateViewShowtimeByDay extends Migration
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
            CREATE VIEW view_showtime_by_day AS
               SELECT 
                movies.name,
                movies.trailler,
                movie_id,
                rooms.cinema_id,
                DATE_FORMAT(time_start, "%d-%m-%Y") as day,
                count(*) as sum_show_time
                from show_times
                join movies on movies.id = show_times.movie_id
                JOIN rooms on rooms.id = show_times.room_id
                GROUP BY movie_id, day, cinema_id;
            SQL;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        \DB::statement("DROP VIEW IF EXISTS view_showtime_by_day");
    }
}
