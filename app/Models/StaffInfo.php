<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_NOT_APPROVED = 1;
    public const STATUS_WORKING = 2;
    public const STATUS_RESIGN = 3;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
