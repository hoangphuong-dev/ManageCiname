<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MemberCard extends Model
{
    use HasFactory;

    protected $guarded = [];

    public const ROLE_NOMAL = 0;
    public const ROLE_VIP = 1;
    public const POINT_VIP = 500000;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
