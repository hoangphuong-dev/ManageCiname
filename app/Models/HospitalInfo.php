<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class HospitalInfo extends Model
{
    use HasFactory;

    protected $table = 'hospital_infos';

    protected $guarded = [];

    protected $casts = [
        'image' => 'array'
    ];

    public function hospitalType()
    {
        return $this->belongsTo(HospitalType::class);
    }

    /**
     * @return array
     */
    public function getImagesUrlAttribute()
    {
        $images = array_map(function ($image) {
            return Storage::url($image);
        }, $this->image);

        return $images;
    }
}
