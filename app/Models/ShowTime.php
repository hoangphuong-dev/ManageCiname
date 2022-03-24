<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowTime extends Model
{
    use HasFactory;

    protected $guarded = [];

    public $timestamps = false;

    // public function cinema()
    // {
    //     return $this->hasOne(Cinema::class);
    // }

    public function room()
    {
        return $this->belongsTo(Room::class);
    }
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }
}
