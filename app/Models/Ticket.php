<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }

    public function showtime()
    {
        return $this->belongsTo(ShowTime::class, 'show_time_id', 'id');
    }

    public function seat()
    {
        return $this->belongsTo(Seat::class);
    }
}
