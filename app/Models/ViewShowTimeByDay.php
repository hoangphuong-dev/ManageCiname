<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewShowTimeByDay extends Model
{
    use HasFactory;

    protected $table = 'view_showtime_by_day';

    protected $guarded = [];
}
