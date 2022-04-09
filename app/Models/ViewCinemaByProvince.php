<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ViewCinemaByProvince extends Model
{
    use HasFactory;

    protected $table = 'view_cinema_by_province';

    protected $guarded = [];
}
