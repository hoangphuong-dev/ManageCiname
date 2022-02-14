<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;
    public const CARETAKER_NOT_INFO = 0;
    public const CARETAKER_FULL_INFO = 1;

    protected $table = 'user_infos';

    protected $guarded = [];

    protected $casts = [
        'gender' => 'integer',
        'type_of_work' => 'integer',
    ];

    public function getAgeAttribute()
    {
        return Carbon::now()->format('Y') - Carbon::parse($this->birthday)->format('Y');
    }

    public function getGenderAttribute($val)
    {
        switch ($val) {
            case 1:
                return '男性';
            case 2:
                return 'Female';
            default:
                return 'Unknow';
        }
    }

    public function getTypeOfWorkAttribute($val)
    {
        switch ($val) {
            case 0:
                return 'Part time';
            case 1:
                return 'Full time';
            default:
                return 'Unknow';
        }
    }
}
