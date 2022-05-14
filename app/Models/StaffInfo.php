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

    public function updateStatus($id, $status)
    {
        $status == self::STATUS_NOT_APPROVED ?
            $status = self::STATUS_WORKING :
            $status = self::STATUS_RESIGN;

        return $this->where('id', $id)->update([
            'status' => $status,
        ]);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
