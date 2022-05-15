<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffInfo extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const STATUS_NOT_APPROVED = 0;
    public const STATUS_WORKING = 1;
    public const STATUS_RESIGN = 2;

    public $timestamps = false;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
}
