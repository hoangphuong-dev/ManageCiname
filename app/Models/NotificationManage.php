<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationManage extends Model
{
    use HasFactory;

    public const TYPE_CARETAKER = 'CARETAKER';
    public const TYPE_HOSPITAL = 'HOSPITAL';
    public const TYPE_ALL = 'ALL';


    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
