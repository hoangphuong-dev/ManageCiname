<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

    public const NOT_PAYMENT = 0;
    public const PAYMENTED = 1;

    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cinema()
    {
        return $this->belongsTo(Cinema::class);
    }
    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
    public function voucher()
    {
        return $this->hasOne(Voucher::class);
    }
}