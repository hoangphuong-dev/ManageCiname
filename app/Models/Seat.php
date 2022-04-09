<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Seat extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected function seatName(): Attribute
    {
        return new Attribute(
            get: fn ($value, $attributes): string => join('', [$attributes['row_name'], $attributes['columns_number']]),
        );
    }

    public function seat_type()
    {
        return $this->belongsTo(SeatType::class);
    }
}
