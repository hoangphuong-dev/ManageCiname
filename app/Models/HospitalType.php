<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HospitalType extends Model
{
    use HasFactory;

    protected $table = 'hospital_types';

    protected $fillable = [
        'id',
        'name',
    ];

    public function hospitalInfos()
    {
        return $this->hasMany(HospitalInfo::class);
    }
}
