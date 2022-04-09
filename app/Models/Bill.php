<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;

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
