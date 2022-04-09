<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const NOTUSED = 0;
    public const USED = 1;

    public function bill()
    {
        return $this->belongsTo(Bill::class);
    }
}
