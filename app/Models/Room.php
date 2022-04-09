<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_CLOSE = 0;
    public const STATUS_OPEN = 1;


    // public function cinemas()
    // {
    //     return $this->hasMany(ShowTime::class);
    // }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
