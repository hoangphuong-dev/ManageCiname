<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobApplyStatus extends Model
{
    use HasFactory;

    public const PENDING = 0;
    public const SUCCESS = 1;
    public const REJECT = 2;

    protected $guarded = [];

    protected $casts = [
        'created_at'  => 'date:Y/m/d H:i',
        'updated_at' => 'date:Y/m/d H:i',
    ];

    public function jobPostApply()
    {
        return $this->hasMany(JobPostApply::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTextStatusAttribute()
    {
        switch ($this->status) {
            case self::PENDING:
                return 'pending';
            case self::SUCCESS:
                return 'done';
            case self::REJECT:
                return 'reject';
        }
    }
}
