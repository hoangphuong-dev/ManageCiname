<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;

    public const DELIVERED_STATUS = 1;
    public const PENDING_STATUS = 0;

    protected $casts = [
        'status' => 'boolean',
        'created_at'  => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
        'schedule' => 'date:Y/m/d H:i',
    ];

    protected $guarded = [];


    public function notificationManager()
    {
        return $this->hasMany(NotificationManage::class);
    }
}
